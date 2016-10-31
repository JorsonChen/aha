<?php

namespace ApiSrc\Framework\Exceptions;

/**
 * Class ControllerException.
 */
class ControllerException extends \Exception
{
    /**
     * 授权失败.
     */
    const AUTH_FAILURE = 101;
    /**
     * 参数错误.
     */
    const INVALID_ARGUMENT = 500;
    /**
     * 未知错误.
     */
    const UNKNOWN = 501;

    /**
     * 构造函数.
     *
     * @param $message 错误信息
     * @param $code 错误代码
     *
     * @return 
     */
    public function __construct($message, $code = 501)
    {
        parent::__construct($message, $code);
        $this->type = get_class($this);
    }
}
