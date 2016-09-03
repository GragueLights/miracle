<?php
/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 16/9/2
 * Time: 下午8:39
 */

/*
     * 判断是否是正确的手机号，以及手机的运营商
     * @param {String} num
     *
     * 返回值:
     *      0 不是手机号码
     *      1 移动
     *      2 联通
     *      3 电信
     *      4 不确定
     */
function isPhoneNum($num)
{
    $flag = 0;
    $phoneRe = "/^1\\d{10}$/";
    $dx = array(133, 153, 180, 181, 189, 177, 1700, 1701); /*电信*/
    $lt = array(130, 131, 132, 145, 155, 156, 185, 186, 176, 1718, 1719, 1707, 1708, 1709);/*联通*/
    $yd = array(134, 135, 136, 137, 138, 139, 147, 150, 151, 152, 157, 158, 159, 182, 183, 184, 187, 188, 178, 1705);/*移动*/
    if (!preg_match($phoneRe, $num)) {
        return $flag;
    }
    $pre = substr($num, 0, 3);
    if ($pre == '170' || $pre == '171') {
        $pre = substr($num, 0, 4);
    }

    if (in_array($pre, $yd)) {
        $flag = 1;
    } else if (in_array($pre, $lt)) {
        $flag = 2;
    } else if (in_array($pre, $dx)) {
        $flag = 3;
    } else {
        $flag = 4;
    }
    return $flag;
}


/***
 * 生成用户唯一id
 */
/**
 *
 * @param $type 用户类型
 * @param $tel  用户tel
 * 生成规则
 * 用户类型+用户tel+注册时间(base64)
 */
function uid($type,$tel){
    $str = (string)$type.(string)$tel.time();
    return md5($str);
}

/**
 * 用户密码加密
 *
 */
function userSha1($upwd){
    return sha1($upwd);
}

