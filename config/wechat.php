<?php

return [
    /**
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => true,
    /**
     * 账号基本信息，请从微信公众平台/开放平台获取
     */
    'app_id'  => 'wx4110b4b8cfe148d1',         // AppID wx9ec1119f1a067a16
    'secret'  => '920a56f2246d266bb8475b93312b11b2',     // AppSecret 03b430e12eaefcd2f07687c942b00ad2
    'token'  => 'weixin',
//    'token'   => '3e1aeb8c9016499d8201b7d149d8b04a',          // Token
    'aes_key' => 'vIgkviXZjf0Rp05vU1BsPhlEko4oOU5FmgS6WGxBMJF',          // EncodingAESKey，安全模式下请一定要填写！！！

    'key'       => '5f6r8s4c9u7k2j4h5g6i8q7m6s45a2f2',
    'mch_id'    => '1293748701',
    'notify_url'=> '/pay/notify',
    /**
    'twocode_back_url'=> '/login/weixin-info',
    'open_appid'     => 'wx82a6b4d84b1bd10d',
    'open_appsecret' => '5b89c1486e341958c60ffd78a35dfaf4',
     */
    /**
     * 日志配置
     *
     * level: 日志级别, 可选为：
     *         debug/info/notice/warning/error/critical/alert/emergency
     * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level'      => 'debug',
        'permission' => 0777,
        'file'       => dirname(__FILE__)."/../storage/logs/wechat_".date('Y-m-d').".log",
    ],
    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址
     */
    'oauth' => [
        'scopes'   => ['snsapi_userinfo'],
//        'scopes'   => ['snsapi_base'],
        'callback' => 'http://wx.lubetown.xin/api/login-callback',
    ],
    /**
     * 微信支付
     */
    /**
    'payment' => [
    'appid' => 'wxca24494dc8198d30', // 小福拍 wx9ec1119f1a067a16
    'secret'  => 'ff0a8c37a1b5acf65c0b5a4a1a92b267',
    'merchant_id'        => '1293748701', // 商户id 1434515402
    'key'                => '5f6r8s4c9u7k2j4h5g6i8q7m6s45a2f2', // key-for-signature bb31bf16db277501593752205b00013a
    'cert_path'          => '', // XXX: 绝对路径！！！！ path/to/your/cert.pem
    'key_path'           => '',      // XXX: 绝对路径！！！！ path/to/your/key
    'notify_url' => 'http://e.beta.ping99.com/api/notify-wx',
    ],
     */
    /**
     * Guzzle 全局设置
     *
     * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
     */
    'guzzle' => [
        'timeout' => 3.0, // 超时时间（秒）
        //'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
    ],
    //限制IP
    "allow_ip"=>[

    ],
    /**
    //缺省的消息反馈
    'default'=>'你的消息已收到，谢谢关注',
    //第一次关注的反馈
    'welcome'=>'Hey，恭喜您发现了一个专业的全品类艺术品拍卖平台！

    关注我们即可拍珍捡漏，分享收藏。在这里，既可做买家，也可做卖家，仅需一部手机，随时随地，轻松上拍、竞买！

    现在就开始吧，享受您的艺术人生！',

    'keywords'=>[
    '加油'=>['type'=>'text','content'=>'终于等到你，加油免单券、爱奇艺60元VIP大礼包在向您招手啦，快来试试手气吧！ <a href="https://wx.wcar.net.cn/attendant-token.php?source=xiaofupai">戳我抽奖</a>'],
    '文玩'=>['type'=>'link','url'=>'http://mp.weixin.qq.com/s/BhyHWrjQtIZzIihKxM7raQ','title'=>'小福状元考（第一期：文玩）答案解析','desc'=>'想变成真正能带小玩家上车，讲故事讲科学一套套的老司机？快看下面的答案解析提升攻击力'],
    '彩蛋'=>['type'=>'pic','content'=>'2XF8YxSkclUAhWwdSgHGhdkFywKabeGgwsQMpNRlIYI','title'=>'','link'=>''],
    '参赛'=>['type'=>'text','content'=>'            一、添加群里“校园新锐·艺术创业大赛”或者“项目经理-姚志鹏”为微信好友，提供个人资料进行身份认证（包括：学校、年级、系别、姓名、、手持学生证照）。
    二、关注“小福拍”微信公众号，点击菜单栏进入拍场，拍场首页点击“相机”，即可上传作品。'],
    '参赛流程'=>['type'=>'text','content'=>'            一、添加群里“校园新锐·艺术创业大赛”或者“项目经理-姚志鹏”为微信好友，提供个人资料进行身份认证（包括：学校、年级、系别、姓名、、手持学生证照）。
    二、关注“小福拍”微信公众号，点击菜单栏进入拍场，拍场首页点击“相机”，即可上传作品。'],
    '身份认证'=>['type'=>'text','content'=>'            添加群里“校园新锐·艺术创业大赛”或者“项目经理-姚志鹏”为微信好友，提供个人资料进行身份认证（包括：学校、年级、系别、姓名、、手持学生证照）

    身份认证需要手持学生证件照，主要是为了证明学生身份，因为我们接下来会组建超级卖家团，来支持大学生创业，所以对身份有所要求。

    不认证也可以上传作品，但是上传作品不能计入参赛作品之中。'],
    ],

    //服务号菜单
    'menu' =>[
    [
    "type" => "view",
    "name" => "进入拍场",
    "url"  => "http://e.beta.ping99.com/index"
    ],
    [
    "type" => "view",
    "name" => "发现",
    "url"  => "http://e.beta.ping99.com/find"
    ],
    [
    "name" => "服务",
    "sub_button"  => [
    [
    "type" => "click",
    "name" => "联系客服",
    "key" => "SERVICE"
    ],
    //                [
    //                    "type" => "view",
    //                    "name" => "买家帮助",
    //                    "url"  => "http://e.beta.ping99.com/index"
    //                ],
    //                [
    //                    "type" => "view",
    //                    "name" => "卖家帮助",
    //                    "url"  => "http://e.beta.ping99.com/index"
    //                ],
    [
    "type" => "view",
    "name" => "我的拍品",
    "url"  => "http://e.beta.ping99.com/center"
    ]
    ]
    ]
    ]
     */
];
