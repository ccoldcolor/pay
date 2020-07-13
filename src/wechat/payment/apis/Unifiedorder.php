<?php

namespace coldcolor\pay\wechat\payment\apis;

use coldcolor\pay\Utils;
use coldcolor\pay\wechat\Links;
use coldcolor\pay\wechat\payment\PaymentRequest;

/**
 * 微信统一下单
 */
class Unifiedorder extends PaymentRequest
{
    protected $url = Links::CREATE_ORDER;

    public $body;

    public $out_trade_no;

    public $total_fee;

    public $notify_url;

    public $trade_type;

    public $openid;

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

        if (!empty($this->notify_url))
            $this->data['notify_url'] = $this->notify_url;

        if (!empty($this->trade_type))
            $this->data['trade_type'] = $this->trade_type;

        if (!empty($this->openid))
            $this->data['openid'] = $this->openid;

        if (!empty($this->spbill_create_ip))
            $this->data['spbill_create_ip'] = $this->spbill_create_ip;
    }
}
