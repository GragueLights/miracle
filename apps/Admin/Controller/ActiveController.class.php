<?php
namespace Admin\Controller;
use Home\Model\ActivitiesApplyModel;
use Home\Model\ActivitiesModel;
use Think\Controller;
use Think\Think;

/**
 * 活动控制器
 * Class ActiveController
 * @package Admin\Controller
 */
class ActiveController extends BaseController {
    //返回消息模板
    public $info=['msg'=>'ok','status'=>100,'item'=>''];

    public function activeCheck(){
        $this->display();
    }
    
    public function orginseCheck(){
        $this->display();
    }


    /**
     * 根据活动的类型查询所有的活动
     */
    public function ajaxGetAllActivitiesApply(){
        if(!IS_GET) return;
        $status = $_GET['status'];//活动状态
        $applys = new ActivitiesApplyModel();
        if(!empty($status)){
            $result = $applys->where('status=%d',array((int)$status))->order('create_time')->select();
        }else{
            //全查
            $result = $applys->order('create_time')->select();
        }
        $this->info['item']=$result;
        echo json_encode($this->info);
    }

}
