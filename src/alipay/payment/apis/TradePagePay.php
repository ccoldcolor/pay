<?php

namespace coldcolor\pay\alipay\payment\apis;

use coldcolor\pay\alipay\Links;
use coldcolor\pay\alipay\payment\PaymentRequest;
use coldcolor\pay\alipay\RequestMethod;

class TradePagePay extends PaymentRequest
{
    protected $method = Links::TRADE_PAGE_PAY;

    protected $request_type = RequestMethod::PAGE_REQUEST;

    public $out_trade_no;

    public $total_amount;

    public $notify_url;

    public $return_url;

    public $quit_url;

    public $subject;

    protected function setData()
    {
        if (!empty($this->subject))
            $this->biz_data['subject'] = $this->subject;

        if (!empty($this->out_trade_no))
            $this->biz_data['out_trade_no'] = $this->out_trade_no;

        if (!empty($this->total_amount))
            $this->biz_data['total_amount'] = $this->total_amount;

        if (!empty($this->quit_url))
            $this->biz_data['quit_url'] = $this->quit_url;

        if (!empty($this->notify_url))
            $this->data['notify_url'] = $this->notify_url;

        if (!empty($this->return_url))
            $this->data['return_url'] = $this->return_url;
    }
}
