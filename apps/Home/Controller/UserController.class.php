<?php
namespace Home\Controller;
use Home\Model\UserModel;
use Org\Util\XLog;
use Think\Controller;
use ThirdApi;
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
     * 根据tel获取手机验证码
     * @param $tel 电话号码
     */
    public function ajaxGetCode($tel){
        
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
        $result=$user->where("utel='%s' and upwd='%s'",array($tel,$keyword))->getField('uid,uname,utel,utype');
        if(empty($result)){
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
        if(empty($tel)){
            $this->info['msg']='error';
            $this->info['status']=-101;
        }else{
            $this->info['item']=$result;
        }
        echo  json_encode($this->info,true);
    }



    


    
}