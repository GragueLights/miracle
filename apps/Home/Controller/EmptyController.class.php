<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 空控制器
 * Class EmptyController
 * @package Home\Controller
 */
class EmptyController extends BaseController {

    public function index(){
        $this->redirect('Public/404');
    }
    
}