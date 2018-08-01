<?php

namespace App\Http\Middleware;

/**
 * CSRF校验中间件
 * Class CsrfMiddleware
 * @package App\Http\Middleware
 */
class CsrfMiddleware
{
    private $helper;

    private $whiteList = [

    ];

    public function __construct(\App\Lib\Helper $helper)
    {
        $this->helper = $helper;
    }

    public function handle($request, $next)
    {
        $uri = $request->path();

        $token = isset($_COOKIE['token']) ? $_COOKIE['token'] : '';

        if (!in_array($uri, $this->whiteList)) {
            if (!isset($_SESSION['token']) || empty($token) || $token != $_SESSION['token']) {
                return $this->helper->sendJson(402, 'token校验失败');
            }
        }

        return $next($request);
    }
}