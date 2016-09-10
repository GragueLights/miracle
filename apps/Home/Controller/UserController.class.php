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

        $result = $user->where("utel=%s",array($tel))->find();
        if(!empty($result)){
            /* 验证用户密码 */
            if(userSha1($keyword)===$result['upwd']){
                $map['uid']=$result['uid'];
                $map['uname']=$result['uname'];
                $map['utel']=$result['utel'];
                $map['utype']=$result['utype'];//1,普通用户,2,社团用户,3,企业
                $this->info['item']=$map;
                //缓存用户信息
                $_SESSION['userinfo']=$map;
            }else{
                //用户不存在或者密码错误
                $this->info['msg']='error';
                $this->info['status']=-101;
            }
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
    

    

    
}