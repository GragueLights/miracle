<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 活动控制器
 * Class ActiveController
 * @package Home\Controller
 */
class ActiveController extends BaseController {
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

    

    //申请活动
    public function ajaxApplyActivity(){
//        name	varchar(60)	发布人姓名
//tel	char(12)	联系方式
//email	varchar(60)	通知邮箱
//material	varchar(255)	材料url
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        //数据检查
        if(empty($name)||empty($email)||empty($tel)) return;

        



    }



    
}