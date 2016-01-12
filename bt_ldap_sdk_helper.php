<?php
namespace btldapsdk;

class Bt_ldap_sdk_helper
{    

    public static function enCode ($type, $params, $appKey)
    {
        $tmp = '';
        
        foreach ($params as $key=>$value)
        {
            $tmp .= $key.$value;
        }
        
        $tmp .= $appKey;
        
        switch ($type) {
            default:
                return md5($tmp);
                break;
        }
    }
    
    public static function http ( $url, $postdata )
    {
        if ( is_array($postdata) )
        {
            $postdata = http_build_query($postdata);
        }
        
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        
        $context  = @stream_context_create($opts);
        
        return file_get_contents($url, false, $context);
    }
}

