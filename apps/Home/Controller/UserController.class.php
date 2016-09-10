<?php
namespace Home\Controller;
use Home\Model\UserModel;
use Org\Util\XLog;
use Think\Controller;
use Org\Util\ChuanglanSmsApi;

class UserController extends BaseController {

    //返回消息模板
    public $info=['msg'=>'ok','status'=>100,'item'=>''];

    /**
     * 用户登录页面
     */
    public function login(){
        session_destroy();
        session_start();
        $this->assign('pageTitle','用户登录');
        $refererUrl=$_SESSION['refererUrl']!=""?$_SESSION['refererUrl']:"";
        $this->assign('refererUrl',$refererUrl);
        $this->display();
    }

    /**
     * 用户注册页面
     */
    public function register(){

        $this->assign('pageTitle','用户注册');
        $this->display();
    }
    /**
     * 用户中心
     */
    public function me(){
         if(empty($_SESSION['userinfo'])){
             $_SESSION['refererUrl']='/me';
             header("location:/login");
             die;
         }
        $this->assign('pageTitle','用户中心');
        $this->display();
    }

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

        if($id==1){
            $this->assign('pageTitle','社团创建');
        }else if($id==2){
            $this->assign('pageTitle','企业创建');
        }else{
            header('location:/me');
            return ;
        }
        
        $this->display();
    }




    /**
     * 根据tel获取手机验证码
     * @param $tel 电话号码
     */
    public function ajaxGetCode($tel){
        if(!IS_GET||empty($tel)||isPhoneNum($tel)==0) return;
        header('Content-Type:text/html;charset=utf-8');
        $clapi  = new ChuanglanSmsApi();
        $vcode = rand(100000,999999);
        $msg ="【北京大创奇迹网络科技有限公司】您好，您的验证码是" . $vcode ;
        $result = $clapi->sendSMS($tel, $msg,'true');
        $result = $clapi->execResult($result);
        $_SESSION['vcode']=$vcode;//缓存vcode
        XLog::logDebug(__CLASS__,__FUNCTION__,json_encode($result));
        if(isset($result[1]) && $result[1]==0){
            $this->info['item']['vcode']=$vcode;
        }else{
            //发送失败
            $this->info['msg']='error';
            $this->info['status']=-101;
        }
        echo json_encode( $this->info);
    }

    /**
     * 用户登录
     */
    public function ajaxDoLogin(){
        if(!IS_POST) return;
        //post请求
        $tel=(string)$_POST['tel'];
        $keyword = (string)$_POST['keyword'];
        if(empty($tel)||empty($keyword)) {
            return;
        }
        $user = new UserModel();
        $result=$user->where("utel='%s' and upwd='%s'",array($tel,userSha1($keyword)))->getField('uid,uname,utel,utype');
        if(empty($result)){
            //用户不存在或者密码错误
            $this->info['msg']='error';
            $this->info['status']=-101;
        }else{
            $this->info['item']=$result;
            //缓存用户信息
            $_SESSION['userinfo']=$result;
        }
        echo  json_encode($this->info,true);
    }


    /**
     * 判断用户是否存在
     * @param string $tel
     */
    public function ajaxIsUserExist($tel=''){
        if(!IS_GET||empty($tel)) return;
        $user = new UserModel();
        $result=$user->where("utel='%s'",array($tel))->getField('utel');

        if(empty($result)){
            //用户不存在
            $this->info['msg']='error';
            $this->info['status']=-101;
        }else{
            //用户存在,直接返回用户的号码
            $this->info['item']=$result;
        }
        echo  json_encode($this->info,true);
    }


    /**
     * 用户注册接口
     * tel
     * vcode
     * keywords
     * rekeywords
     */
    public function ajaxDoRegister(){
        if(!IS_POST||empty($_POST['tel'])||empty($_POST['vcode'])||empty($_POST['keywords'])||empty($_POST['rekeywords'])){
            return;
        }
        $tel = (string)$_POST['tel'];
        $vcode=(string)$_POST['vcode'];
        $keywords = (string)$_POST['keywords'];
        $rekeywords = (string)$_POST['rekeywords'];
        if($keywords!=$rekeywords) return;
        if($_SESSION['vcode']!=$vcode) return;//比对验证码
        $create_time = date('Y-m-d H:i:s',time());
        $utype = 1;//用户类型
        $newUser = array(
            'utel'=>$tel,
            'upwd'=>userSha1($keywords),
            'uname'=>'',
            'vcode'=>$vcode,
            'utype'=>$utype,
            'create_time'=>$create_time,
            'update_time'=>$create_time,
        );
        $user = new UserModel();
        $result = $user->add($newUser);
        if($result!=false){
            $this->info['item']['id']=$result;
        }else{
            $this->info['msg']='error';
            $this->info['status']=-101;
        }

        echo json_encode($this->info);
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
        $file = $_FILES['applyImg'];
        //数据检查
        if(empty($name)||empty($email)||empty($og_name)||empty($tel)||empty($file)) return;

        //文件上传配置
        $config=array(
            'maxSize'  =>3145728,
            'exts'=>array('jpg','jpeg','png'),
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

        //用户id
        $uid = (int)$_SESSION['userinfo']['uid'];
        //用户类型,用来做用户的活动的类型
        $utype=(int)$_SESSION['userinfo']['utype'];



        $this->success("上传成功,我们将会尽快处理,处理结果将会邮件通知你!",'/club',5);

    }

    
}