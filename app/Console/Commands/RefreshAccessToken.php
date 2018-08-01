<?php

namespace App\Console\Commands;

use EasyWeChat\Foundation\Application;
use Illuminate\Console\Command;
use Helper;

class RefreshAccessToken extends Command
{
    protected $signature = 'refreshtoken';

    protected $description = 'refreshtoken';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $app = new Application(config('wechat'));

        // 获取access token实例
        $accessToken = $app->access_token; // EasyWechat\Core\AccessToken 实例
        $token = $accessToken->getToken(true); // 强制重新从微信服务器获取token
        Helper::log('accesstoken', $token);
        $app['access_token']->setToken($token); // 修改$app的access token
    }
}