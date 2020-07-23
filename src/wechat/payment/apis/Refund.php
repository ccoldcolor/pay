<?php

namespace coldcolor\pay\wechat\payment\apis;

use coldcolor\pay\wechat\Links;
use coldcolor\pay\wechat\payment\PaymentRequest;

/**
 * 微信订单退款
 */
class Refund extends PaymentRequest
{
    protected $url = Links::REFUND_ORDER;

    protected $use_cert = true;

    public $transaction_id;

    public $out_trade_no;

    public $out_refund_no;

    public $total_fee;

    public $refund_fee;

    public $notify_url;

    protected function setData()
    {
        if (!empty($this->transaction_id))
            $this->data['transaction_id'] = $this->transaction_id;

        else if (!empty($this->out_trade_no))
            $this->data['out_trade_no'] = $this->out_trade_no;

        if (!empty($this->out_refund_no))
            $this->data['out_refund_no'] = $this->out_refund_no;

        if (!empty($this->total_fee))
            $this->data['total_fee'] = $this->total_fee;

        if (!empty($this->refund_fee))
            $this->data['refund_fee'] = $this->refund_fee;

        if (!empty($this->notify_url))
            $this->data['notify_url'] = $this->notify_url;
    }
}