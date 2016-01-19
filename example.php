<?php
/***************************************************************************
 *
 * Copyright (c) 2016 babeltime.com, Inc. All Rights Reserved
 * $Id: $
 *
 **************************************************************************/
/**
 *
 * @Author: $LastChangedBy: (machao@babeltime.com) $
 * @Version: $LastChangedRevision:$
 * @LastDate: $LastChangedDate:$
 * @file: $HeadURL:$
 *
 **/

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
        echo '登录成功 欢迎' . $result->info->username . '</br></br>';
        echo '<a href="?repasswd=1">修改密码</a></br>';
        echo '<a href="?logout=1">退出</a></br>';
    }
    else
    {
        echo '登录失败';
    }
}elseif ($_GET['repasswd'])
{
    $bt->rePasswd();
}

if ( !$bt->isLogin() )
{
    echo '<a href="?login=1">登录</a>';
}