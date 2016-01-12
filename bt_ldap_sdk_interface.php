<?php
namespace btldapsdk;

class Bt_ldap_sdk_interface 
{
    public function login ( );
    
    public function checkToken ( $token );
    
    public function getInfo ( $token );
}