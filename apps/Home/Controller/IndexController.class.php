<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
        header("location:/club");
    }
    /**
     *社团活动
     */
    public function club(){
        $this->assign('pageTitle','社团活动');
        $this->display();
    }

    /**
     *企业活动
     */
    public function business(){
        $this->assign('pageTitle','企业活动');
        $this->display();

    }

    /**
     * 历史
     */
    public function history(){
        $this->assign('pageTitle','往期活动');
        $this->display();
    }

    /**
     * 历史
     */
    public function company(){
        $this->assign('pageTitle','社团');
        $this->display();
    }
    
}