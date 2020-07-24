<?php

namespace coldcolor\pay\wechat\payment\apis;

use coldcolor\pay\exceptions\WechatException;
use coldcolor\pay\Utils;
use coldcolor\pay\wechat\payment\PaymentRequest;

/**
 * 微信支付回调
 * Class MicroPay
 * @package coldcolor\pay\wechat\payment\apis
 */
class PayCallback extends PaymentRequest
{
    private $return_data = [];

    public function __construct($data)
    {
        $this->data = $data;
        $this->sign_type = $data['sign_type'] ?? 'MD5';
    }

    public function checkSign()
    {
        if ($this->getSign() !== $this->data['sign']) {
            throw new WechatException('签名验证失败');
        }

        return true;
    }

    /**
     * 判断订单是否成功
     * @return bool
     */
    public function isSuccess(): bool
    {
        if (empty($this->data['result_code']) || $this->data['result_code'] !== 'SUCCESS') {
            return false;
        }

        return true;
    }

    /**
     * 获取数组数据
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * 给微信返回成功
     * @return string
     */
    public function returnSuccess(): string
    {
        $this->return_data['return_code'] = 'SUCCESS';
        $this->return_data['return_msg'] = 'OK';

        return Utils::arrayToXml($this->return_data);
    }

    /**
     * 给微信返回失败
     * @param string $reason
     * @return string
     */
    public function returnFail($reason = ''): string
    {
        $this->return_data['return_code'] = 'FAIL';
        $this->return_data['return_msg'] = $reason;

        return Utils::arrayToXml($this->return_data);
    }
}