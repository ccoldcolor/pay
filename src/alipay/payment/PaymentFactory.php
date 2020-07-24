<?php

namespace coldcolor\pay\alipay\payment;

use coldcolor\pay\exceptions\AlipayException;

/**
 * 阿里支付工厂
 *
 * @method static \coldcolor\pay\alipay\payment\apis\TradeAppPay         tradeAppPay()
 * @method static \coldcolor\pay\alipay\payment\apis\TradeQuery          tradeQuery()
 * @method static \coldcolor\pay\alipay\payment\apis\TradeCreate         tradeCreate()
 * @method static \coldcolor\pay\alipay\payment\apis\TradeWapPay         tradeWapPay()
 * @method static \coldcolor\pay\alipay\payment\apis\TradePagePay        tradePagePay()
 * @method static \coldcolor\pay\alipay\payment\apis\TradeCancel         tradeCancel()
 * @method static \coldcolor\pay\alipay\payment\apis\TradeClose          tradeClose()
 * @method static \coldcolor\pay\alipay\payment\apis\TradeRefund         tradeRefund()
 * @method static \coldcolor\pay\alipay\payment\apis\TradePageRefund     tradePageRefund()
 * @method static \coldcolor\pay\alipay\payment\apis\TradeRefundQuery    tradeRefundQuery()
 * @method static \coldcolor\pay\alipay\payment\apis\payCallback         PayCallback(array $data)
 *
 */
class PaymentFactory
{
    private static $apps = [
        "tradeAppPay" => apis\TradeAppPay::class,
        "tradeQuery" => apis\TradeQuery::class,
        "tradeCreate" => apis\TradeCreate::class,
        "tradeWapPay" => apis\TradeWapPay::class,
        "tradePagePay" => apis\TradePagePay::class,
        "tradeCancel" => apis\TradeCancel::class,
        "tradeClose" => apis\TradeClose::class,
        "tradeRefund" => apis\TradeRefund::class,
        "tradePageRefund" => apis\TradePageRefund::class,
        "tradeRefundQuery" => apis\TradeRefundQuery::class,
        "payCallback" => apis\PayCallback::class,
    ];

    public static function __callStatic(string $name, array $arguments)
    {
        if (!isset(self::$apps[$name]))
            throw new AlipayException("方法 {$name} 不存在！");

        return new self::$apps[$name](...$arguments);
    }
}
