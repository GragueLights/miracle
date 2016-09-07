<?php
/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 16/8/30
 * Time: 下午8:54
 */
//路由配置
return array(
    //路由配置
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES'=>array(
        //页面地址映射
        'login'=>'user/login',//登录页面
        'register'=>'user/register',//注册页面 
        'me'=>'user/me',//用户中心
        '/'=>'index/club',
        'club'=>'index/club',//社团活动
        'business'=>'index/business',//企业活动
        'history'=>'index/history',//往期
        'company'=>'index/company',//社团


        //ajax请求映射
        'ajaxDoLogin'=>'user/ajaxDoLogin',
        'ajaxIsUserExist'=>'user/ajaxIsUserExist',
        'ajaxGetCode'=>'user/ajaxGetCode',
        'ajaxDoRegister'=>'user/ajaxDoRegister',
        
    )

);