<?php

use btldapsdk\Bt_ldap_sdk;

require_once 'index.php';

$config = [
    'appid' => 1000,
    'appkey'   => 123,
];

$bt = new Bt_ldap_sdk($config);

if ( $_GET['logout'] )
{
    $bt->setLogout();
}
elseif ( $_GET['login'] || $_GET['BabelTimeToken'] )
{
    $result = $bt->oauth();
    
    if ( $result->status )
    {
        echo '登录成功 欢迎' . $result->info->username . PHP_EOL;
        echo '<a href="?logout=1">退出</a>';
    }
    else
    {
        echo '登录失败';
    }
}

if ( !$bt->isLogin() )
{
    echo '<a href="?login=1">登录</a>';
}