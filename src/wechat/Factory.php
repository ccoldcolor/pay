<?php

namespace coldcolor\pay\wechat;

use coldcolor\pay\exceptions\WechatException;

/**
 * Wechat app factory.
 *
 * @method static \coldcolor\pay\wechat\miniprogram\Application    miniprogram(array $config)
 * @method static \coldcolor\pay\wechat\accessToken\Application    accessToken(array $config)
 * @method static \coldcolor\pay\wechat\pcweb\Application          pcweb(array $config)
 * @method static \coldcolor\pay\wechat\mweb\Application           mweb(array $config)
 * @method static \coldcolor\pay\wechat\wxweb\Application          wxweb(array $config)
 * @method static \coldcolor\pay\wechat\company\Application        company(array $config)
 *
 */
class Factory
{
    private static $instances = [];

    private static $apps = [
        //小程序实例
        'miniprogram' => miniprogram\Application::class,
        //at 实例
        'accessToken' => accessToken\Application::class,
        //pc端web实例
        'pcweb' => pcweb\Application::class,
        //移动web实例
        'mweb' => mweb\Application::class,
        //微信内置网页实例
        'wxweb' => wxweb\Application::class,
        //企业付款实例
        'company' => company\Application::class,
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
    public static function __callStatic(string $name, array $arguments)
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