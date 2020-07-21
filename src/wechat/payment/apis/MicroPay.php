<?php

namespace coldcolor\pay\wechat\payment\apis;

use coldcolor\pay\Utils;
use coldcolor\pay\wechat\Links;
use coldcolor\pay\wechat\payment\CompanyRequest;

/**
 * 微信正扫支付
 * Class MicroPay
 * @package coldcolor\pay\wechat\payment\apis
 */
class MicroPay extends CompanyRequest
{
    protected $url = Links::MICRO_PAY;

    public $body;

    public $out_trade_no;

    public $total_fee;

    public $trade_type;

    public $auth_code;

    public $spbill_create_ip;

    protected function setData()
    {
        $this->spbill_create_ip = Utils::getClientIP();

        if (!empty($this->body))
            $this->data['body'] = $this->body;

        if (!empty($this->out_trade_no))
            $this->data['out_trade_no'] = $this->out_trade_no;

        if (!empty($this->total_fee))
            $this->data['total_fee'] = $this->total_fee;

        if (!empty($this->trade_type))
            $this->data['trade_type'] = $this->trade_type;

        if (!empty($this->auth_code))
            $this->data['auth_code'] = $this->auth_code;

        if (!empty($this->spbill_create_ip))
            $this->data['spbill_create_ip'] = $this->spbill_create_ip;
    }
}