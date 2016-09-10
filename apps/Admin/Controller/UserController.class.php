<?php
namespace Admin\Controller;
use Think\Controller;

class UserController extends BaseController {
    //返回消息模板
    public $info=['msg'=>'ok','status'=>100,'item'=>''];

    /**
     * 后台管理员用户登录页面
     */
   public function adminUserLogin(){
        $this->display();
   }

    /**
     * 后台管理员登录
     * @param $username 用户名
     * @param $paswword 密码
     */
    public function ajaxGetAdminUser($username,$paswword){
        if(empty($username)||empty($paswword)) return;
        if($username=='admin'&&$paswword=='13053001'){
            session_destroy();
            session_start();
            $_SESSION['userinfo']['username']=$username;
            $_SESSION['userinfo']['type']='admin';
            $this->info['item']=$username;
        }else{
            $this->info['msg']='error';
            $this->info['status']=-101;
        }
        echo json_encode($this->info);
    }

    /**
     * 管理员退出
     */
    public function adminUserLoginOut(){
        $_SESSION['userinfo'] = null;
        session_destroy();
        header('location:/adminUserLogin');
    }


}