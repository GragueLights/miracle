<?php
/**
 * Created by PhpStorm.
 * User: xiao
 * Date: 16/8/31
 * Time: 下午7:14
 */

namespace Home\Model;
use Think\Model;

/**
 * 用户模型
 * 社团,企业,学生
 * Class UserModel
 * @package Home\Model
 */

class UserModel extends Model
{
    //查询用户信息

    /* 用户模型自动验证 */
//    protected $_validate = array(
//        /* 验证用户名 */
//        array('username', '1,30', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
//        array('username', 'checkDenyMember', -2, self::EXISTS_VALIDATE, 'callback'), //用户名禁止注册
//        array('username', '', -3, self::EXISTS_VALIDATE, 'unique'), //用户名被占用
//
//        /* 验证密码 */
//        array('password', '6,30', -4, self::EXISTS_VALIDATE, 'length'), //密码长度不合法
//
//        /* 验证邮箱 */
//        array('email', 'email', -5, self::EXISTS_VALIDATE), //邮箱格式不正确
//        array('email', '1,32', -6, self::EXISTS_VALIDATE, 'length'), //邮箱长度不合法
//        array('email', 'checkDenyEmail', -7, self::EXISTS_VALIDATE, 'callback'), //邮箱禁止注册
//        array('email', '', -8, self::EXISTS_VALIDATE, 'unique'), //邮箱被占用
//
//        /* 验证手机号码 */
//        array('mobile', '//', -9, self::EXISTS_VALIDATE), //手机格式不正确 TODO:
//        array('mobile', 'checkDenyMobile', -10, self::EXISTS_VALIDATE, 'callback'), //手机禁止注册
//        array('mobile', '', -11, self::EXISTS_VALIDATE, 'unique'), //手机号被占用
//    );


    
}