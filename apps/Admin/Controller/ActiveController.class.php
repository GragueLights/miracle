<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Think;

/**
 * 活动控制器
 * Class ActiveController
 * @package Admin\Controller
 */
class ActiveController extends BaseController {
    public function activeCheck(){
        $this->display();
    }
    
    public function orginseCheck(){
        $this->display();
    }
}