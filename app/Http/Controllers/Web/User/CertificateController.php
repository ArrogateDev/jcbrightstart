<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserCourseCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CertificateController extends Controller
{

    public function index()
    {
        return view('web.user.certificate');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $user = $request->user('web');

        $list = UserCourseCertificate::query()
            ->where('user_id', $user->id)
            ->select('id', 'certificate_name', 'file', 'created_at')
            ->paginate(limit_page());

        $list->append(['file_url']);
        $url = env('APP_URL');
        $list->map(function ($item) use ($url) {
            $item->download_url = $url . URL::temporarySignedRoute(
                    'user.download.html', now()->addDay(), ['file' => $item->file], false
                );
        });

        return $this->responseSuccess($list);
    }
}
