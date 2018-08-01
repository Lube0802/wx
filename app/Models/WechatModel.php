<?php

namespace App\Models;

use Wechat;
use DB;

class WechatModel extends BaseModel
{
    public static function getWechatApiParam($url = '')
    {
        $js = Wechat::getFacadeRoot()->js;

        if (!empty($url)) {
            $js->setUrl($url);
        }

        $params = $js->config(config('js_sdk'), $debug = false, $beta = false, $json = false);

        return $params;
    }
}