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
        $this->assign('pageTitle','活动审核');
        $this->display();
    }
    
    public function orginseCheck(){
        $this->assign('pageTitle','组织审核');

        $this->display();
    }

    /**
     *
     */
    public function demandAdd(){
        $this->assign('pageTitle','发布需求');

        $this->display();
    }
    /**
     *需求列表
     */
    public function demandList(){
        $this->assign('pageTitle','需求列表');

        $this->display();
    }



    /**
     * 根据活动的类型查询所有的活动
     */
    public function ajaxGetAllActivitiesApply(){

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
        $applys = new ActivitiesApplyModel();
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
     * status 1,审核中,2,通过,3未通过
     * @param $id //活动唯一的id
     */
    public function ajaxPutActive($id='',$status='',$activeName){
        if(empty($id)||empty($status)||(int)$status==1) return;
        $k =(int)$status;
        $applys = new ActivitiesApplyModel();

        if($k ==2){//通过
            $msg = "恭喜您,您申请的活动".$activeName.'已经通过!';
        }else if($k ==3){
            //未通过,需要填写理由
            $msg = $_GET['errorMsg'];//未通过理由
            if(empty($msg)){
                $this->info['msg']='未填写失败理由';
                $this->info['status']=-101;
                echo json_encode($this->info);
                die;
            }
        }

        $data['status'] = $k ;
        $data['msg'] = $msg;
        $result = $applys->where('id=%d',array((int)$id))->save($data);
        //发送邮件
        


        if($result){
            echo json_encode($this->info);
        }else{
            $this->info['msg']='请稍后再试!';
            $this->info['status']=-101;
            echo json_encode($this->info);
        }

    }

}
