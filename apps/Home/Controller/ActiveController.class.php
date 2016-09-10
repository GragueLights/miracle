<?php
namespace Home\Controller;
use Think\Controller;
use Think\Think;

/**
 * 活动控制器
 * Class ActiveController
 * @package Home\Controller
 */
class ActiveController extends BaseController {
    /**
     * 活动申请页面
     */
    public function activeApplay(){
        
//        if(empty($_SESSION['userinfo'])){
//            $_SESSION['refererUrl']='/activeApplay';
//            header('location:/login');
//        }else{
//            if($_SESSION['userinfo']['utype']==1){
//                //普通用户
//
//            }
//        }
        $this->assign('pageTitle','活动申请');
        $this->display();
    }

    /**
     * 活动详情
     * @param $id //活动的唯一id
     */
    public function activeInfo($id){
        $this->assign('pageTitle','活动详情');
        $this->display();
    }

    /**
     * 评论列表
     */
    public function comments(){
        $this->assign('pageTitle','评论列表');
        $this->display();
    }

    public function myActivites(){
        $this->assign('pageTitle','我的活动中心');
        $this->display();
    }

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
    public function doApplyActivite(){

//        if(empty($_SESSION['userinfo'])){
//            $_SESSION['refererUrl']='/activeApplay';
//            header('location:/login');
//        }


        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $file = $_FILES['applyFile'];
        //数据检查
        if(empty($name)||empty($email)||empty($tel)||empty($file)) return;

        //文件上传配置
        $config=array(
            'maxSize'  =>3145728,
            'exts'=>array('doc','docx'),
            'savePath'=>'./activeapply/',
            'autoSub'=>true,
            'subName'=>array('date','Ymd'),
            'saveName'=>time().'_'.$tel.'_'.urlencode($name),
        );

        //文件提交
        $upload = new \Think\Upload($config);
        $info = $upload->uploadOne($file);

        if(!$info){
           //上传失败
           $this->error($upload->getError());
            die;
        }
        //处理,入库

        //用户id
        $uid = (int)$_SESSION['userinfo']['uid'];
        //用户类型,用来做用户的活动的类型
        $utype=(int)$_SESSION['userinfo']['utype'];



        $this->success("上传成功,我们将会尽快处理,处理结果将会邮件通知你!",'/club',5);
        
    }


}