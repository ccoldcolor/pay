<?php

namespace coldcolor\pay\alipay\payment;

use coldcolor\pay\exceptions\AlipayException;

/**
 * 微信支付工厂
 *
 * @method static \coldcolor\pay\alipay\payment\apis\TradeAppPay    tradeAppPay()
 * @method static \coldcolor\pay\alipay\payment\apis\TradeQuery     tradeQuery()
 * @method static \coldcolor\pay\alipay\payment\apis\tradeCreate    tradeCreate()
 * 
 */
class PaymentFactory
{
    private static $apps = [
        // 统一下单
        "tradeAppPay" => apis\TradeAppPay::class,
        "tradeQuery" => apis\TradeQuery::class,
        "tradeCreate" => apis\TradeCreate::class,
    ];

    public function __callStatic(string $name, array $arguments)
    {
        if (!isset(self::$apps[$name]))
            throw new AlipayException("方法 {$name} 不存在！");

        return new self::$apps[$name];
    }
}
