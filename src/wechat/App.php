<?php

namespace coldcolor\pay\wechat;

use Exception;

class App
{

    private static $apps = [

        //小程序实例
        'miniprogram' => miniprogram\Application::class,

    ];

    /**
     * 初始化并获取配置实例
     *
     * @param array $config
     * @return Config
     */
    private static function getConfig(array $config) : Config
    {
        return Config::init($config);
    }

    /**
     * __callStatic
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __callStatic(string $name, array $arguments)
    {
        if (isset(self::$apps[$name])) {

            $configInstance = self::getConfig($arguments[0]);

            return new self::$apps[$name]($configInstance);

        }

        throw new Exception("方法 {$name} 不存在！");
    }

}