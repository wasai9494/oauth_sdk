<?php
namespace btldapsdk;

defined('_ROOT')?null:define('_ROOT',dirname(__FILE__));

class Bt_ldap_sdk implements Bt_ldap_sdk_interface
{
    private $userUrl = 'docker:5000/user';
    private $tokenUrl = 'docker:5000/token';
    private $appid;
    private $appkey;
    private $type;
    
    public function __construct( $appid, $appkey, $type = 'md5')
    {
        $this->appid = $appid;
        $this->appkey = $appkey;
        $this->type = $type;
    }

    /**
     * 转到登陆页面
     * {@inheritDoc}
     * @see \btldapsdk\Bt_ldap_sdk_interface::login()
     */
    public function login ( )
    {
        $data = [
            'appid' => $this->appid,
            'ts'    => time(),
        ];
        
        $data['sign'] = Bt_ldap_sdk_helper::enCode( $this->type, $data, $this->appkey);
        
        $goto = $this->$userUrl .'/login?' . http_build_query($data);
        header( $goto );
        exit;
    }
    
    public function checkToken( $token )
    {
        $data = 'token?=' . $token;
        $url = $this->tokenUrl . '/check';
        return Bt_ldap_sdk_helper::http( $data, $url);
    }
    
    public function getUserInfo ( $token, array $fields )
    {
        $fields = implode(',', $fields);
        
        $data = 'token?=' . $token . '&fields='. $fields;
        $url = $this->userUrl . '/getInfo';
        return Bt_ldap_sdk_helper::http( $data, $url);
    }
}