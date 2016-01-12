<?php
namespace btldapsdk;

interface Bt_ldap_sdk_interface 
{
    public function __construct(  $appid, $appkey, $type );
    
    public function login ();
    
    public function checkToken ( $token );
    
    public function getInfo ( $token, Array $fields );
}