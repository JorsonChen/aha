<?php

namespace ApiSrc\Config;

use ApiSrc\Framework\Exceptions\ConfigException;

/**
 * 配置处理类.
 */
class Config
{
    /**
     * 接口passport的auth字段指定为api.
     */
    const PASSPORT_AUTH = 'api';


    /**
     * 配置数组.
     *
     * @return 
     */
    private static $config = array();

    /**
     * 设置配置.
     *
     * @param $config 配置数组
     *
     * @return 
     */
    public static function set($config)
    {
        self::$config = $config;
    }

    /**
     * 读取配置.
     *
     * @return 
     */
    public static function get()
    {
        return self::$config;
    }

    /**
     * 获取头像存储位置基本url.
     *
     * @return 
     */
    public static function getAvatarBaseUrl()
    {
        return self::$config['baseurl']['avatar'];
    }
    
    /**
     * 读取log路径
     * @param unknown $key 键名
     */
    public static function getLogPath($key)
    {
        return self::$config['log_path'][$key];
    }
    
    /**
     * 获取数据库配置.
     *
     * @return 
     */
    public static function getMysqlConfig()
    {
        $config = self::$config;
        //不存在mysql配置
        if (!isset($config['mysql'])) {
            throw new ConfigException('missing mysql config', ConfigException::MYSQL_CONFIG_ERROR);
        }
        if (!isset($config['mysql']['w'])) {
            throw new ConfigException('missing mysql write config', ConfigException::MYSQL_WRITE_CONFIG_ERROR);
        }
        if (!isset($config['mysql']['r'])) {
            throw new ConfigException('missing mysql read config', ConfigException::MYSQL_READ_CONFIG_ERROR);
        }
        //使用随机分配选择只读数据库
        $readCnt = count($config['mysql']['r']);
        $selector = rand(0, $readCnt - 1);
        $readConfig = $config['mysql']['r'][$selector];
        $writeConfig = $config['mysql']['w'];

        self::validateMysqlConfig($readConfig);
        self::validateMysqlConfig($writeConfig);

        return [
            'r' => $readConfig,
            'w' => $writeConfig,
        ];
    }

    /**
     * 获取Redis配置.
     *
     * @return 
     */
    public static function getRedisConfig()
    {
        $config = self::$config;

        return $config['redis'];
    }

    /**
     * 获取又拍云配置.
     *
     * @return 
     */
    public static function getUpyunConfig()
    {
        $config = self::$config;

        return $config['upyun'];
    }

    /**
     * 判断数据库配置是否合法.
     *
     * @param $mysqlConfig 数据库配置数组
     *
     * @return 
     */
    private static function validateMysqlConfig($mysqlConfig)
    {
        $validate = true
            && isset($mysqlConfig['hostname'])
            && isset($mysqlConfig['hostport'])
            && isset($mysqlConfig['username'])
            && isset($mysqlConfig['password'])
            && isset($mysqlConfig['database']);
        if (!$validate) {
            throw new ConfigException('missing mysql read config', ConfigException::MYSQL_FORMAT_CONFIG_ERROR);
        }

        return $validate;
    }

    /**
     * 获取生活圈passport类接口的url.
     *
     * @param $key 配置文件中的键值
     *
     * @return 
     */
    public static function getPassportUrl($key)
    {
        $config = self::$config;
        //if (!isset($config['lifeq_passport'])) {
            ////config exception
        //}
        //if (!isset($config['lifeq_passport'][$key])) {
            ////config exception
        //}
        return $config['lifeq_passport'][$key];
    }

    /**
     * 读取数据导出路径.
     *
     * @param $key 配置文件中的键值
     */
    public static function getExportPath($key)
    {
        $config = self::$config;
        $exportPathArr = $config['export_path'];
        if (!\array_key_exists($key, $exportPathArr)) {
            return '';
        } else {
            $path = SITE_PATH.$exportPathArr[$key];
            if (!\file_exists($path) || !\is_dir($path)) {
                \mkdir($path, 0777, true);
            }

            return $path;
        }
    }

    /**
     * 读取数据导出的数据量.
     */
    public static function getExportDataNum()
    {
        $config = self::$config;

        return $config['export_data_num'];
    }
}
