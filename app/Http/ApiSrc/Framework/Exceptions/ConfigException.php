<?php

namespace ApiSrc\Framework\Exceptions;

/**
 * Class ConfigException.
 */
class ConfigException extends \Exception
{
    /**
     * 默认错误代码.
     */
    const CONFIG_ERROR = 800;

    /**
     * mysql配置读取失败.
     */
    const MYSQL_CONFIG_ERROR = 801;

    /**
     * mysql配置,可写数据库读取失败.
     */
    const MYSQL_WRITE_CONFIG_ERROR = 802;

    /**
     * mysql配置,只读数据库读取失败.
     */
    const MYSQL_READ_CONFIG_ERROR = 803;

    /**
     * mysql配置的结构数组格式问题.
     */
    const MYSQL_FORMAT_CONFIG_ERROR = 804;

    /**
     * 构造函数.
     *
     * @param $message 错误信息
     * @param $code 错误代码
     *
     * @return 
     */
    public function __construct($message, $code = self::CONFIG_ERROR)
    {
        parent::__construct($message, $code);
        $this->type = get_class($this);
    }
}
