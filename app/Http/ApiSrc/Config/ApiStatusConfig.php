<?php

namespace ApiSrc\Config;

/**
 * Api接口状态码.
 */
class ApiStatusConfig
{
    /**
     *返回相应的状态码.
     *
     *@param $status 状态描述
     *
     *@return 
     */
    public static function code($status)
    {
        if (!isset(self::$config[$status])) {
            throw new \Exception("the status $status is not exist");
        }

        return self::$config[$status];
    }

    /**
     *接口状态码.
     */
    private static $config = [
        'API_SUCCESS' => 0,// Api接口成功返回
        /*
         * 基本的接口状态码,1000~1999
         */
        'API_INVALID_PARAM' => 1000,// Api参数错误
        'UPLOADFILE_UPYUN_UPLOAD_FAILED' => 1500,//文件上传失败

        /*
         * 基本的业务逻辑相关状态码:2000~9999
         */
        /*
         * 授权验证相关:2000~3000
         */
        'AUTH_FAILED' => 2000,//授权失败
        'USER_AUTH_FAILED' => 2001,// 用户中心授权失败
        'DATABASE_ERROR'=>9998,//未知的数据库异常错误
        'UNKNOWN_ERROR' => 9999,//未知的异常错误

        /*
         * 业务逻辑状态码:10000以上
         */
        /*
         * 用户相关:10000-11000
         */
        'USER_LOGIN_FAILED' => 10001, //用户登录失败
        'KOALACPAY_REQUEST_BALANCE_FAILED' => 10051,//用户获取钱包余额失败
        'USER_NOT_ATTENTIONED_THE_STORE' => 10052,//用户未关注此商家
        'USER_HAS_ATTENTIONED_THE_STORE' => 10053,//用户已关注此商家

        /*
         * 商家feed相关:11001-12000
         */
        'FEED_COMMENT_NOT_EXIST' => 11001, //feed评论信息不存在
        'COMMENT_SELF_ERROR' => 11002, //不允回复自己feed评论

        /*
    	* 开放平台相关：12001-13000
    	*/
        'OPEN_UC_USERNAME_EXISTS' => 12001, //用户中心已存在指定的用户账号
        'OPEN_UC_UNKNOWN_ERROR' => 12002, //用户中心其它的未知错误
        'OPEN_UC_CONDITION_ERROR'=>12003,
        'OPEN_UC_USER_NOT_EXISTS'=>12004,
        
        /*
    	* 商家店铺相关：13001-14000
    	*/
        'STORE_QRCODE_GENERATE_NUMBER_ERROR'=>13001,//超过生成数量上限

    ];
}
