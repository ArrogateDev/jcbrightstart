<?php

namespace App\Services;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class AppleService
{
    private const JWK_CACHE_KEY = 'apple_sign_in_jwks';
    private const JWK_CACHE_TTL = 60 * 60; // 1 hour
    private const TOKEN_ENDPOINT = 'https://appleid.apple.com/auth/token';
    private const JWK_ENDPOINT = 'https://appleid.apple.com/auth/keys';

    private Client $httpClient;

    public function __construct(?Client $client = null)
    {
        $this->httpClient = $client ?? new Client();
    }

    /**
     * 使用授权码向 Apple 交换令牌
     *
     * @throws \Exception
     */
    public function exchangeCode(string $code): array
    {
        $client_id = config('services.apple.client_id');
        $redirectUri = config('services.apple.redirect_uri');

        if (!$client_id || !$redirectUri) {
            throw new \Exception('Apple 登录配置缺失');
        }

        try {
            $response = $this->httpClient->post(self::TOKEN_ENDPOINT, [
                'form_params' => [
                    'client_id' => $client_id,
                    'client_secret' => $this->buildClientSecret(),
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUri,
                ],
            ]);

            $body = (string)$response->getBody();
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

            if (Arr::get($data, 'error')) {
                throw new \Exception('Apple 登录凭据无效: ' . Arr::get($data, 'error'));
            }

            return $data;
        } catch (GuzzleException $exception) {
            throw new \Exception('无法与 Apple 服务器通信');
        } catch (\JsonException $exception) {
            throw new \Exception('Apple 登录返回格式错误');
        }
    }

    /**
     * 校验并解析 Apple ID Token
     *
     * @throws \Exception
     */
    public function verifyIdToken(string $idToken): array
    {
        try {
            $publicKeys = $this->getPublicKeys();
            $payload = (array)JWT::decode($idToken, $publicKeys);

            $this->validateClaims($payload);

            return $payload;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * 生成与 Apple 握手所需的 Client Secret
     */
    private function buildClientSecret(): string
    {
        $teamId = config('services.apple.team_id');
        $client_id = config('services.apple.client_id');
        $keyId = config('services.apple.key_id');
        $privateKey = $this->formatPrivateKey(config('services.apple.private_key'));

        if (!$teamId || !$client_id || !$keyId || !$privateKey) {
            throw new \Exception('Apple 登录配置缺失');
        }

        $time = time();
        $claims = [
            'iss' => $teamId,
            'iat' => $time,
            'exp' => $time + 300,
            'aud' => 'https://appleid.apple.com',
            'sub' => $client_id,
        ];

        $headers = [
            'alg' => 'ES256',
            'kid' => $keyId,
        ];

        return JWT::encode($claims, $privateKey, 'ES256', null, $headers);
    }

    /**
     * @return array<string, \Firebase\JWT\Key>
     * @throws \Exception
     */
    private function getPublicKeys(): array
    {
        $keys = Cache::remember(self::JWK_CACHE_KEY, self::JWK_CACHE_TTL, function () {
            try {
                $response = $this->httpClient->get(self::JWK_ENDPOINT);
                $body = (string)$response->getBody();
                $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

                $keys = Arr::get($data, 'keys');
                if (!is_array($keys)) {
                    throw new \Exception('Apple 公钥获取失败');
                }

                return $keys;
            } catch (GuzzleException $exception) {
                throw new \Exception('无法获取 Apple 公钥');
            } catch (\JsonException $exception) {
                throw new \Exception('Apple 公钥格式错误');
            }
        });

        try {
            return JWK::parseKeySet(['keys' => $keys]);
        } catch (\Throwable $exception) {
            Cache::forget(self::JWK_CACHE_KEY);
            throw new \Exception('Apple 公钥解析失败');
        }
    }

    private function validateClaims(array $payload): void
    {
        $client_id = config('services.apple.client_id');

        if (($payload['iss'] ?? null) !== 'https://appleid.apple.com') {
            throw new \Exception('Apple 登录凭据来源非法');
        }

        if (($payload['aud'] ?? null) !== $client_id) {
            throw new \Exception('Apple 登录凭据受众不匹配');
        }

        $exp = $payload['exp'] ?? null;
        if (!$exp || time() >= (int)$exp) {
            throw new \Exception('Apple 登录凭据已过期');
        }
    }

    private function formatPrivateKey(?string $key): string
    {
        if (!$key) {
            return '';
        }

        if (str_contains($key, '-----BEGIN')) {
            return $key;
        }

        $formatted = trim($key);
        $formatted = chunk_split(str_replace(["\r", "\n"], '', $formatted), 64, "\n");

        return "-----BEGIN PRIVATE KEY-----\n{$formatted}-----END PRIVATE KEY-----";
    }
}

