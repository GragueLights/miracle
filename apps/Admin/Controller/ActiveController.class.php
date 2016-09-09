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


    /**
     * 根据活动的类型查询所有的活动
     * @param $id 活动的类型
     */
    public function ajaxGetActivities($id){

    }
}