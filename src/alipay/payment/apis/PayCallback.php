<?php

namespace coldcolor\pay\alipay\payment\apis;

use coldcolor\pay\alipay\payment\PaymentRequest;

/**
 * 支付宝支付回调
 */
class PayCallback extends PaymentRequest
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * 验证签名
     * @return bool
     */
    public function checkSign()
    {
        return true;
    }

    /**
     * 是否支付成功
     * @return bool
     */
    public function isSuccess(): bool
    {
        if (empty($this->data['trade_status']) || $this->data['trade_status'] !== 'TRADE_SUCCESS') {
            return false;
        }

        return true;
    }

    /**
     * 获取数据
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * 返回处理成功
     * @return string
     */
    public function returnSuccess(): string
    {
        return 'success';
    }

    /**
     * 返回处理失败
     * @param string $reason
     * @return string
     */
    public function returnFail($reason = '')
    {
        return $reason;
    }
}
