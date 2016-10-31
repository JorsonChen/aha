<?php

namespace ApiSrc\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class LogUtils
 * @author cyleung
 */
class LogUtils
{
    /**
     * Detailed debug information
     */
    const DEBUG = 100;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    const INFO = 200;

    /**
     * Uncommon events
     */
    const NOTICE = 250;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    const WARNING = 300;

    /**
     * Runtime errors
     */
    const ERROR = 400;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    const CRITICAL = 500;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    const ALERT = 550;

    /**
     * Urgent alert.
     */
    const EMERGENCY = 600;

    /**
     * 添加日志
     *
     * @param $loggerPath 日志文件夹路径,如"/log/"(相对路径)
     * @param $loggerName 日志文件名称,如"op_log.log"
     * @param $message 操作的动作,如add_user,edit_user,注意!空字符会转换为_
     * @param $context 可传入数组
     * @param $loggerType 日志类型,默认为LogUtils::INFO 
     *
     * @return 
     */
    public static function addLog($loggerPath, $loggerName, $message, array $context=[], $loggerType=LogUtils::INFO)
    {
        $path = SITE_PATH.$loggerPath;
        if (!file_exists($path) || !is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $log = new Logger($loggerName);
        $log->pushHandler(new StreamHandler($path.'/'.$loggerName, $loggerType, true, 644, true));

        switch ($loggerType) {
        case LogUtils::ALERT:
            $log->alert($message, $context);
            break;
        case LogUtils::CRITICAL:
            $log->critical($message, $context);
            break;
        case LogUtils::DEBUG:
            $log->debug($message, $context);
            break;
        case LogUtils::EMERGENCY:
            $log->emergency($message, $context);
            break;
        case LogUtils::ERROR:
            $log->error($message, $context);
            break;
        case LogUtils::INFO:
            $log->info($message, $context);
            break;
        case LogUtils::NOTICE:
            $log->notice($message, $context);
            break;
        case LogUtils::WARNING:
            $log->warning($message, $context);
            break;
        default:
            $log->info($message, $context);
            break;
        }
    }
}
