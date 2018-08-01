<?php

namespace App\Lib;

/**
 * 用户登录验证
 * Class AuthUser
 * @package App\Lib
 */
class AuthUser
{
    private static $userId;

    private static $userInfo;

    /**
     * 检测用户是否登录
     * @return bool
     */
    public static function check()
    {
        if (empty(self::$userId) || is_null(self::$userId)) {
            self::user();
        }

        return empty(self::$userId) || is_null(self::$userId) ? false : true;
    }

    /**
     * 获取用户信息
     * @return null
     */
    public static function user()
    {
        self::$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

        if (self::$userId) {
            self::$userInfo = $_SESSION['user_data'];
        } else {
            self::$userInfo = null;
        }

        return self::$userInfo;
    }

    /**
     * login
     * 登录
     * @param $user_data
     * @throws
     */
    public static function login($user_data)
    {
        if (!$user_data) {
            throw \Exception('user data is null');
        }

        $_SESSION['user_id'] =  $user_data->id;
        $_SESSION['user_data'] = $user_data;

        self::user();
    }

    /**
     * del
     * 删除属性
     * @param $key
     */
    public static function del($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * 增加属性
     * @param $key
     * @param $value
     */
    public static function add($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * 获取属性
     * @param $key
     * @return null
     */
    public static function take($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * 清理所有session
     */
    public static function forgot()
    {
        session_unset();
        session_destroy();
    }
}