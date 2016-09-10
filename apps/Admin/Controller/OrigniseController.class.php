<?php
namespace Admin\Controller;
use Home\Model\OrginiseApplyModel;
use Think\Controller;

class OrigniseController extends Controller {

    //返回消息模板
    public $info=['msg'=>'ok','status'=>100,'item'=>''];

    /**
     * 获取组织申请数据
     *
     */

    public function ajaxGetAllOrigniseApply(){
        if(!IS_GET) return;
        $type = $_GET['type'];//查询类型
        $status = $_GET['status'];//查询状态
        $time= $_GET['time'];

        if(!empty($type)){
            $map['type'] = (int)$type;//1,社团,2,企业
        }
        if(!empty($status)){
            $map['status'] = (int)$status;
        }
        if(!empty($time)){
            $map['create_time'] =  array('like',$time.'%');;
        }
        $applys = new OrginiseApplyModel();
        if(isset($map)){
            $result = $applys->select();
        }else{
            $result = $applys->where($map)->find();
        }
        $this->info['item']=$result;
        echo json_encode($this->info);
    }


    /**
     * 审核按钮
     * @param $id //活动唯一的id
     */
//    public function ajaxPutOrignise($id=''){
//        if(empty($id)) return;
//        $applys = new ActivitiesApplyModel();
//        $data['status'] = 'ThinkPHP';
//        $applys->where('id=%d',array((int)$id))->save($data);
//
//    }


}