<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends BaseController {
    /**
     * 用户登录页面
     */
    public function login(){
        $this->assign('pageTitle','用户登录');

        $this->display();
    }

    /**
     * 用户注册页面
     */
    public function register(){
        $this->assign('pageTitle','用户注册');
        $this->display();

    }

    /**
     * 根据tel获取手机验证码
     * @param $tel 电话号码
     */
    public function ajaxGetCode($tel){

    }

    /**
     * 用户登录
     */
    public function ajaxDoLogin(){

    }

    /**
     * 用户中心
     */
    public function me(){
        if(empty($_SERVER['userinfo'])){
            $_SESSION['referUrl']='/me';
            header("location:/login");
        }
        $this->assign('pageTitle','用户中心');
        $this->display();
    }

    
}