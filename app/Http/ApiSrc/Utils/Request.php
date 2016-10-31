<?php

namespace ApiSrc\Utils;

use Curl\Curl;
use ApiSrc\Framework\Exceptions\RequestException;

/**
 * Class Request
 * 对https://github.com/php-curl-class/php-curl-class 的封装.
 *
 */
class Request
{
    /**
     * 实例对象
     */
    private $requester = null;

    /**
     * 请求次数
     */
    public static $requestCount = 0;

    /**
     * 构造方法.
     *
     * @return 
     */
    public function __construct()
    {
        $this->getRequester();

        return $this;
    }

    /**
     * 获取请求器.
     *
     * @return 
     */
    public function getRequester()
    {
        if ($this->requester == null) {
            $this->setRequester(new Curl());
        }

        return $this->requester;
    }

    /**
     * 设置请求器.
     *
     * @param $requester 请求器
     *
     * @return 
     */
    public function setRequester($requester)
    {
        $this->requester = $requester;

        return $this;
    }

    /**
     * http Get 方法.
     *
     * @param $url url
     * @param $data 查询条件
     * @param $isJsonDecode 调用结果返回是否需要jsondecode
     *
     * @return 
     */
    public function get($url, array $data = [], $isJsonDecode = true)
    {
        Request::$requestCount += 1;
        $this->requester->get($url, $data);
        if ($this->requester->error) {
            throw new RequestException('http get error.', $url, $data);
        } else {
            $response = $this->requester->response;
            if ($isJsonDecode) {
                return json_decode($response, true);
            }
            return $response;
        }
    }

    /**
     * http Post 方法.
     *
     * @param $url url
     * @param $data 请求参数
     * @param $isJsonDecode 调用结果返回是否需要jsondecode
     *
     * @return 
     */
    public function post($url, array $data = [], $isJsonDecode = true)
    {
        Request::$requestCount += 1;
        $this->requester->post($url, $data);
        if ($this->requester->error) {
            throw new RequestException('http post error. '.$this->requester->errorCode.' : '.$this->requester->errorMessage, $url, $data);
        } else {
            $response = $this->requester->response;
            if ($isJsonDecode) {
                return json_decode($response, true);
            }

            return $response;
        }
    }
}
