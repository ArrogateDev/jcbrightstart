<?php

namespace App\Http\Controllers\Web\User;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
    {
        return view('web.user.profile');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleSetAvatar(Request $request)
    {
        $user = $request->user('web');
        if (!(($lock = Cache::lock("submit_web_set_avatar_lock:$user->id", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $base64_image = $request->input('avatar');
        if (!preg_match('/^data:image\/(\w+);base64,/', $base64_image, $type)) {
            throw new ApiException(__('Invalid image type'), ResponseCode::PARAM_ERR);
        }

        $data = substr($base64_image, strpos($base64_image, ',') + 1);
        $type = strtolower($type[1]);

        if (!in_array($type, ['jpeg', 'jpg', 'png', 'gif'])) {
            throw new ApiException(__('Invalid image type'), ResponseCode::PARAM_ERR);
        }
        $data = base64_decode($data);

        if ($data === false) {
            throw new ApiException(__('Invalid image type'), ResponseCode::PARAM_ERR);
        }

        try {

            $file_path = 'avatars/' . $user->id . '/';
            $file_name = uniqid() . '.' . $type;

            Storage::put($file_path . $file_name, $data);

            $old_avatar = $user->getRawOriginal('avatar');
            $user->avatar = $file_path . $file_name;
            if ($user->save() === false) {
                throw new \Exception('user:failed', ResponseCode::SERVER_ERR);
            }

            if ($old_avatar && Storage::exists($old_avatar)) {
                Storage::delete($old_avatar);
            }

            return $this->responseSuccess();
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Failure', ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleRemoveAvatar(Request $request)
    {
        $user = $request->user('web');
        if (!(($lock = Cache::lock("submit_web_remove_avatar_lock:$user->id", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {

            $old_avatar = $user->getRawOriginal('avatar');
            $user->avatar = '';
            if ($user->save() === false) {
                throw new \Exception('user:failed', ResponseCode::SERVER_ERR);
            }

            if ($old_avatar && Storage::exists($old_avatar)) {
                Storage::delete($old_avatar);
            }

            return $this->responseSuccess();
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Failure', ResponseCode::SERVER_ERR);
        }
    }
}
