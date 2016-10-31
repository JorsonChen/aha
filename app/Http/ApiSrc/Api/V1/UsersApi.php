<?php

namespace ApiSrc\Api\V1;

use ApiSrc\Framework\Api;
use ApiSrc\Framework\App;
use App\Http\ApiControllers\V1\UsersController;
use Exception;

class UsersApi extends Api 
{

    /**
     *构造函数.
     *
     *@return
     */
    public function __construct()
    {
        self::setLangInstance(self::langDictionary());
    }

    /**
     *处理异常.
     *
     *@param $e 异常的实例
     *@return json
     */
    public function handleException($e)
    {
        if ($exp = parent::handleException($e)) {
            return $exp;
        }
        $code = $e->getCode();
        $message = '';

        switch ($code) {
        default:
            return $this->handleUnknownException($e);
        }

        return $this->apiExceptionPackage($code, $message);
    }

    /**
     *获取access_token
     *
     *@return json
     */
    public function getAccessToken($authorizer)
    {
        try {
            //业务逻辑
            $raw = $authorizer->issueAccessToken();
            return $this->apiSuccessPackage($raw);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     *根据uid获取用户信息
     *
     *@param int $uid 用户id
     *@return string
     */
    public function showByUid($uid)
    {
        try {
            //参数验证
            $error = self::langNotes('user');
            $this->validateParam($uid, $error['uid'])->isPositive();
            //业务逻辑
            $raw = App::getController('UsersController')->showByUid($uid);
            return $this->apiSuccessPackage($raw);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     *验证提示文字
     *
     *@return array
     */
    private static function langDictionary()
    {
        $user = [
            'uid' => '用户id有误!',
        ];
        return array(
            'user' => $user,
        );
    }
}
