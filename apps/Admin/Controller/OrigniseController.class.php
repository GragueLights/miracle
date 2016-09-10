<?php
namespace Admin\Controller;
use Home\Model\OrginiseApplyModel;
use Think\Controller;

class OrigniseController extends Controller {

    //返回消息模板
    public $info=['msg'=>'ok','status'=>100,'item'=>''];

    /**
     * 获取组织申请数据
     */
    public function ajaxGetAllOrigniseApply(){
        if(!IS_GET) return;
        //有无id
        $type = $_GET['type'];//1,社团,2,企业
        $applys = new OrginiseApplyModel();
        if(!empty($type)){
            $result = $applys->where('status=%d',array((int)$type))->order('create_time')->select();
        }else{
            //全查
            $result = $applys->order('create_time')->select();
        }
        $this->info['item']=$result;
        echo json_encode($this->info);
    }


}