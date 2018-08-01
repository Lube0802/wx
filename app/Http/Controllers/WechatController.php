<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Helper;

class WechatController extends BaseController
{
    public function index()
    {
        $app = new Application(config('wechat'));
        $app->server->push(function($message) {
            return '欢迎关注 overtrue';
        });
        return $app->server->serve();
    }
}