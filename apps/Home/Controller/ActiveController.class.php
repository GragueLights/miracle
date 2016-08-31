<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 活动控制器
 * Class ActiveController
 * @package Home\Controller
 */
class ActiveController extends Controller {
    /**
     * 获取活动历史记录
     * @param $type 活动类型
     * 1,club
     * 2,business
     * 3,history
     */
    public function ajaxGetActivities($type){
        if(!IS_GET||empty($type)){
            return ;
        }
        switch ($type){
            case 'club':
                break;
            case 'business':
                break;
            case 'history';
                break;
            default:
                break;
        }
    }

    
}