<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Helper;

class WechatController extends BaseController
{
    public function index()
    {
        $app = new Application(config('wechat'));
        return $app->server->serve();
    }
}