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

namespace btldapsdk;

class Bt_ldap_sdk implements Bt_ldap_sdk_interface
{
    private $userUrl = 'http://192.168.99.100:5000/user';
    private $tokenUrl = 'http://192.168.99.100:5000/token';
    private $appid;
    private $appkey;
    private $type;
    private $callback;
    
    public function __construct( Array $config )
    {
        $this->setConfig( $config );
    }
    
    /**
     * {@inheritDoc}
     * @see \btldapsdk\Bt_ldap_sdk_interface::setConfig()
     */
    public function setConfig ( Array $config )
    {
        foreach ( $config as $key=>$value )
        {
            $this->$key = $value;
        }
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \btldapsdk\Bt_ldap_sdk_interface::isLogin()
     */
    public function isLogin ( )
    {
        return !empty($_SESSION['BabelTimeOAuthLogin']);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \btldapsdk\Bt_ldap_sdk_interface::setLogin()
     */
    public function setLogin ( $username )
    {
        if ( !$username )
        {
            throw new \Exception('username err');
        }
        
        $_SESSION['BabelTimeOAuthLogin'] = $username;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \btldapsdk\Bt_ldap_sdk_interface::setLogout()
     */
    public function setLogout ( )
    {
        unset($_SESSION['BabelTimeOAuthLogin']);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \btldapsdk\Bt_ldap_sdk_interface::oauth()
     */
    public function oauth ( )
    {
        if ( $this->isLogin() == true )
        {
            return true;
        }

        if ( empty(($token = $_GET['BabelTimeToken'])) )
        {
            $this->login();
        }
       
        if ( ($result = $this->checkToken($token)) && $result->status == true )
        {
            $this->setLogin( $result->info->username );
        }
            
        return $result;
    }
    
    public function rePasswd ( )
    {
        $goto = $this->userUrl .'/repasswd?' . $this->getSign();
        
        header('Location:' . $goto);
        exit;
    }
    
    /**
     * 转到登陆页面
     * {@inheritDoc}
     * @see \btldapsdk\Bt_ldap_sdk_interface::login()
     */
    public function login ( )
    {
        $goto = $this->userUrl .'/login?' . $this->getSign();

        header('Location:' . $goto);
        exit;
    }
    
    public function getSign ()
    {
        $data = [
                'appid'     => $this->appid,
                'ts'        => time(),
                'redirect'  => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $_SERVER['REQUEST_URI'],
        ];
        
        $data['sign'] = Bt_ldap_sdk_helper::enCode( $this->type, $data, $this->appkey);
        
        return http_build_query($data);
    }
    
    public function checkToken( $token )
    {
        $data = 'token=' . $token;
        
        $url = $this->tokenUrl . '/check';
     
        $result = Bt_ldap_sdk_helper::http( $url, $data);
        
        return json_decode($result);
    }
    
    public function getInfo ( $token, array $fields )
    {
        $fields = implode(',', $fields);
        
        $data = 'token?=' . $token . '&fields='. $fields;
        $url = $this->userUrl . '/getInfo';
        return Bt_ldap_sdk_helper::http( $data, $url);
    }
}