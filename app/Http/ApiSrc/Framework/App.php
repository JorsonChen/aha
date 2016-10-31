<?php
namespace ApiSrc\Framework;


/**
 * Class App.
 *
 */
class App 
{
    /**
     * 类的实例.
     */
    private static $controllers = [];

    /**
     * 映射关系.
     */
    private static $maps = [
        'UsersController' => 'App\Http\ApiControllers\V1\UsersController',
    ];

    /**
     * 获取类的实例.
     *
     * @param $name 映射关系中的名字
     *
     * @return 
     */
    public static function getController($name)
    {
        if (isset(self::$maps[$name])) {
            if (!isset(self::$controllers[$name])) {
                $controllerName = self::$maps[$name];
                $controller = new $controllerName();
                self::setController($name, $controller);
            }

            return self::$controllers[$name];
        } else {
            //trhow exception
        }
    }

    /**
     * 设置实例.
     *
     * @param $name 映射关系中的名字
     * @param $mod 实例
     *
     * @return 
     */
    protected static function setController($name, $controller)
    {
        self::$controllers[$name] = $controller;
    }

}
