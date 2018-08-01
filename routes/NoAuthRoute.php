<?php

$app->get('test', 'TestController@test');
$app->get('ms', 'MsController@getGood');
$app->get('store', 'MsController@setAddRedis');
$app->get('wechat-param', 'TestController@getWechatParam');
$app->get('debug', 'AuthController@debug');

$app->post('wechat','WechatController@index');
$app->get('wechat','WechatController@index');