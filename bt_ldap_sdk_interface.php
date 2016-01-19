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

interface Bt_ldap_sdk_interface 
{
    public function __construct( Array $config );
    
    /**
     * 设置配置信息
     * @param array $config
     */
    public function setConfig ( Array $config );
    
    /**
     * 判断是否登录
     */
    public function isLogin ( );
    
    /**
     * 登录动作
     * @param unknown $username
     */
    public function setLogin ( $username );
    
    /**
     * 登出操作
     */
    public function setLogout ( );
    
    /**
     * 登录统一操作
     */
    public function oauth( );
    
    /**
     * 单独登录操作
     */
    public function login ();
    
    /**
     * 检测token是否有效
     * @param unknown $token
     */
    public function checkToken ( $token );
    
    /**
     * 获取用户信息
     * @param unknown $token
     * @param array $fields
     */
    public function getInfo ( $token, Array $fields );
}