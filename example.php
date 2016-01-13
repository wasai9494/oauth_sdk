<?php

use btldapsdk\Bt_ldap_sdk;

require_once 'index.php';

$bt = new Bt_ldap_sdk('1000','123','http://192.168.99.100:3000/');

if ( $_GET['token'] )
{
    $result = $bt->checkToken($_GET['token']);
    echo $result;
}
else
{
    $bt->login();
}
