<?php

namespace coldcolor\pay\wechat\payment;

use coldcolor\pay\exceptions\WechatException;

/**
 * 微信支付工厂
 *
 * @method static \coldcolor\pay\wechat\payment\apis\Unifiedorder    unifiedorder()
 * @method static \coldcolor\pay\wechat\payment\apis\OrderQuery      orderQuery()
 * @method static \coldcolor\pay\wechat\payment\apis\OrderClose      orderClose()
 * @method static \coldcolor\pay\wechat\payment\apis\Refund          refund()
 * @method static \coldcolor\pay\wechat\payment\apis\RefundQuery     refundQuery()
 * 
 */
class PaymentFactory
{
    private static $apps = [
        // 统一下单
        "unifiedorder" => apis\Unifiedorder::class,
        // 订单查询
        "orderQuery" => apis\OrderQuery::class,
        // 订单关闭
        "orderClose" => apis\OrderClose::class,
        // 订单退款
        "refund" => apis\Refund::class,
        // 查询退款
        "refundQuery" => apis\RefundQuery::class,
    ];

    public function __callStatic(string $name, array $arguments)
    {
        if (!isset(self::$apps[$name]))
            throw new WechatException("方法 {$name} 不存在！");

        return new self::$apps[$name];
    }
}