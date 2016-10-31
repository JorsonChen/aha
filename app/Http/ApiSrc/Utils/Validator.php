<?php

namespace ApiSrc\Utils;

use ApiSrc\Framework\Exceptions\ValidationException;
use ApiSrc\Framework\Exceptions\BadMethodCallException;
use ApiSrc\Utils\DateUtils;

/**
 * 接口层参数验证.
 */
class Validator
{
    /**
     * 接口层参数验证工具类.
     */

    /**
     * The available validator methods.
     *
     * @var array
     */

    /**
     * The string to validate.
     *
     * @var string
     */
    protected $str;

    /**
     * The custom exception message to throw on validation failure.
     *
     * @var string
     */
    protected $err;

    /**
     * Flag for whether the default validation methods have been added or not.
     *
     * @var bool
     */
    //protected static $defaultAdded = false;

    /**
     * Sets up the validator chain with the string and optional error message.
     *
     * @param string $str The string to validate
     * @param string $err The optional custom exception message to throw on validation failure
     */
    public function __construct($str, $err = null)
    {
        $this->str = $str;
        $this->err = $err;
        //if (!static::$defaultAdded) {
        //    static::addDefault();
        //}
    }

    /**
     * 判断参数是否为空或null(如果满足否判断，则引发指定的意外提示).
     */
    public function isNullOrEmpty()
    {
        $mtStr = $this->str;
        //为空或null
        $resFlag = ($mtStr === null || $mtStr === '');

        //如果不满足"既不为空也不为null"判断时，才则引发指定的意外提示
        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否既不为空也不为null(如果满足否判断，则引发指定的意外提示).
     * 
     * @return number|bool
     */
    public function notNullAndEmpty()
    {
        $mtStr = $this->str;
        //既不为空也不为null
        $resFlag = ($mtStr !== null && $mtStr !== '');

        //如果不满足"既不为空也不为null"判断时，才则引发指定的意外提示
        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数字符串是否在规定的长度范围内(如果满足否判断，则引发指定的意外提示).
     * 
     * @param number $min 最小值(必须指定)
     * @param number $max 最大值（如不指定，则长度只能取最小值）
     * 
     * @return number|bool
     */
    public function isLen($min, $max = null)
    {
        $mtStr = $this->str;
        //在规定的长度范围内
        $len = strlen($mtStr);//字符串所占的字节长度
        //$len = iconv_strlen($mtStr,"UTF-8");//统计字符串的字符数量
        $resFlag = (null === $max ? $len === $min : $len >= $min && $len <= $max);

        return  $this->validateResult($resFlag);
    }
    
    /**
     * [推荐]判断参数字符串是否在规定的长度范围内(如果满足否判断，则引发指定的意外提示)--统计字符串(不论中英文)的字符数量-mysql的varchar长度也是计字符数量的.
     *
     * @param number $min 最小值(必须指定)
     * @param number $max 最大值（如不指定，则长度只能取最小值）
     *
     * @return number|bool
     */
    public function isLenIconv($min, $max = null)
    {
        $mtStr = $this->str;
        //在规定的长度范围内
        $len = iconv_strlen($mtStr, "UTF-8");//统计字符串(不论中英文)的字符数量
        $resFlag = (null === $max ? $len === $min : $len >= $min && $len <= $max);
    
        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数字符串是否为整数类型(int).
     * 
     * @return number|bool
     */
    public function isInt()
    {
        $mtStr = $this->str;
        $resFlag = ((string) $mtStr === ((string) (int) $mtStr));//本身判断，已经反转:false

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否正整数(大于0的整数).
     *
     * @return number|bool
     */
    public function isPositive()
    {
        $mtStr = $this->str;
        //大于0的正整数
        $resFlag = (((string) $mtStr === ((string) (int) $mtStr)) && ((int) $mtStr > 0));

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否正整数或者等于0(大于0的整数或者等于0).
     *
     * @return number|bool
     */
    public function isPositiveAndZero()
    {
        $mtStr = $this->str;
        //大于0的正整数和0
        $resFlag = (((string) $mtStr === ((string) (int) $mtStr)) && ((int) $mtStr >= 0));

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否正数(大于0的数字).
     *
     * @return number|bool
     */
    public function isPositiveNumber()
    {
        $mtStr = $this->str;

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);//匹配则返回1,只匹配一次
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        $mtFlag = ((float) $mtStr > (float) 0);
        $resFlag = ($resFlag && $mtFlag);//大于0的数字

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否正数或者等于0(大于0的数字或者等于0).
     *
     * @return number|bool
     */
    public function isPositiveNumberAndZero()
    {
        $mtStr = $this->str;

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        $mtFlag = ((float) $mtStr >= (float) 0);
        $resFlag = ($resFlag && $mtFlag);//大于0的数字或者等于0

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否负数(小于0的数字).
     *
     * @return number|bool
     */
    public function isNegativeNumber()
    {
        $mtStr = $this->str;

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        $mtFlag = ((float) $mtStr < (float) 0);
        $resFlag = ($resFlag && $mtFlag);//小于0的数字

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否负数或者等于0(小于0的数字或者等于0).
     *
     * @return number|bool
     */
    public function isNegativeNumberAndZero()
    {
        $mtStr = $this->str;

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        $mtFlag = ((float) $mtStr <= (float) 0);
        $resFlag = ($resFlag && $mtFlag);//小于0的数字或者等于0

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数字符串是否为浮点数类型(单精度,float).
     * 
     * @return number|bool
     */
    public function isFloat()
    {
        $mtStr = $this->str;//加(float)，是防止50!==50.0这种情况,(float)50.0 =>50;(float)50.06 =>50.06
        //单精度数据类型(浮点数)
        //$resFlag = ((string) $mtStr === ((string) (float) $mtStr));

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否单精度数据类型(浮点数)并且大于0.
     *
     * @return number|bool
     */
    public function isPositiveFloat()
    {
        $mtStr = $this->str;
        //大于0的双精度数据类型(浮点数)
        //$resFlag=(((string) $mtStr === ((string) (float) $mtStr)) && ((float) $mtStr > 0));

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        $resFlag = ($resFlag && ((float) $mtStr > 0));

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否单精度数据类型(浮点数)并且小于0.
     *
     * @return number|bool
     */
    public function isNegativeFloat()
    {
        $mtStr = $this->str;

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        $resFlag = ($resFlag && ((float) $mtStr < 0));

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否双精度数据类型.
     *
     * @return number|bool
     */
    public function isDouble()
    {
        $mtStr = $this->str;

        //加(double)，是防止50!==50.00这种情况,(double)50.00 =>50;(double)50.06 =>50.06    	

        //双精度数据类型
        //$resfFlag = is_double($mtStr);//50.362a都认为是
        //$resFlag=(((string) $mtStr === ((string) (double) $mtStr)));//不能处理最后是零的数：50.1200,50.00

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否双精度数据并且大于0.
     *
     * @return number|bool
     */
    public function isPositiveDouble()
    {
        $mtStr = $this->str;
        //大于0的双精度数据
        //$resFlag=(((string) $mtStr === ((string) (double) $mtStr)) && ((double) $mtStr > 0));

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        $resFlag = ($resFlag && ((double) $mtStr > 0));

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否双精度数据并且小于0.
     *
     * @return number|bool
     */
    public function isNegativeDouble()
    {
        $mtStr = $this->str;
        //大于0的双精度数据
        //$resFlag=(((string) $mtStr === ((string) (double) $mtStr)) && ((double) $mtStr > 0));

        //floag/double : /^-?(?:\d+|\d*\.\d+)$/
        $pattern = '/^-?(?:\d+|\d*\.\d+)$/';//
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        $resFlag = ($resFlag && ((double) $mtStr < 0));

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否符合电子邮件格式.
     * 
     * @return number|bool
     */
    public function isEmail()
    {
        $mtStr = $this->str;
        $resFlag = (filter_var($mtStr, FILTER_VALIDATE_EMAIL) !== false);
        //$resFlag =strlen($mtStr)>3&&(preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/",$mtStr)!== false);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否符合普通URL地址格式.
     * 
     * @return number|bool
     */
    public function isUrl()
    {
        $mtStr = $this->str;
        $resFlag = (filter_var($mtStr, FILTER_VALIDATE_URL) !== false);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否符合普通IP地址格式.
     * 
     * @return number|bool
     */
    public function isIP()
    {
        $mtStr = $this->str;
        $resFlag = (filter_var($mtStr, FILTER_VALIDATE_IP) !== false);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否符合远程IP地址格式.
     * 
     * @return number|bool
     */
    public function isRemoteIP()
    {
        $mtStr = $this->str;
        $resFlag = (filter_var($mtStr, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false);

        return  $this->validateResult($resFlag);
    }

    //@codeCoverageIgnoreStart
    /**
     * 判断参数是否是字母和数字或字母数字的组合.
     * 
     * @return number|bool
     */
    public function isAlnum()
    {
        $mtStr = $this->str;
        $resFlag = ctype_alnum($mtStr);

        return  $this->validateResult($resFlag);
    }
    //@codeCoverageIgnoreEnd

    //@codeCoverageIgnoreStart
    /**
     * 判断参数是否是英文字母的字符串.
     * 
     * @return number|bool
     */
    public function isAlpha()
    {
        $mtStr = $this->str;
        $resFlag = ctype_alpha($mtStr);

        return  $this->validateResult($resFlag);
    }
    //@codeCoverageIgnoreEnd

    //@codeCoverageIgnoreStart
    /**
     * 判断参数是否是数字的字符串.
     *
     * @return number|bool
     */
    public function isDigit()
    {
        $mtStr = $this->str;
        $resFlag = ctype_digit($mtStr);

        return  $this->validateResult($resFlag);
    }
    //@codeCoverageIgnoreEnd

    /**
     * 判断参数是否包含在指定的对象中(验证$needle是否包含在$mtStr中).
     *
     * @param string|mixed $needle 被验证的字符串或对象
     * 
     * @return number|bool
     */
    public function isContains($needle)
    {
        $mtStr = $this->str;
        $resFlag = (strpos($mtStr, $needle) !== false);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否满足指定正则表达式格式.
     *
     * @param string $pattern 被验证的正则表达式字符串
     *
     * @return number|bool
     */
    public function isRegex($pattern)
    {
        $mtStr = $this->str;
        //$resFlag =preg_match($pattern, $mtStr);

        //preg_match()返回pattern的匹配次数：0次（不匹配）或1次,（preg_match()在第一次匹配后 将会停止搜索.）
        //如果发生错误preg_match()返回 FALSE。

        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        return $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否符合日期格式.
     * 
     * @todo 过滤time()函数的时间戳
     * 
     * @return number|bool
     */
    public function isDate()
    {
        $mtStr = $this->str;
        $resFlag = (strtotime($mtStr) != false);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数格式是否符合年月日的日期格式(Y-m-d)
     * date格式:Y-m-d.
     * 
     * @return number|bool
     */
    public function isYmd()
    {
        $mtStr = $this->str;
        //date格式:d-m-Y //国际
        $d1 = date('d-m-Y', strtotime($mtStr));
        $resFlag = (strtotime($d1) === strtotime($mtStr));

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数格式是否符合完全的日期时间格式(Y-m-d H:i:s)
     * date格式:Y-m-d H:i:s.
     *
     * @todo 过滤time()函数的时间戳
     * 
     * @return number|bool
     */
    public function isYmdhis()
    {
        $mtStr = $this->str;
        //date格式:d-m-Y H:i:s
        $d1 = date('d-m-Y H:i:s', strtotime($mtStr));
        $resFlag = (strtotime($d1) === strtotime($mtStr));

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数格式是否符合只取到分钟的日期时间格式(不要最后秒数的,Y-m-d H:i)
     * date格式:Y-m-d H:i.
     *
     * @todo 过滤time()函数的时间戳
     * 
     * @return number|bool
     */
    public function isYmdhi()
    {
        $mtStr = $this->str;
        //date格式:Y-m-d H:i:s
        $d1 = date('Y-m-d H:i:s', strtotime($mtStr));
        $resFlag = (strtotime($d1) === strtotime($mtStr));

        return  $this->validateResult($resFlag);
    }
    
    /**
     * 验证是否是身份证号码格式(兼容15、18位)，简单格式(兼容X的大小写)
     * @param number $lnt  位数(15或18位,其它数字时代表同时兼容15、18位)
     * @return number|boolean
     */
    public function isIdCardNoSimply($lnt=0)
    {
        //(.*)(/.jpg|/.png)$/ 只能是jpg或png格式,eg:abc.jpg,xyz.png
        ///^(/jpg|/png)$/ 只能是jpb或png的字符串,eg:jpg,png,但非abc.jpg,abc.png
        $mtStr =(string)$this->str;
        $mtStr=strtoupper($mtStr);//字母全部转成大写,兼容X的大小写
        $pattern="/^(\d{17}(\d|X)|\d{15})$/";//修正符:i 不区分大小写的匹配,默认是区分大小写的，什么也没有是默认
        if ($lnt==15) {
            $pattern="/^\d{15}$/";
        }
        if ($lnt==18) {
            $pattern="/^\d{17}(\d|X)$/";
        }//大写字母X
        $resFlag =preg_match($pattern, $mtStr);
        return  $this->validateResult($resFlag);
    }
    
    
    /**
     * 验证是否是身份证号码格式(兼容15、18位),严格格式-验证出生日期(兼容X的大小写)
     * @param number $lnt  位数(15或18位,其它数字时代表同时兼容15、18位)
     * @return number|boolean 
     */
    public function isIdCardNoFullYmd($lnt=0)
    {
        $mtStr =(string)$this->str;
        $mtStr=strtoupper($mtStr);//字母全部转成大写,兼容X的大小写
        $resFlag =false;
        if (!in_array($lnt, [15, 18])) {
            $flag15=$flag18=false;
            //(\d{2})(\d{2})(\d{2})
            //15位的都19开始的年代的:    		
            $flag15=self::chkIdCardNoFullYmd15($mtStr);
            //(\d{4})(\d{2})(\d{2})
            $flag18=self::chkIdCardNoFullYmd18($mtStr);
            if ($flag15||$flag18) {
                $resFlag=true;
            }
        } else {
            if ($lnt==15) {
                $resFlag=self::chkIdCardNoFullYmd15($mtStr);
            }
            if ($lnt==18) {
                $resFlag=self::chkIdCardNoFullYmd18($mtStr);
            }
        }
        return  $this->validateResult($resFlag);
    }
    
    /**
     * 验证15位身份证号码格式
     * @param string $mtStr 身份证号码字符串
     * @return bool
     */
    private function chkIdCardNoFullYmd15($mtStr)
    {
        $flag15=false;
        $pattern="/^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/";
        if (preg_match($pattern, $mtStr, $arrOut)) {
            //(\d{2})(\d{2})(\d{2})
            //15位的都19开始的年代的:
            $ymd15=sprintf('19%s-%s-%s', $arrOut[2], $arrOut[3], $arrOut[4]);//99-12-25,99/12/25
            $flag15=DateUtils::isDateTime($ymd15);
        }
        
        return $flag15;
    }
    
    /**
     * 验证18位身份证号码格式
     * @param string $mtStr 身份证号码字符串
     * @return bool
     */
    private function chkIdCardNoFullYmd18($mtStr)
    {
        $flag18=false;
        $pattern="/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/";
        if (preg_match($pattern, $mtStr, $arrOut)) {
            //(\d{4})(\d{2})(\d{2})
            $ymd18=sprintf('%s-%s-%s', $arrOut[2], $arrOut[3], $arrOut[4]);//2001-12-25,2001/12/25
            $flag18=DateUtils::isDateTime($ymd18);
        }
        return $flag18;
    }

    
    /**
     * 判断参数是否在指定的集合中.
     * 
     * @param array $set 指定的数组集合
     * 
     * @return number|bool
     */
    public function isIn($set)
    {
        $mtStr = $this->str;
        //是否在指定的集合中
        $resFlag = in_array($mtStr, $set);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数的值是否在min和max之间.
     * 
     * @param number $min 最小值（必须指定）
     * @param number $max 最大值（如不指定，则数值只能取最小值）
     * 
     * @return number|bool
     */
    public function isBetween($min, $max = null)
    {
        $cnt = $this->str;
        //判断参数的值是否在min和max之间
        $resFlag = (null === $max ? $cnt === $min : $cnt >= $min && $cnt <= $max);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数的值是否小于或等于$val.
     *
     * @param int $val 指定的边界数值
     * 
     * @return number|bool
     */
    public function isLessThanEqualTo($val)
    {
        $cnt = $this->str;
        if (!is_numeric((string) $cnt)) {
            $cnt = 0;
        }
        //is_numeric：检测是否为数字字符串，可为负数和小数    	
        //ctype_digit：检测字符串中的字符是否都是数字，负数和小数会检测不通过    	
        //注意，参数一定要是字符串，如果不是字符串，则会返回0/FASLE (所以要强制转字符：(string)$cnt)
        //判断参数的值$cnt是否小于或等于$val
        $resFlag = ($cnt <= (int) $val);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数的值是否小于$val.
     *
     * @param int $val 指定的边界数值
     * 
     * @return number|bool
     */
    public function isLessThanOnly($val)
    {
        $cnt = $this->str;
        if (!is_numeric((string) $cnt)) {
            $cnt = 0;
        }
        //判断参数的值$cnt是否小于$val
        $resFlag = ($cnt < (int) $val);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数的值是否大于或等于$val.
     *
     * @param int $val 指定的边界数值
     *
     * @return number|bool
     */
    public function isGreatThanEqualTo($val)
    {
        $cnt = $this->str;
        if (!is_numeric((string) $cnt)) {
            $cnt = 0;
        }
        //判断参数的值$cnt是否大于或等于$val
        $resFlag = ($cnt >= (int) $val);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数的值是否大于$val.
     *
     * @param int $val 指定的边界数值
     *
     * @return number|bool
     */
    public function isGreatThanOnly($val)
    {
        $cnt = $this->str;
        if (!is_numeric((string) $cnt)) {
            $cnt = 0;
        }
        //判断参数的值$cnt是否大于$val
        $resFlag = ($cnt > (int) $val);

        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否为数组.
     * 
     * @return number|bool
     */
    public function isArray()
    {
        $ary = $this->str;
        //判断参数是否为数组
        $resFlag = is_array($ary);
        //此时，$ary为非数组时，就会引发Exception，抛出意外。
        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否为非数组.
     *
     * @return number|bool
     */
    public function notArray()
    {
        $ary = $this->str;
        //判断参数是否为数组
        $resFlag = !(is_array($ary));//非数组
        //此时，$ary为数组时，就会引发Exception，抛出意外。
        return  $this->validateResult($resFlag);
    }

    /**
     * 判断参数：是空数组或不是数组(纯字符串或空字符)(参数为数组或是纯字符串或是空字符时，都会引发Exception).
     * 
     * @return number|bool
     */
    public function isEmptyOrNotArray()
    {
        $ary = $this->str;//被验证的字符串或数组    	

        $flag = is_array($ary);
        if ((!$flag) || empty($ary)) {
            $flag = true;
            //不是数组是预期的，@所以true
            //空字符串是预期的，@所以true
        } else {
            //首先必须是数组，才能判断是否为空数组
            //当$ary是数组时，则count($ary)=0时，$ary应该都是空数组了
            //但有一种情况例外:count([''])==1,原来['']也视作空数组的
            $funClosure = function ($isFlag) use ($ary) {
              return ($isFlag && ((count($ary) == 0) || in_array('', $ary)));
            };
            $flag = $funClosure($flag); // 闭包，要调用才生效
        }

        //参数$ary为非空数组或是数组时，都会引发Exception，抛出意外。
        return  $this->validateResult($flag);
    }

  /**
   * 判断参数是否为数组并且为非空数组(参数为空数组或不是数组(纯字符串或空字符)时，都会引发Exception).
   * 
   * @return number|bool
   */
  public function notEmptyAndIsArray()
  {
      $ary = $this->str;
      $flag = is_array($ary);
    //注意:不是数组(纯字符串或空字符)的都视作空数组      

    $funClosure = function ($isFlag) use ($ary) {
      // count([''])==1,需要加入in_array二次验证
      return ($isFlag && (count($ary) > 0) && (!in_array('', $ary)));
    };
      $flag = $funClosure($flag);

    // 此时，$ary为空数组或不是数组(纯字符串或空字符)时，就会引发Exception，抛出意外。
    return $this->validateResult($flag);
  }

    /**
     * 由默认长度为3-18个英文字母、阿拉伯数字、点、下划线组成(必须包含其中的一项或多项),并且符合电邮格式的字符串,
     * 必须以由英文字母、阿拉伯数字组成的字符串(必须包含其中的一项或多项)开头.
     *
     * @param number $min 最小长度
     * @param number $max 最大长度
     * 
     * @return number|bool
     */
    public function isRegEmail($min = 3, $max = 18)
    {
        $mtStr = $this->str;

        //'/^def/'以def开头
        //^(caret)和$(dollar)字符将表达式限制在一个字符串的起点和终点位置，
        //这样可以确保整个用户名符合我们的设定，而不是一部分。
        //'/^def$/'以def开头

        $pattern = '/^[a-zA-Z0-9]{1}[a-zA-Z0-9|.|_|-]{'.$min.','.$max.'}[@][a-zA-Z0-9|_|-]+([.][a-zA-Z0-9|_]+)*[.][a-zA-Z]{2,4}$/';
        //$pattern ='/^[a-zA-Z0-9]{1}[a-zA-Z0-9\_\.\-]{2,17}[@][a-zA-Z0-9\_]+([.][a-zA-Z0-9\_]+)*[.][a-zA-Z]{2,4}$/';
        //$pattern ='/^[a-zA-Z0-9]{1}[a-zA-Z0-9|.|_|-]{2,17}[@][a-zA-Z0-9|_|-]+([.][a-zA-Z0-9|_]+)*[.][a-zA-Z]{2,4}$/';    	
        //$pattern ='/^[a-zA-Z0-9]{1}+([a-zA-Z0-9_.-]{2,17}+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/';    	 

        //$resFlag =preg_match($pattern,$mtStr);
        /**/
        $resRtn = preg_match($pattern, $mtStr);
        if (false !== $resRtn) {
            $resFlag = ($resRtn == 1);
        }

        return $this->validateResult($resFlag);
    }

    /**
     * 判断参数是否符合昵称格式(必须由汉字、阿拉伯数字、英文字母、减号和下划线组成(必须包含其中的一项或多项),并且默认长度在3或30之间).
     * 
     * @param number $min 最小长度
     * @param number $max 最大长度
     * 
     * @return number|bool
     */
    public function isUserName($min = 3, $max = 30)
    {
        //验证昵称 

        //由字母a～z(不区分大小写)、数字0～9、减号或下划线组成
        //只能以数字或字母开头和结尾 用户名长度为4～18个字符：1+2+1～1+16+1
        //^[a-zA-Z0-9]{1}[a-zA-Z0-9|-|_]{2-16}[a-zA-Z0-9]{1}$/    	
        //用户名为大小写字母或下划线,并以字母开头,长度为6-20
        //$pattern = "/^[a-zA-Z][wd_]{5,19}$/";
        //$pattern = "/^[a-zA-Z]{1}[wd_]{5,19}$/";

        //由汉字、英文字母a～z(不区分大小写)、阿拉伯数字0～9或下划线组成(必须包含其中的一项或多项)
        $mtStr = $this->str;

        /*
    	$pattern = "/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]+$/u";
    	$len = strlen($mtStr);
    	$valid = preg_match($pattern, $mtStr);    
    	$resFlag=($len <= $max && $len >= $min && $valid);
    	*/

        //$pattern = "/^[\x{4e00}-\x{9fa5}|A-Za-z0-9|_|-]{3,30}+$/u";//加入参数u，错误消失，匹配正确:utf-8
        $pattern = "/^[\x{4e00}-\x{9fa5}|A-Za-z0-9|_|-]{".$min.','.$max.'}$/u';//加入参数u，错误消失，匹配正确:utf-8
        //$pattern = "/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{".$min.",".$max."}$/u";//加入参数u，错误消失，匹配正确:utf-8
        $resFlag = preg_match($pattern, $mtStr);

        return $this->validateResult($resFlag);
    }

    /**
     * 返回处理的验证结果或抛出意外.
     * 
     * @param bool $isFlag 是否真假:0,1或false,true
     * 
     * @return number|bool
     * 
     * @throws ValidationException 抛出意外
     */
    private function validateResult($isFlag)
    {
        $isFlag = !($isFlag == 0 || $isFlag == false);//0或false都置为:false===$isFlag,类型与值都相同
        if (false === $this->err) {
            return $isFlag;
        } elseif (false === $isFlag) {
            throw new ValidationException($this->err);
        }
    }

    /*
     * Magic "__call" method.
     *
     * Allows the ability to arbitrarily call a validator with an optional prefix
     * of "is" or "not" by simply calling an instance property like a callback
     *
     * @param string $method The callable method to execute
     * @param array  $args   The argument array to pass to our callback
     *
     * @throws BadMethodCallException If an attempt was made to call a validator modifier that doesn't exist
     * @throws ValidationException    If the validation check returns false
     *
     * @return Validator|bool
     */
    /*
    public function __call($method, $args)
    {   
    	$validator = strtolower($method);
    
    	if (!$validator || !isset($validator)) {
    		throw new BadMethodCallException('Unknown method '.$method.'()');
    	}
    }
    */

    /*
     * @todo
     * Adds default validators on first use.
     */
    /*
    private static function kill_addDefault()
    {
        static::$methods['null'] = function ($str) {
            return $str === null || $str === '';
        };
        static::$methods['notnull'] = function ($str) {
            return $str !== null && $str !== '';
        };
        static::$methods['len'] = function ($str, $min, $max = null) {
            $len = strlen($str);

            return null === $max ? $len === $min : $len >= $min && $len <= $max;
        };
        static::$methods['int'] = function ($str) {
            return (string) $str === ((string) (int) $str);
        };
        static::$methods['float'] = function ($str) {
            return (string) $str === ((string) (float) $str);
        };
        static::$methods['email'] = function ($str) {
            return filter_var($str, FILTER_VALIDATE_EMAIL) !== false;
        };
        static::$methods['url'] = function ($str) {
            return filter_var($str, FILTER_VALIDATE_URL) !== false;
        };
        static::$methods['ip'] = function ($str) {
            return filter_var($str, FILTER_VALIDATE_IP) !== false;
        };
        static::$methods['remoteip'] = function ($str) {
            return filter_var($str, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false;
        };
        static::$methods['alnum'] = function ($str) {
            return ctype_alnum($str);
        };
        static::$methods['alpha'] = function ($str) {
            return ctype_alpha($str);
        };
        static::$methods['contains'] = function ($str, $needle) {
            return strpos($str, $needle) !== false;
        };
        static::$methods['regex'] = function ($str, $pattern) {
            return preg_match($pattern, $str);
        };
        static::$methods['chars'] = function ($str, $chars) {
            return preg_match("/^[$chars]++$/i", $str);
        };
        static::$methods['date'] = function ($str) {
        //return preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $str));
            return strtotime($str) != false;
        };
        //扩展
        static::$methods['username'] = function ($str) {
            //验证昵称
            //昵称只能使用汉字,阿拉伯数字,英文字母和下划线
            $pattern = "/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u";
            $len = strlen($str);
            $valid = preg_match($pattern, $str);

            return ($len <= 30 && $len >= 4 && $valid);
        };
        static::$methods['positive'] = function ($str) {
            //大于0的正整数
            return ((string) $str === ((string) (int) $str)) && ((int) $str > 0);
        };
        static::$methods['positiveandzero'] = function ($str) {
            //大于0的正整数和0
            return ((string) $str === ((string) (int) $str)) && ((int) $str >= 0);
        };
        static::$methods['ymd'] = function ($str) {
            //date格式:Y-m-d
            $d1 = date('d-m-Y', strtotime($str));

            return strtotime($d1) === strtotime($str);
        };
        static::$methods['ymdhis'] = function ($str) {
            //date格式:Y-m-d
            $d1 = date('Y-m-d H:i:s', strtotime($str));

            return strtotime($d1) === strtotime($str);
        };
        static::$methods['in'] = function ($str, $set) {
            //是否在指定的集合中
            return in_array($str, $set);
        };
        static::$methods['between'] = function ($cnt, $min, $max) {
            //判断参数的值是否在min和max之间
            return null === $max ? $cnt === $min : $cnt >= $min && $cnt <= $max;
        };
        static::$methods['array'] = function ($ary) {
            //判断参数是否为数组
            return is_array($ary);
        };
        static::$methods['emptyarray'] = function ($ary) {
            //判断参数是否为空数组
            //“返回颠值为false” =>"触发validateParam"(不是空数组时才触发意外)
            $flag = true;//isEmptyarray($str)是空数组
            if (is_array($ary)) {
                if (count($ary) > 0)$flag =false;//count([''])==1,加入in_array验证
                if (in_array('', $ary))$flag =true;//
            } 
            // 注意:不是数组的都视作空数组
                       
            return !$flag;//由于是“返回颠值为false”才触发意外(为false)，因此在此反转一下
        };

        static::$defaultAdded = true;
    }
    */

    /*
     * Add a custom validator to our list of validation methods.
     *
     * @param string   $method   The name of the validator method
     * @param callable $callback The callback to perform on validation
     */
    //public static function addValidator($method, $callback)
    //{
        //static::$methods[strtolower($method)] = $callback;
    //}

    /*
     * @todo
     * Magic "__call" method.
     *
     * Allows the ability to arbitrarily call a validator with an optional prefix
     * of "is" or "not" by simply calling an instance property like a callback
     *
     * @param string $method The callable method to execute
     * @param array  $args   The argument array to pass to our callback
     *
     * @throws BadMethodCallException If an attempt was made to call a validator modifier that doesn't exist
     * @throws ValidationException    If the validation check returns false
     *
     * @return Validator|bool
     */
    /*
    public function kill__call2($method, $args)
    {
        $reverse = false;
        $validator = $method;
        $methodSubstr = substr($method, 0, 2);

        if ($methodSubstr === 'is') {       // is<$validator>()
            $validator = substr($method, 2);
        } elseif ($methodSubstr === 'no') { // not<$validator>()
            $validator = substr($method, 3);
            $reverse = true;
        }

        $validator = strtolower($validator);

        if (!$validator || !isset(static::$methods[$validator])) {
            throw new BadMethodCallException('Unknown method '.$method.'()');
        }

        $validator = static::$methods[$validator];
        array_unshift($args, $this->str);

        switch (count($args)) {
            case 1:
                $result = $validator($args[0]);
                break;
            case 2:
                $result = $validator($args[0], $args[1]);
                break;
            case 3:
                $result = $validator($args[0], $args[1], $args[2]);
                break;
            case 4:
                $result = $validator($args[0], $args[1], $args[2], $args[3]);
                break;
            default:
                $result = call_user_func_array($validator, $args);
                break;
        }

        $result = (bool) ($result ^ $reverse);

        if (false === $this->err) {
            return $result;
        } elseif (false === $result) {
            throw new ValidationException($this->err);
        }

        return $this;
    }
    */
}
