<?php

namespace App\Http\Controllers;

use App\Models\WechatModel;
use Helper;
use Illuminate\Support\Facades\Input;
use QrCode;

class TestController extends BaseController
{
    public function test()
    {
//        $ip = Helper::getIp();
//        return $ip;
//        $url = 'www.baidu.com';
//        return Qrcode::size(400)->margin(1)->generate($url);
        var_dump($_SESSION);
    }

    public function getWechatParam()
    {
        $url = urldecode(Input::get('url', ''));
        var_dump($url);
        $params = WechatModel::getWechatApiParam($url);

        return Helper::sendJson(200, 'ok', $params);
    }
}