<?php

namespace App\Models;

use Helper;
use DB;

class Member extends BaseModel
{
    public static function getUserInfo($where, $field = [])
    {
        if (empty($field)) {
            $field = "*";
        }

        return DB::table('t_member')->select($field)->where($where)->first();
    }

    public static function loginByOpenId($openid = '')
    {
        $user_data = false;

        // 根据openid获取用户信息
        if ($openid) {
            $user_data = DB::table('t_member')->where('openid', $openid)->first();
        }

        // 判断是否存在
        if (empty($user_data) || $user_data == NULL) {
            return false;
        }

        // 更新用户登录时间
        $updateData = ['logined_at' => date('Y-m-d H:i:s')];

        DB::table('t_member')->where('openid', $openid)->update($updateData);

        return $user_data;
    }
}