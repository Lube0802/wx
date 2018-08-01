<?php

namespace App\Http\Controllers;

use App\Lib\AuthUser;
use App\Models\Member;
use Helper;
use Illuminate\Support\Facades\Input;

class AuthController extends BaseController
{
    public function debug()
    {
        if (env('APP_DEBUG') == true) {
            $user_id = trim(Input::get('id'));

            if (empty($user_id)) {
                return Helper::sendJson(201, '参数错误');
            }

            $user_data = Member::getUserInfo(['id' => $user_id]);

            if ($user_data) {
                AuthUser::login($user_data);
                return Helper::sendJson(200, '登陆成功', $user_data);
            } else {
                return Helper::sendJson(202, '用户不存在');
            }
        } else {
            return Helper::sendJson(203, '非法操作');
        }
    }

    public function logout()
    {
        if (AuthUser::check()) {
            AuthUser::forgot();
            return Helper::sendJson(200, '登出成功');
        } else {
            return Helper::sendJson(201, '未登录');
        }
    }
}