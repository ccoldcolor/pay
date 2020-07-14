<?php

namespace coldcolor\pay\wechat;

use coldcolor\pay\exceptions\WechatException;

/**
 * Wechat app factory.
 *
 * @method static \coldcolor\pay\wechat\miniprogram\Application    miniprogram(array $config)
 * 
 */
class Factory
{
    private static $instances = [];

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
        if (!isset(self::$apps[$name]))
            throw new WechatException("方法 {$name} 不存在！");

        if (empty(self::$instances[$name])) {
            $configInstance = self::getConfig($arguments[0]);
            self::$instances[$name] = self::$apps[$name]::getInstance($configInstance);
        }

        return self::$instances[$name];
    }
}