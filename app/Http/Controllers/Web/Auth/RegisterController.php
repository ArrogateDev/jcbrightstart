<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\RegisterRequest;
use App\Models\User\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{

    public function index()
    {
        return abort(404);
        return view('web.auth.register');
    }

    /**
     * 注册
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleRegister(RegisterRequest $request)
    {
        return abort(404);
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_register_lock:$ip", 30))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['email', 'password', 'first_name', 'last_name']);
        $password = $request->input('password');
        $redirect = $request->input('redirect', route('user.dashboard.html'));
        $code = $request->input('code');

        $ver_code = VerificationCode::check($inputs['email'], 'register', $code);

        try {

            DB::beginTransaction();

            $user = new User();
            foreach ($inputs as $field => $value) {
                $user->$field = $value;
            }

            $user->full_name = $inputs['first_name'] . ' ' . $inputs['last_name'];
            $user->password = $password;
            if ($user->save() === false) {
                throw new \Exception('user:failed');
            }

            Auth::login($user);

            $ver_code->used();

            DB::commit();

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('注册失败'), ResponseCode::SERVER_ERR);
        }
    }
}
