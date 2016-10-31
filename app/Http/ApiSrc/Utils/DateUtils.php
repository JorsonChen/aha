<?php

namespace ApiSrc\Utils;

/**
 * DateUtils.
 */
class DateUtils
{
    /**
     * 获取日期在当天的00:00:00.
     *
     * @param unknown $date 格式 Y-m-d H:i:s
     */
    public static function getDateStartDatetime($date)
    {
        $time = strtotime($date);

        return date('Y-m-d 00:00:00', $time);
    }

    /**
     * 获取指定日期在当天的23:59：59.
     *
     * @param $date 指定日期 Y-m-d H:i:s
     *
     * @return
     */
    public static function getDateEndDatetime($date)
    {
        $date = self::getDateStartDatetime($date);
        $time = strtotime($date);
        $time += 86399; //60*60*24 -1;
        return date('Y-m-d H:i:s', $time);
    }

    /**
     * 通过时间戳获取Date月份.
     *
     * @param number $timestamp 时间戳
     */
    public static function getDateMonth($timestamp)
    {
        $dateSTr = date('Y-m', $timestamp);

        return $dateSTr.'-01 00:00:00';
    }

    /**
     * 传入‘Y-m’，补全‘-d H:i:s’.
     *
     * @param $dateMonth  年月:Y-m格式
     *
     * @return date string Y-m-d H:i:s
     */
    public static function getSearchFormat($dateMonth)
    {
        return $dateMonth.'-01 00:00:00';
    }

    /**
     * 获取传入任意Y-m-d格式日期的前一天的23:59:59.
     *
     * @param string $fullDate 格式: Y-m-d H:i:s
     *
     * @return date string Y-m-d H:i:s
     */
    public static function getTheDatetimeBefore($fullDate)
    {
        $timestamp = strtotime($fullDate);
        $theBeforeDayTimestamp = $timestamp - 1;
        $theBeforeDayDatetime = date('Y-m-d H:i:s', $theBeforeDayTimestamp);

        return $theBeforeDayDatetime;
    }

    /**
     * 将任意一个Y-m-d格式转换为传入月份最后一天，23点59分59秒.
     *
     * @param string $fullDate 日期格式:Y-m-d
     */
    public static function getTheEndOfMonth($fullDate)
    {
        $timestamp = strtotime($fullDate);
        $t1 = date('Y-m-01 23:59:59', $timestamp);
        $t2 = date('Y-m-d H:i:s', strtotime($t1.' +1 month -1 day'));

        return $t2;
    }

    /**
     * 将任意一个Y-m-d格式转换为传入月份的第一天，0点0分0秒.
     *
     * @param string $fullDate 日期格式:Y-m-d
     */
    public static function getStartOfMonth($fullDate)
    {
        $timestamp = strtotime($fullDate);
        $res = date('Y-m-01 00:00:00', $timestamp);

        return $res;
    }
    
    /**
     * 检查日期格式是否符合时间日期格式
     * (验证时间日期格式，并验证其有效性)
     * @param string $dateTime 时间日期字符串,eg:YYYY-mm-dd,YYYY/mm/dd,
     * 
     * @return bool
     */
    public static function isDateTime($dateTime)
    {
        $ret = strtotime($dateTime);
        return $ret !== false && $ret != -1;
    }
    
    /**
     * 检查日期格式是否 Y-m 的有效日期格式(验证日期格式与有效性)
     * @param string $dateTime 时间日期字符串
     * @return bool
     */
    public static function isDateTimeYm($dateTime)
    {
        $retFlag=self::isDateTime($dateTime);
        $regxFlag=preg_match('/^\d{4}-\d{2}$/', $dateTime);
        
        return ($retFlag&&$regxFlag);
    }
    
    /**
     * 检查日期格式是否 Y-m-d 的有效日期格式(验证日期格式与有效性)
     * @param string $dateTime 时间日期字符串
     * @return bool
     */
    public static function isDateTimeYmd($dateTime)
    {
        $retFlag=self::isDateTime($dateTime);
        $regxFlag=preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTime);
         
        return ($retFlag&&$regxFlag);
    }
    
    /**
     * 检查日期格式是否 Y-m-d H:i:s 的有效日期格式(验证日期格式与有效性)
     * @param string $dateTime 时间日期字符串
     * @return bool
     */
    public static function isDateTimeYmdHis($dateTime)
    {
        $retFlag=self::isDateTime($dateTime);
        $regxFlag=preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $dateTime);
    
        return ($retFlag&&$regxFlag);
    }
    
    /**
     * 检查日期格式是否 Y-m-d H:i 的有效日期格式(验证日期格式与有效性),止到分钟数
     * @param string $dateTime 时间日期字符串
     * @return bool
     */
    public static function isDateTimeYmdHi($dateTime)
    {
        $retFlag=self::isDateTime($dateTime);
        $regxFlag=preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $dateTime);
    
        return ($retFlag&&$regxFlag);
    }

    /**
     * 检查日期格式是否 Y-m 的日期格式
     * 这个验证只能验证格式，不能验证日期的准确性。
     * 例如 2011-00 2012-19 都能通过验证。.
     *
     * @param string $dateMonth 格式：Y-m
     *
     * @return bool
     */
    public static function isDateMonthFormat($dateMonth)
    {
        if (preg_match('/^\d{4}-\d{2}$/', $dateMonth)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检查日期格式是否 Y-m-d H:i:s 的日期格式
     * 这个验证只能验证格式，不能验证日期的准确性。.
     *
     * @param unknown $fullDate 日期格式:Y-m-d
     *
     * @return bool
     */
    public static function isFullDateFormat($fullDate)
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $fullDate)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 将日期格式转为YYYY-mm-dd HH:ii:ss(Y-m-d H:i:s).
     *
     * @param $date 日期格式: Y-m-d
     *
     * @return 
     */
    public static function toFullDateFormat($date)
    {
        $time = strtotime($date);//$date为空值或错误的日期时间格式，将返回0
        if (false != $time) {
            return date('Y-m-d H:i:s', $time);
        }

        return '';
    }

    /**
     * 将日期格式转化为YYYY:mm:dd形式.
     *
     * @param string $date 符合日期格式的字符串:YYYY:mm:dd HH:ii:ss 
     * 
     * @return 
     */
    public static function toFullDateFormatYMD($date)
    {
        $time = strtotime($date);
        if (false != $time) {
            return date('Y-m-d', $time);
        }

        return '';
    }

    /**
     * 检查日期格式是否 Y-m-d
     * 这个验证只能验证格式，不能验证日期的准确性。.
     *
     * @param $fullDate 日期格式:Y-m-d
     */
    public static function isFullDateFormatYMD($fullDate)
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fullDate)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取指定日期所在星期的开始时间与结束时间（周一到周日）.
     *
     * @param unknown $date 日期格式:Y-m-d
     *
     * @return array 返回的日期格式 Y-m-d
     */
    public static function getWeekRangeYMD($date)
    {
        $ret = array();
        $timestamp = strtotime($date);
        $w = (int) strftime('%u', $timestamp);
        $ret['startDatetime'] = date('Y-m-d', $timestamp - ($w - 1) * 86400);
        $ret['endDatetime'] = date('Y-m-d', $timestamp + (7 - $w) * 86400);

        return $ret;
    }

    /**
     * 获取指定日期所在星期的开始时间与结束时间（周一到周日）.
     *
     * @param unknown $date 日期格式:Y-m-d
     *
     * @return array 返回的日期格式包含时分秒。 Y-m-d H:i:s
     */
    public static function getWeekRange($date)
    {
        $ret = array();
        $timestamp = strtotime($date);
        $w = (int) strftime('%u', $timestamp);
        $ret['startDatetime'] = date('Y-m-d 00:00:00', $timestamp - ($w - 1) * 86400);
        $ret['endDatetime'] = date('Y-m-d 23:59:59', $timestamp + (7 - $w) * 86400);

        return $ret;
    }

    /**
     * 检查日期是否超过当前月份.
     *
     * @param unknown $dateMonth       格式：Y-m 
     * @param unknown $currentDatetime 格式：Y-m-d 当前时间
     *
     * @return bool
     */
    public static function isOverCurrentMonth($dateMonth, $currentDatetime)
    {
        if (self::isDateMonthFormat($dateMonth)) {
            //补全日期格式，并获取一号第一秒
            $fullDate = self::getSearchFormat($dateMonth);
        } elseif (self::isFullDateFormat($dateMonth)) {
            //获取月份的一号第一秒
            $fullDate = self::getStartOfMonth($dateMonth);
        } else {
            return false;
        }
        $endOfCurrentMonth = self::getTheEndOfMonth($currentDatetime);

        return strtotime($fullDate) > strtotime($endOfCurrentMonth);
    }

    /**
     * 获取某日格式化时间的开始时间，返回格式是 Y-m-d H:i:s 格式.
     *
     * @param unknown $date 格式：Y-m-d
     */
    public static function getFullFormatedDateStart($date)
    {
        return $date.' 00:00:00';
    }

    /**
     * 获取某日格式化时间的结束时间，返回格式是 Y-m-d H:i:s 格式.
     *
     * @param unknown $date 格式：Y-m-d
     */
    public static function getFullFormatedDateEnd($date)
    {
        return $date.' 23:59:59';
    }
}
