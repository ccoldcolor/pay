<?php

namespace coldcolor\pay\wechat\company;

use coldcolor\pay\exceptions\WechatException;

/**
 * 企业付款工厂
 *
 * @method static \coldcolor\pay\wechat\company\apis\Transfers        transfers()
 *
 */
class CompanyFactory
{
    private static $apps = [
        "transfers" => apis\Transfers::class
    ];

    public static function __callStatic(string $name, array $arguments)
    {
        if (!isset(self::$apps[$name]))
            throw new WechatException("方法 {$name} 不存在！");

        return new self::$apps[$name];
    }
}
