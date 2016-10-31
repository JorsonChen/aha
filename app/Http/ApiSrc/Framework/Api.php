<?php

namespace ApiSrc\Framework;

use ApiSrc\Config\ApiStatusConfig;
use ApiSrc\Utils\ArrayUtils;
use ApiSrc\Utils\Validator;
use ApiSrc\Utils\StringUtils;

/**
 * Api接口基类.
 */
class Api
{
    /**
     *文字提示实例
     *
     *@var array $langInstance
     */
    private static $langInstance=array();

    /**
     *赋值给实例
     *
     *@param array $arrIns 文字数组
     */
    protected static function setLangInstance($arrIns)
    {
        return self::$langInstance=$arrIns;
    }

    /**
     *根据指定key,获取文字提示内容(数组形式)
     *
     *@param string $key 指定的数组key
     *@return array|string
     */
    protected static function langNotes($key)
    {
        $val='';
        $notes=self::$langInstance;
        if (array_key_exists($key, $notes)) {
            $val=$notes[$key];
        }
        return $val;
    }

    /**
     *处理异常.
     *
     *@param $e 异常
     *@return 
     */
    protected function handleException($e)
    {
        $class = get_class($e);
        //根据Exception的类型判断返回结果
        $rst = '';
        switch ($class) {
            //参数异常
        case 'ApiSrc\Framework\Exceptions\ValidationException':
            $rst = $this->apiParamError($e->getMessage());
            break;
            //控制器异常
        case 'ApiSrc\Framework\Exceptions\ControllerException':
            $rst = $this->handleCommonControllerException($e);
            break;
            //数据库错误异常
        case 'ApiSrc\Framework\Exceptions\DbException':
            $rst = $this->handleDbUnknowException($e);
            break;
        case 'Exception':
        default:
            $rst = $this->handleUnknownException($e);
        }

        return $rst;
    }

    /**
     *处理一般的业务逻辑错误.
     *
     *@param $e 异常的实例
     *@return 
     */
    private function handleCommonControllerException($e)
    {
        $code = $e->getCode();
        switch ($code) {
            //与授权验证相关的状态码
            //case 
        //case AuthService::AUTH_FAILED:
            //$code = ApiStatusConfig::code('AUTH_FAILED');
            //$message = 'API验证用户授权失败';
            //break;
        default:
            $code = '';
            $message = '';
        }
        if (!empty($code)) {
            return $this->apiExceptionPackage($code, $message);
        }

        return false;
    }

    /**
     *处理未知的异常.
     *
     *@param $e 异常的实例
     *@return 
     */
    protected function handleUnknownException($e)
    {
        return $this->apiUnknownError($e);
    }
    
    /**
     *未知的数据库异常
     *
     *@param unknown $e 异常的实例
     */
    protected function handleDbUnknowException($e)
    {
        $errorMsg =sprintf("database error:\"%s\"", $e->getMessage());
        $statusCode = ApiStatusConfig::code('DATABASE_ERROR');
        
        return $this->apiPackage($statusCode, $errorMsg);
    }

    /**
     *打包接口数据.
     *
     *@param $statusCode 状态码
     *@param $message 提示信息
     *@param $obj 接口数据
     *@param $list 接口列表数据
     *@return 
     */
    private function apiPackage($statusCode, $message, $obj = array(), $list = array())
    {
        $obj = empty($obj)     ? (object) array() : $obj;
        $list = empty($list)    ? array()         : $list;

        $data = array('obj' => $obj, 'list' => $list);
        $result = array('data' => $data,'msg' => $message,'error' => $statusCode);

        return json_encode($result);
    }

    /**
     *业务逻辑执行正常,返回数据给前端.
     *
     *@param $obj 需要打包的对象
     *@param $list 需要打包的列表
     *@return 
     */
    public function apiSuccessPackage($obj = array(), $list = array())
    {
        $code = ApiStatusConfig::code('API_SUCCESS');
        $message = 'success';

        return $this->apiPackage($code, $message, $obj, $list);
    }

    /**
     *业务逻辑执行不正常,返回错误代码和提示给前端.
     *
     *@param $statusCode 状态码
     *@param $message 状态说明
     *@return 
     */
    protected function apiExceptionPackage($statusCode, $message)
    {
        return $this->apiPackage($statusCode, $message);
    }

    /**
     *参数错误.
     *
     *@param $errorMsg 提示信息
     *@return 
     */
    public function apiParamError($errorMsg)
    {
        $code = ApiStatusConfig::code('API_INVALID_PARAM');

        return $this->apiPackage($code, $errorMsg);
    }

    /**
     *未知错误.
     *
     *@param $e 异常的实例
     *@todo 完善未知错误的异常处理
     *@return 
     */
    public function apiUnknownError($e)
    {
        $errorMsg = $e->getMessage();
        $statusCode = ApiStatusConfig::code('UNKNOWN_ERROR');

        return $this->apiPackage($statusCode, $errorMsg);
    }

    /**
     *验证参数.
     *
     *@param $param 值
     *@param $err 提示信息
     *@throws BadMethodCallException If an attempt was made to call a validator modifier that doesn't exist
     *@throws ValidationException    If the validation check returns false
     *@return 
     */
    public function validateParam($param, $err = null)
    {
        return new Validator($param, $err);
    }


    /**
     *获取当前站点域名.
     *
     *@todo 整理这些公共资源
     *@return string
     */
    protected static function getSiteUrl()
    {
        return SITE_URL;
    }

    /**
     *根据规则数组$delKeys，删除源数据$originRaw中指定key的对应项，并返回删除后的数组
     *
     *eg:.
     *@$originRaw:
     *[
     * array('a'=>'a123','b'=>'abc','c'=>1024),
     * array('a'=>'a789','b'=>'xyz','c'=>1025),
     *]
     *@$delKeys:array('b','c')
     *@deleteKeyBuilders($originRaw,$delKeys)的结果:
     *[
     *array('a'=>'a123'),
     *aray('b'=>'a789'),
     *]
     *
     *@param array $originRaw 源数据数组,是二维数组(列表),如果是一维时(详细)，要转成二维:array($originRaw)
     *@param array $delKeys   要转换的源数组key所构成的数组,eg:array('a','b','c')
     *
     *@return array 返回二维数组，如果要一维数组的则转换二维数组的首项：array[0]
     */
    protected static function deleteKeyBuilder($originRaw, $delKeys)
    {
        foreach ($originRaw as &$oriRaw) {
            foreach ($oriRaw as $key => &$val) {
                if (!in_array($key, $delKeys)) {
                    continue;
                }
                if ($val == $oriRaw[$key]) {
                    unset($oriRaw[$key]);//必须这样删除
                    //unset($val);//不能这样删除哟
                }
            }
        }

        return  $originRaw;
    }

    /**
     *根据规则数组$delKeys，删除源数组$originRaw中指定key的对应项（源数组仅仅是一维数组）.
     *
     *@param array $originRaw 源数据数组（取地址方式,仅仅是一维数组）
     *@param array $delKeys   要删除的key所构成的数组
     */
    protected static function deleteKeySingle(&$originRaw, $delKeys)
    {
        foreach ($originRaw as $key => $val) {
            if (!in_array($key, $delKeys)) {
                continue;
            }
            if ($val == $originRaw[$key]) {
                unset($originRaw[$key]);
            }
        }
    }

    /**
     *根据规则数组$transRaw，占用源数组$originRaw中指定的key,实现替换/占用的效果，并返回转换后的数组.
     *
     *@eg:
     *$originRaw:
     *array(
     *array('name'=>'abc','user_id'=>1024,'follow_uid'=>1023),
     *array('name'=>'xyz','user_id'=>1026,'follow_uid'=>1025),
     *},
     *$transRaw:
     *array('user_id'=>'uid','follow_uid'=>'followUid'),
     *replaceKeyBuilder($originRaw,$transRaw)的结果：
     *array(
     *array('name'=>'abc','uid'=>1024,'followUid'=>1023),
     *array('name'=>'xyz','uid'=>1026,'followUid'=>1025),
     *}
     *如果$originRaw是一维数组，如array('name'=>'xxx','user_id'=>999,'follow_uid'=>1001),
     *则调用时要转成二维array($originRaw),
     *这样调用:replaceKeyBuilder(array($originRaw),$transRaw)
     *
     *@param array $originRaw 源数据数组,是二维数组(列表),如果是一维时(详细)，要转成二维:array($originRaw)
     *@param array $transRaw 转换规则数组,要转换的key所构成的数组,格式：源KEY=>目标KEY,eg:array('a_1'=>A1,'b_2'=>B2,'c_3'=>C3)
     *
     *@return array|mixed 返回二维数组，如果要一维数组的则转换二维数组的首项：array[0]
     */
    protected static function replaceKeyBuilder($originRaw, $transRaw)
    {
         foreach ($originRaw as &$oriRaw) {
             //@originForeach
            foreach ($oriRaw as $key => $val) {
                //@oriForeach
                 foreach ($transRaw as $k => $v) {
                     //@transForeach
                    if ($key != $k) {
                        continue;
                    }
                    
                     if ($key == $k) {
                         //占位条件
                        $oriRaw[$v] = $val;//占用了源数组中的key位
                        unset($oriRaw[$k]);
                         break;
                     }
                 }
            }
         }

         return $originRaw;
     }

    /**
     *根据规则数组$transRaw，占用源数组$originRaw中指定的key,实现替换/占用的效果（源数组仅仅是一维数组）.
     *
     *@param array $originRaw 源数据数组（取地址方式,仅仅是一维数组）
     *@param array $transRaw  要占用的key所构成的规则数组
     */
    protected static function replaceKeySingle(&$originRaw, $transRaw)
    {
        foreach ($originRaw as $key => $val) {
            foreach ($transRaw as $k => $v) {
                if ($key != $k) {
                    continue;
                }
                if ($key == $k) {
                    //占位条件
                    $originRaw[$v] = $val;//占用了源数组中的key位
                    unset($originRaw[$k]);
                    break;
                }
            }
        }
    }

    /**
     * 根据规则数组，选择性地占用源数组的key,实现替换或删除的效果，并返回转换后的数组
     * eg:
     * $orginRaw:
     * array(
     * ['user_id'=>'1024','gender'=>1,'uname'=>'n1024'],
     * ['user_id'=>'1025','gender'=>2,'uname'=>'n1025'],
     * ['user_id'=>'1026','gender'=>2,'uname'=>'n1026'],
     * ['user_id'=>'1027','gender'=>1,'uname'=>'n1027'],
     * );
     * $transRaw:
     * array(
     * ['origin'=>'user_id', 'target'=>'uid','delFlag'=>1],
     * ['origin'=>'uname', 'target'=>'nickName','delFlag'=>0],
     * );
     * translateKeyBuilder($originRaw,$transRaw)的结果：
     * array(
     * array('uid'=>1024,'gender'=>1,'nickName'=>'n1024','uname'=>'1024'),
     * array('uid'=>1025,'gender'=>2,'nickName'=>'n1025','uname'=>'1025'),
     * array('uid'=>1026,'gender'=>2,'nickName'=>'n1026','uname'=>'1026'),
     * array('uid'=>1027,'gender'=>1,'nickName'=>'n1027','uname'=>'1027'),
     * }.
     *
     * origin要转换的源KEY,target是最终的目标KEY，delFlag表示是否要删除源KEY
     *
     * @param array $orginRaw 源数据数组,是二维数组(列表),如果是一维时(详细)，要转成二维:array($orginRaw)
     * @param array $transRaw 转换规则数组,注意格式:['origin'=>'转换的源KEY', 'target'=>'最终的目标KEY','delFlag'=>'是否删除源KEY:0否,1是'],
     *
     * @return array 返回二维数组，如果要一维数组的则转换二维数组的首项：array[0]
     */
    protected static function translateKeyBuilder($orginRaw, $transRaw)
    {
        $fixRaw = [];
        foreach ($orginRaw as $val) {
            foreach ($val as $ak => $av) {
                $transFlag = false;

                foreach ($transRaw as $item) {
                    if ($ak == $item['origin']) {
                        //占位条件
                        $fixRaw[$item['target']] = $val[$ak];//占位的key=$item['target']
                        if (!(int) $item['delFlag']) {
                            $fixRaw[$ak] = $val[$ak];
                        }
                        $transFlag = true;
                        break;
                    }
                }

                //没有找到占位KEY时，才赋值
                if (!$transFlag) {
                    $fixRaw[$ak] = $av;
                }
            }
            //最终的结果集
            $newRaw[] = $fixRaw;
        }

        unset($orginRaw, $transRaw, $fixRaw);

        return $newRaw;
    }

    /**
     * 根据规则数组$transKeys，将源数组$originRaw中的空数组转换成空对象，并返回转换后的数组
     * eg:.
     *
     * @$originRaw:
     * [
     *  array('a'=>'a123','b'=>[],'c'=>['']),
     *  array('a'=>'a789','b'=>array(''),'c'=>array()),
     * ]
     * @$transKeys:array('b','c')
     * @translateObject($originRaw,$tranKeys)的结果:
     * [
     * array('a'=>'a123','b'=>{},'c'=>{}),
     * aray('b'=>'a789','b'=>{},'c'=>{}),
     * ]
     *
     * @param array $originRaw 源数组,是二维数组(列表),如果是一维时(详细)，要转成二维:array($originRaw)
     * @param array $transKeys 要转换的源数组key所构成的数组,eg:array('a','b','c')
     *
     * @return array 返回二维数组，如果要一维数组的则转换二维数组的首项：array[0]
     */
    protected static function translateObjectBuilder($originRaw, $transKeys)
    {
        foreach ($originRaw as &$oriRaw) {
            foreach ($oriRaw as $key => &$val) {
                if (!in_array($key, $transKeys)) {
                    continue;
                }
                if (ArrayUtils::isEmptyArray($val)) {
                    $val = (Object) array();//空数组转换成空对象:[] -> {}
                }
            }
        }

        return  $originRaw;
    }

    /**
     * 根据规则数组$transKeys，将源数组$originRaw中的空数组转换成空对象（源数组仅仅是一维数组）.
     *
     * @param array $originRaw 源数组（取地址方式,仅仅是一维数组）
     * @param array $transKeys 要转换的源数组key所构成的数组
     */
    protected static function translateObjectSingle(&$originRaw, $transKeys)
    {
        foreach ($originRaw as $key => &$val) {
            if (!in_array($key, $transKeys)) {
                continue;
            }
            if (ArrayUtils::isEmptyArray($val)) {
                $val = (Object) array();//空数组转换成空对象:[] -> {}
            }
        }
    }

    /**
     * 根据规则数组$transKeys，将源数组$originRaw中的值换成空字符串格式（源数组仅仅是一维数组）.
     *
     * @param array $originRaw 源数组（取地址方式,仅仅是一维数组）
     * @param array $transKeys 要转换的源数组key所构成的数组
     */
    protected static function translateStringSingle(&$originRaw, $transKeys)
    {
        foreach ($originRaw as $key => &$val) {
            if (!in_array($key, $transKeys)) {
                continue;
            }
            if (in_array($key, $transKeys)) {
                $val = (string) $val;//转换成字符串格式
            }
        }
    }

    /**
     * 参数返回过滤器.
     *
     * @param $filterStr 过滤器字符串
     * @param $body 返回数据字符串(json格式)
     *
     * @return 
     */
    public function filter($filterStr, $body)
    {
        $filterStr = 'filter:{'.$filterStr.'}';
        $filterAry = StringUtils::convertFilter($filterStr);
        if (empty($filterAry['filter'])) {
            return $body;
        }

        $rawAry = json_decode($body, true);
        $stdObjAry = json_decode($body, false);

        $obj = $originObj = $rawAry['data']['obj'];
        $list = $originList = $rawAry['data']['list'];

        $stdObj = $stdObjAry->data->obj;
        $stdList = $stdObjAry->data->list;

        if (!empty($originObj)) {
            $tmp = ArrayUtils::transform($filterAry['filter'], $originObj);
            ArrayUtils::transformEmptyObj($tmp, $stdObj);
            $obj = $tmp;
        }
        if (!empty($originList)) {
            $list = [];
            $cnt = count($originList);
            for ($i = 0; $i < $cnt; ++$i) {
                $tmp = ArrayUtils::transform($filterAry['filter'], $originList[$i], $stdList[$i]);
                ArrayUtils::transformEmptyObj($tmp, $stdList[$i]);
                $list[] = $tmp;
            }
        }
        $rawAry['data']['obj'] = $obj;
        $rawAry['data']['list'] = $list;

        return json_encode($rawAry);
    }
}
