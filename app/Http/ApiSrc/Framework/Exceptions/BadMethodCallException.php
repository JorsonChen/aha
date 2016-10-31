<?php

namespace ApiSrc\Framework\Exceptions;

/**
 * Class BadMethodCallException.
 */
class BadMethodCallException extends \Exception
{
    const CODE = 200;
    /**
     * 构造函数.
     *
     * @param $message 错误信息
     * @param $code 错误代码
     *
     * @return 
     */
    public function __construct($message, $code = self::CODE)
    {
        parent::__construct($message, $code);
        $this->type = get_class($this);
    }
}
