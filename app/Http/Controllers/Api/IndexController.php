<?php

namespace App\Http\Controllers\Api;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GeminiRequest;
use App\Jobs\TextToSpeechJob;
use App\Models\GeminiLog;
use App\Models\Instruct;
use App\Models\UserGeminiLog;
use App\Models\UserInfo;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    /**
     *
     * @param GeminiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GeminiRequest $request)
    {
        $user = $request->user('user');
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_gemini_store_lock:$user->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $device = $request->header('device');
        $device_id = $request->header('device-id');
        $inputs = $request->only(['model', 'lang', 'tts']);
        $model = $inputs['model'] ?? 0;
        $lang = $inputs['lang'] ?? 0;
        $environment = $inputs['environment'] ?? 0;
        $tts = $inputs['tts'] ?? 0;
        $file = $request->file('file');

        $mime_type = $file->getClientMimeType();
        if (!$file->isValid()) {
            throw new ApiException(__('文件格式错误'), ResponseCode::PARAM_ERR);
        }

        $user_info = UserInfo::init($user->id);
        if ($user_info->usable_num < 1) {
            throw new ApiException(__('餘額不足'), ResponseCode::PARAM_ERR);
        }

        try {

            $info_lock = Cache::lock("user_info_lock:$user_info->id", 360);
            $info_lock->block(60);

            $file_content = file_get_contents($file->getRealPath());
            $base64 = base64_encode($file_content);

            $now = Carbon::now();
            $date = $now->copy()->format('Ymd');
            $extension = $file->getClientOriginalExtension();
            $path = 'files/' . $date;

            $md5_name = md5_file($file->getRealPath()) . $now->copy()->getTimestampMs();
            $filename = $md5_name . '.' . $extension;

            $public_path = $file->storeAs($path, $filename);

            $instruct = Instruct::query()->where('model', $model)->where('environment', $environment)->value('instruct');

            if (empty($instruct)) {
                throw new ApiException(__('未找到指令'), ResponseCode::PARAM_ERR);
            }

            $instruct = sprintf($instruct, $lang === 1 ? '普通話(Mandarin Chinese)' : '廣東話(Cantonese)');

            $params['contents'][] = [
                'parts' => [
                    [
                        'text' => $instruct
                    ],
                    [
                        'inline_data' => [
                            'mime_type' => $mime_type,
                            'data' => $base64
                        ]
                    ]
                ]
            ];

            $headers = [
                'Content-Type' => 'application/json'
            ];

            $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . env('GEMINI_KEY');

            $configs = [];
            if (!empty($proxy = env('APP_PROXY'))) {
                $configs = [
                    'proxy' => $proxy
                ];
            }

            $response = (new Client($configs))->request(
                'POST',
                $url,
                [
                    RequestOptions::HEADERS => $headers,
                    RequestOptions::JSON => $params
                ]
            );

            $result = json_decode($response->getBody(), true);
            Log::channel('gemini')->info($result);

            DB::beginTransaction();

            $log = new GeminiLog();
            $log->user_id = $user->id;
            $log->file = $public_path;
            $log->device = $device ?? '';
            $log->device_id = $device_id ?? '';
            $log->ip = $ip;
            $log->instruct = $instruct;
            $log->result_text = Arr::get($result, 'candidates.0.content.parts.0.text');
            $log->result = $result;
            $log->model = $model;
            $log->lang = $lang;
            $log->environment = $environment;
            $log->tts = $tts;
            $log->status = 0;
            if ($log->save() === false) {
                throw new \Exception('log:failed');
            }

            UserGeminiLog::DecreaseLog($user->id, 1, UserGeminiLog::TYPE_USE, $log->id);

            $user_info->usable_num -= 1;
            if ($user_info->save() === false) {
                throw new \Exception('user_info:failed');
            }

            TextToSpeechJob::dispatchIf($log->tts == 0, $log)->afterCommit();

            DB::commit();

            return $this->responseSuccess($log->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('系统异常'), ResponseCode::SERVER_ERR);
        } finally {
            $info_lock->release();
        }
    }

    /**
     *
     * @param Request $request
     * @param GeminiLog $log
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request, GeminiLog $log)
    {
        $log->append(['file_url', 'result_audio_url']);
        $log->makeHidden(['id', 'user_id', 'file', 'device', 'device_id', 'ip', 'result', 'result_audio', 'model', 'created_at']);

        return $this->responseSuccess($log);
    }
}
