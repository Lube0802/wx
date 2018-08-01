<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 生成二维码门面
 * Class QrCodeFacades
 * @package App\Facades
 */
class WechatFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "Wechat";
    }
}