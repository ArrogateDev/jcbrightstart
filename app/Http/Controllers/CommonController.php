<?php

namespace App\Http\Controllers;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Models\Certificate;
use App\Models\Manage\Authority;
use App\Models\Manage\Role;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mews\Captcha\Facades\Captcha;

class CommonController extends Controller
{
    /**
     * 图形验证码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function captcha(Request $request)
    {
        return $this->responseSuccess(Captcha::create($request->input('type', 'admin'), true));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRole(Request $request)
    {
        $admin = $request->user('admin');
        $role_id = $admin->role->id ?? 0;
        $role_level = $admin->role->level ?? 0;

        $list = Role::query()
            ->when($role_id != 1, function ($query) use ($role_level) {
                $query->where('level', '>', $role_level);
            })
            ->orderBy('id')
            ->select('id as value', 'name as label')
            ->get();

        return $this->responseSuccess($list);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuizList(Request $request)
    {
        $keyword = $request->query('keyword');

        $list = Quiz::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('id')
            ->select('id', 'title')
            ->paginate(limit_page());

        return $this->responseSuccess($list);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCertificateList(Request $request)
    {
        $keyword = $request->query('keyword');

        $list = Certificate::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('id')
            ->select('id', 'name as title')
            ->paginate(limit_page());

        return $this->responseSuccess($list);
    }

    /**
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Exception
     */
    public function version(string $type)
    {
        try {

            if (!in_array($type, ['android', 'ios'])) {
                throw new \Exception(__('参数错误'), ResponseCode::PARAM_ERR);
            }

            $directory = "version/$type";
            $files = Storage::files($directory);
            $file = end($files);
            if (!$file) {
                throw new \Exception(__('参数错误'), ResponseCode::PARAM_ERR);
            }

            return Storage::download($file);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
