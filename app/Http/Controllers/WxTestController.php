<?php

namespace App\Http\Controllers;

use App\Lib\AuthUser;
use App\Models\WechatModel;
use EasyWeChat\Foundation\Application;
use Helper;
use Illuminate\Support\Facades\Input;
use Overtrue\Socialite\AuthorizeFailedException;

class WxTestController extends BaseController
{
    public function login()
    {
        // 接收参数return_url
        $return_url = Input::get('return_url');
        // 判断return_url是否存在
        // 如果return_url不存在但$_SERVER中有$_SERVER['HTTP_REFERER']，则取$_SERVER['HTTP_REFERER']
        // 如果return_url不存在且$_SERVER中没有$_SERVER['HTTP_REFERER']，则判断session中是否有return_url，有则取，没有则$return_url = '/'
        if (!$return_url && array_key_exists('HTTP_REFERER', $_SERVER)) {
            $return_url = $_SERVER['HTTP_REFERER'];
        } elseif (!$return_url && !array_key_exists('HTTP_REFERER', $_SERVER)) {
            $return_url = AuthUser::take('return_url') ? AuthUser::take('return_url') : '/';
        }
        // 判断是否登录，若已登录，则直接跳回$return_url，若未登录，则获取微信授权
        if (!AuthUser::check()) {
            // 保存$return_url到session，授权处理成功后跳转使用
            AuthUser::add('return_url', $return_url);
            $app = new Application(config('wechat'));
            $oauth = $app->oauth;
            return $oauth->redirect();
        } else {
            if (!$return_url) {
                $return_url = "/";
            }
            AuthUser::del('return_url');
            return redirect($return_url);
        }
    }

    public function loginCallback()
    {
        $code = trim(Input::get('code'));
        $state = trim(Input::get('state'));
        // 加载静态页，防止用户二次授权
        return view('wechat.logincallback', ['code' => $code, 'state' => $state]);
    }

    public function loginRedirect()
    {
        try {
            // 获取并判断参数是否正确
            $code = trim(Input::get('code'));
            $state = trim(Input::get('state'));
            if (!$code || !$state) {
                return Helper::sendJson(509, 'code or state error');
            }
            // 从session中取出wechat_info
            $wechat_info = AuthUser::take('wechat_info');
            // 判断$wechat_info是否存在，如果不存在，授权操作
            if (!$wechat_info || !$wechat_info->getId()) {
                $app = new Application(config('wechat'));
                $oauth = $app->oauth;
                $wechat_info = $oauth->user();
                // 如果还没有获取到用户信息
                if (!$wechat_info || !$wechat_info->getId()) {
                    throw new AuthorizeFailedException('', '');
                }
                AuthUser::add('wechat_info', $wechat_info);
            }
            // 再判断一次
            if (!$wechat_info || !$wechat_info->getId()) {
                throw new \Exception('get wechat info error');
            }
            // 拼接详细信息
            $data = [
                'openid' => $wechat_info->getId(),
            ];
            // 从session中获取return_url，用于授权成功后跳转
            $return_url = AuthUser::take('return_url');
            if (!$return_url) {
                $return_url = '/';
            }
            // 根据openid从数据库查询详细用户信息
            $user_data = WechatModel::loginByOpenId($data['openid']);
            // 判断用户信息是否存在
            if (!$user_data) {
                // 将用户openid保存到session
                AuthUser::add('openid', $data['openid']);
            } else {
                // 执行登录
                AuthUser::login($user_data);
            }
            return Helper::sendJson(200, 'ok', ['url' => $return_url]);
        } catch (\Exception $e) {
            // 删除session中的数据
            AuthUser::del('wechat_info');
            Helper::log('wechatLoginError', $e->getMessage()."\n".$e->getTraceAsString());
            // 重新登录
            return redirect('/api/login');
        }
    }
}