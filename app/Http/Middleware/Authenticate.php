<?php

namespace App\Http\Middleware;

use Closure;
use App\Lib\AuthUser;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    private $helper;

    private $whiteList = [
        'api/login',
        'api/login-callback',
        'api/login-redirect',
        'api/debug',
    ];

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
        $uri = $request->path();

        if (!in_array($uri, $this->whiteList)) {
            if (!AuthUser::check()) {
                return $this->helper->sendJson(401, '需要登录');
            }
        }

        return $next($request);
    }
}
