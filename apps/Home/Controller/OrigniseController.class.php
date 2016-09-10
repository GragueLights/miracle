<?php
namespace Home\Controller;
use Home\Model\ActivitiesApplyModel;
use Home\Model\OrginiseApplyModel;
use Home\Model\OrginiseModel;
use Home\Model\UserModel;
use Org\Util\XLog;
use Think\Controller;
class OrigniseController extends Controller {
    //返回消息模板
    public $info=['msg'=>'ok','status'=>100,'item'=>''];

    /**
     * 组织申请页面
     */
    /**
     * @param $id 社团或者企业标志
     * 1,创建社团
     * 2,创建企业
     */
    public function origiseApply($id){
        if(empty($id)) return;
        if(empty($_SESSION['userinfo'])){
            $_SESSION['refererUrl']='/activeApplay';
            header('location:/login');
        }

        $uid = $_SESSION['userinfo']['uid'];
        $active = new OrginiseModel();
        $active->where('uid=%d',array($uid))->find();

        //已经存在
        if(in_array($active)){
            $this->success('您已经创建过一个组织,不能再创建!');
            die;
        }
        if($id==1){//社团
            $this->assign('applyType',1);
            $this->assign('pageTitle','社团创建');
        }else if($id==2){//企业
            $this->assign('applyType',2);
            $this->assign('pageTitle','企业创建');
        }else{
            header('location:/me');
            return ;
        }
        $this->display();
    }

    /**
     * 加入企业
     */
    public function addOrignise(){
        $this->assign('pageTitle','加入组织');
        $this->display();
    }

    /**
     * 我的组织
     */
    //如果用户是普通用户,且没有任何社团就可以创建社团或者加入社团
    //如果uid为2 则为社团用户
    //如果uid为3,则为企业用户
    public function myOrignise(){
        //1,如果uid是1,普通用户
        //a,判断组织是否在审核状态中
        //b,如果存在社团,则查找
        if(empty($_SESSION['userinfo'])){
            $_SESSION['refererUrl']='/activeApplay';
            header('location:/login');
        }
        $utype = $_SESSION['userinfo']['utype'];
        $uid = $_SESSION['userinfo']['uid'];
        $type = 1;
        switch ($utype){
            case 1://普通用户

                $apply = new OrginiseApplyModel();
                $result = $apply->where('uid=%d',array($uid))->find();
                if(is_array($result)&&$result['status']){//有正在审核中的信息
                    if($result['type']==1){
                        $msg='你申请的社团正在审核中..';
                    }else{
                        $msg='你申请的企业正在审核中..';
                    }
                    $this->assign('msg',$msg);
                    $type=0;//申请组织中
                }else{
                    $type=1;//普通用户
                }
                break;
            case 2://社团用户
                $type=2;//申请组织中
                break;
            case 3://企业用户
                $type=3;//申请组织中
                break;
            default:
                $this->error('系统正在维护中');
                break;
        }

        $this->assign('type',$type);

        $this->assign('pageTitle','我的组织');
        $this->display();
    }



    /**
     * 创建社团接口
     * 需要的数据,用户id,用户名称,认证资料的图片
     * tel ,eamil,组织名称,创建类型1,2
     */
    public function ajaxCreateOrginse(){
        if(!IS_POST) return;


        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $name = $_POST['name'];//用户名
        $orginseName = $_POST['orgniseName'];
        $id = $_POST['id'];
        $orginseType=$_POST['orginseType'];

        if(empty($tel)||empty($email)||empty($name)||empty($orginseName)||empty($id)||empty($orginseType)){
            return;
        }

        $filename = $_POST['img'];
        $upload = new \Think\Upload();// 实例化上传类

    }


    /**
     * 组织申请
     */
    public function doApplyOrgnise(){
        if(!IS_POST) return;
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $og_name = $_POST['og_name'];
        $applyType = $_POST['applyType'];
        $file = $_FILES['applyImg'];
        //数据检查
        if(empty($name)||empty($email)||empty($og_name)||empty($tel)||empty($applyType)||empty($file)) return;
        //文件上传配置
        $config=array(
            'maxSize'  =>3145728,
            'exts'=>array('jpg','jpeg','png'),//上传图片
            'savePath'=>'./renzhen/',
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

        $newApplay = array(
            'uid'=>(int)$_SESSION['userinfo']['uid'],
            'name'=>$name,
            'tel'=>$tel,
            'email'=>$email,
            'renzhen_url'=>$info['savepath'].$info['savename'],
            'og_name'=>$og_name,
            'type'=>(int)$applyType,//申请类型,1、社团，2企业
            'status'=>1,//申请中,1、审核中，2、已审核，3，未通过
            'create_time'=>getNowTime(),
        );

        $apply = new OrginiseApplyModel();

        $result  = $apply->add($newApplay);
        if($result){
            $this->success("上传成功,我们将会尽快处理,处理结果将会邮件通知你!",'/club',5);
        }else{
            $this->error('系统繁忙,请稍后再试!');
        }



    }
    
}