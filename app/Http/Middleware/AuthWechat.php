<?php

namespace App\Http\Middleware;

use Closure;
use App\Lib\AuthUser;

class AuthWechat
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    private $helper;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(\App\Lib\Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // 判断是否为微信浏览器
        if ($this->helper->isWechat() && AuthUser::check() == false) {
            $url = route('login');
            redirect($url);
        }
        return $next($request);
    }
}