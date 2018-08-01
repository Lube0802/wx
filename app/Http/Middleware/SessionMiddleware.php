<?php

namespace App\Http\Middleware;

/**
 * 基于RedisSession的中间件
 * Class SessionMiddleware
 * @package App\Http\Middleware
 */
class SessionMiddleware
{
    public function handle($request, $next)
    {
        $redisSession = new \App\Lib\RedisSession();

        session_set_cookie_params(24*60*60);

        session_set_save_handler($redisSession, true);

        session_start();

        return $next($request);
    }
}