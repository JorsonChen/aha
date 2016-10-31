<?php

namespace App\Http\Api\Framework\Exceptions;
namespace ApiSrc\Framework\Exceptions;

/**
 * Class DbException.
 */
class DbException extends \Exception
{
    /**
     * 默认数据库错误代码.
     */
    const DB_ERROR = 700;

    /**
     * 构造函数.
     *
     * @param $message 错误信息
     * @param $code 错误代码
     *
     * @return 
     */
    public function __construct($message, $code = 700)
    {
        parent::__construct($message, $code);
        $this->type = get_class($this);
    }
}
