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
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt_array ( $curl_handle,  
                array (
                        CURLOPT_POSTFIELDS => $postdata, 
                        CURLOPT_POST => true,
				        CURLOPT_HTTPGET => false )
                );
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $query;
    }
}

