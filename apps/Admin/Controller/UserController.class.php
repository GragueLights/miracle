<?php
namespace Admin\Controller;
use Think\Controller;

class UserController extends BaseController {
    /**
     * 后台管理员用户登录页面
     */
   public function adminUserLogin(){
        $this->display();
   }
}