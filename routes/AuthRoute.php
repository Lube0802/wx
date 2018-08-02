<?php

$app->get('login', ['as' => 'login', 'uses' => 'WxTestController@login']);
$app->get('login-callback', 'WxTestController@loginCallback');
$app->get('login-redirect', 'WxTestController@loginRedirect');

$app->get('logout', 'AuthController@logout');

