<?php

namespace App\Models;

use App\Constants\ResponseCode;
use Carbon\Carbon;
use Google\ApiCore\ApiException;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Base
{

    /**
     * 检查验证码是否有效
     *
     * @param string $phone
     * @param string $scene
     * @param string $code
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     * @throws ApiException
     */
    public static function check(string $account, string $scene, string $code)
    {
        $ver_code = VerificationCode::query()
            ->where('account', $account)
            ->where('scene', $scene)
            ->where('status', 1)
            ->where('used', 0)
            ->orderByDesc('id')
            ->first();
        if (!$ver_code || $ver_code->code != $code) {
            throw new ApiException(__('验证码错误'), ResponseCode::PARAM_ERR);
        }

        if (Carbon::parse($ver_code->created_at)->diffInSeconds(now()) > 60 * 15) {
            throw new ApiException(__('验证码已过期'), ResponseCode::PARAM_ERR);
        }

        return $ver_code;
    }

    /**
     * 使用验证码
     *
     * @return void
     */
    public function used()
    {
        $this->used = 1;
        $this->used_at = now();
        $this->save();
    }
}
