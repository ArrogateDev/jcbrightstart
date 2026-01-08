<?php

namespace App\Http\Controllers;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Models\Certificate;
use App\Models\Manage\Role;
use App\Models\News\NewsCategory;
use App\Models\Quiz;
use App\Models\Resource\ResourceCategory;
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
     * 获取测验详情
     * @param Request $request
     * @param Quiz $quiz
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuizDetail(Request $request, Quiz $quiz)
    {
        return $this->responseSuccess($quiz);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNewsCategoryList(Request $request)
    {
        $keyword = $request->query('keyword');

        $list = NewsCategory::query()
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
    public function getResourceCategoryList(Request $request)
    {
        $keyword = $request->query('keyword');

        $list = ResourceCategory::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('id')
            ->select('id', 'title')
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

    public function marker(Request $request)
    {
        $hex = $request->query('hex', '000000');

        // 校验颜色参数
        if (!preg_match('/^[0-9A-Fa-f]{6}$/', $hex)) {
            $hex = '000000'; // 如果颜色格式不正确，使用默认颜色
        }

        $svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
                <svg t="1766460043684" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="200" height="200">
                  <path d="M512 0C294.208 0 117.034667 177.152 117.056 394.922667c0 80.896 24.298667 158.677333 69.781333 224.149333 2.282667 3.925333 4.586667 7.722667 7.296 11.413333l288.277333 379.989333C490.24 1019.2 500.757333 1024 512.021333 1024c11.114667 0 21.696-4.842667 30.848-15.104l286.954667-378.474667c2.837333-3.754667 5.248-7.872 6.570667-10.282667 46.144-66.389333 70.570667-144.256 70.570667-225.173333C906.965333 177.152 729.792 0 512 0zM512 536.170667c-77.781333 0-141.077333-63.296-141.077333-141.098667 0-77.781333 63.296-141.056 141.077333-141.056 77.781333 0 141.077333 63.296 141.077333 141.056C653.077333 472.874667 589.781333 536.170667 512 536.170667z" fill="#' . $hex . '"/>
                </svg>';

        return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Exception
     */
    public function download(Request $request)
    {
        try {
            $file = $request->query('file');
            if (!Storage::exists($file)) {
                throw new \Exception(__('文件不存在'));
            }
            return Storage::download($file);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
