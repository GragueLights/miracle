<?php
namespace Org\Util;
require 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 16/7/19
 * Time: 上午10:55
 * * Class Log
 * 日志打印管理类
 *
 */
class XLog
{
    static public function logWarn($class,$fun,$warn){
        if (APP_LOG!=true){
            return ;
        }
        $log = new Logger($class.'=>'.$fun);
        $log->pushHandler(new StreamHandler('log/warn'.date('Ymd').'.log',Logger::WARNING));
        $log->addWarning($warn);
    }
    static public function logError($class,$fun,$error){
        if (APP_LOG!=true){
            return ;
        }
        $log = new Logger($class.'=>'.$fun);
        $log->pushHandler(new StreamHandler('log/error'.date('Ymd').'.log',Logger::ERROR));
        $log->addError($error);
    }
    /**
     * @param $class
     * @param $fun
     * @param $debug
     * 打印警告信息
     */
    static public function logDebug($class,$fun,$debug){
        if (APP_LOG!=true){
            return ;
        }
        $log = new Logger($class.'=>'.$fun);
        $log->pushHandler(new StreamHandler('log/debug'.date('Ymd').'.log',Logger::DEBUG));
        $log->addDebug($debug);
    }

    /**
     * 记录请求的api URL
     * @param $class
     * @param $fun
     * @param $alert
     */
    static public function logUrl($class,$fun,$alert){
        if (APP_LOG!=true){
            return ;
        }
        $log = new Logger($class.'=>'.$fun);
        $log->pushHandler(new StreamHandler('log/apiUrl.log',Logger::INFO));
        $log->addInfo($alert);
    }

    //调试api的数据
    static public function logApiData($class,$fun,$data){
        if (APP_LOG!=true){
            return ;
        }
        $log = new Logger($class.'=>'.$fun);
        $log->pushHandler(new StreamHandler('log/reponseData.log',Logger::INFO));
        $log->addInfo($data);
    }

    /**
     * 统计用户访问信息
     * ip,agent,访问的页面
     * @param $fun 访问函数
     */
    static public function recordUser($fun){
        if (APP_LOG!=true){
            return ;
        }
        $log = new Logger();
        $log->pushHandler(new StreamHandler('log/user'.date('Ymd').'log',Logger::INFO));
        $log->addInfo('ip:'.get_client_ip().' user-agent:'.$_SERVER['HTTP_USER_AGENT'].' '.$fun);
    }


}
