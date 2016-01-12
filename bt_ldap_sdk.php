<?php
namespace btldapsdk;

class Bt_ldap_sdk implements Bt_ldap_sdk_interface
{
    private $userUrl = 'http://192.168.99.100:5000/user';
    private $tokenUrl = 'http://192.168.99.100:5000/token';
    private $appid;
    private $appkey;
    private $type;
    private $callback;
    
    public function __construct( $appid, $appkey, $callback, $type = 'md5')
    {
        $this->appid = $appid;
        $this->appkey = $appkey;
        $this->type = $type;
        $this->callback = $callback;
    }

    /**
     * 转到登陆页面
     * {@inheritDoc}
     * @see \btldapsdk\Bt_ldap_sdk_interface::login()
     */
    public function login ( )
    {
        $data = [
            'appid'     => $this->appid,
            'callback'  => $this->callback,
            'ts'        => time(),
        ];
        
        $data['sign'] = Bt_ldap_sdk_helper::enCode( $this->type, $data, $this->appkey);
        
        $goto = $this->userUrl .'/login?' . http_build_query($data);

        header('Location:' . $goto);
        exit;
    }
    
    public function checkToken( $token )
    {
        $data = 'token=' . $token;
        
        $url = $this->tokenUrl . '/check';
     
        return Bt_ldap_sdk_helper::http( $url, $data);
    }
    
    public function getInfo ( $token, array $fields )
    {
        $fields = implode(',', $fields);
        
        $data = 'token?=' . $token . '&fields='. $fields;
        $url = $this->userUrl . '/getInfo';
        return Bt_ldap_sdk_helper::http( $data, $url);
    }
}