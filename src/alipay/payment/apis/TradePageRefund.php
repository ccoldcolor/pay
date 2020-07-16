<?php

namespace coldcolor\pay\alipay\payment\apis;

use coldcolor\pay\alipay\Links;
use coldcolor\pay\alipay\payment\PaymentRequest;
use coldcolor\pay\alipay\RequestMethod;

class TradePageRefund extends PaymentRequest
{
    protected $method = Links::TRADE_PAGE_REFUND;

    protected $request_type = RequestMethod::PAGE_REQUEST;

    public $out_trade_no;

    public $trade_no;

    public $refund_amount;

    public $out_request_no;

    protected function setData()
    {
        if (!empty($this->out_trade_no))
            $this->biz_data['out_trade_no'] = $this->out_trade_no;

        else if (!empty($this->trade_no))
            $this->biz_data['trade_no'] = $this->trade_no;

        if (!empty($this->refund_amount))
            $this->biz_data['refund_amount'] = $this->refund_amount;

        if (!empty($this->out_request_no))
            $this->biz_data['out_request_no'] = $this->out_request_no;
    }
}
