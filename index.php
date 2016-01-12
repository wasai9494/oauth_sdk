<?php

use btldapsdk\Bt_ldap_sdk;

defined('_ROOT')?null:define('_ROOT',dirname(__FILE__));

require_once _ROOT . '/bt_ldap_sdk_helper.php';
require_once _ROOT . '/bt_ldap_sdk_interface.php';
require_once _ROOT . '/bt_ldap_sdk.php';

$bt = new Bt_ldap_sdk('1000','123','http://docker:3000/');

if ( $_GET['token'] )
{
    $result = $bt->checkToken($_GET['token']);
    print_r(json_decode($result,true));
}
else
{
    $bt->login();
}
