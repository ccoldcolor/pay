<?php

namespace coldcolor\pay\alipay\payment\apis;

use coldcolor\pay\Utils;
use coldcolor\pay\alipay\Links;
use coldcolor\pay\alipay\payment\PaymentRequest;
use coldcolor\pay\alipay\RequestMethod;

/**
 * 微信统一下单
 */
class TradeCreate extends PaymentRequest
{
    protected $method = Links::TRADE_CREATE;

    protected $request_type = RequestMethod::NORMAL_REQUEST;

    public $out_trade_no;

    public $total_amount;

    public $notify_url;

    public $subject;

    protected function setData()
    {
        if (!empty($this->subject))
            $this->biz_data['subject'] = $this->subject;

        if (!empty($this->out_trade_no))
            $this->biz_data['out_trade_no'] = $this->out_trade_no;

        if (!empty($this->total_amount))
            $this->biz_data['total_amount'] = $this->total_amount;

        if (!empty($this->notify_url))
            $this->data['notify_url'] = $this->notify_url;
    }
}
