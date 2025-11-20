<?php

namespace App\Exceptions;

use App\Constants\ResponseCode;
use App\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param \Throwable $e
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $e)
    {
        if (!($e instanceof ApiException)) {
            parent::report($e);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ApiException) {
            return $this->responseError($e->getMessage(), $e->getCode());
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->responseError('Not Found', ResponseCode::NOT_FOUND);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->responseError('Method not allowed', ResponseCode::METHOD_NOT_ALLOWED);
        }

        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        if ($e instanceof AccessDeniedHttpException) {
            return $this->responseError('非法操作', ResponseCode::ILLEGAL_OPERATION);
        }

        if ($e instanceof ValidationException) {
            return $this->responseError($e->validator->errors()->first(), ResponseCode::PARAM_ERR);
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->responseError('Not Fount Target', ResponseCode::NOT_FOUND);
        }

        if ($e instanceof \Exception) {
            return $this->responseError($e->getMessage(), ResponseCode::FAIL);
        }

        return parent::render($request, $e);
    }

    /**
     * @param $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // 如果是 API 请求（期望 JSON 响应），返回 JSON 错误
        if ($request->expectsJson()) {
            return $this->responseError(__('登录失效'), ResponseCode::UNAUTH);
        }

        // 如果是 admin 路由，重定向到管理员登录页
        if ($request->is('admin/*')) {
            return redirect()->route('admin.login.html');
        }

        // 其他情况返回 JSON 错误
        return $this->responseError(__('登录失效'), ResponseCode::UNAUTH);
    }
}
