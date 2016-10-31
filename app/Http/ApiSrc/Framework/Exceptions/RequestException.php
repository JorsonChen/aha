<?php

namespace App\Http\Api\Framework\Exceptions;
namespace ApiSrc\Framework\Exceptions;

/**
 * Class RequestException.
 */
class RequestException extends \Exception
{
    /**
     * 默认远程请求错误码.
     */
    const REQUEST_ERROR = 900;

    /**
     * 构造函数.
     *
     * @param $message 错误信息
     * @param $url 请求的url
     * @param $data 请求时带的参数
     * @param $code 错误代码
     *
     * @return 
     */
    public function __construct($message, $url, $data, $code = self::REQUEST_ERROR)
    {
        $message = $message." url:$url , data:".json_encode($data);
        parent::__construct($message, $code);
        $this->type = get_class($this);
    }
}
