<?php

namespace coldcolor\pay\alipay\payment\apis;

use coldcolor\pay\alipay\Links;
use coldcolor\pay\alipay\payment\PaymentRequest;
use coldcolor\pay\alipay\RequestMethod;

class TradeRefundQuery extends PaymentRequest
{
    protected $method = Links::TRADE_REFUND_QUERY;

    protected $request_type = RequestMethod::NORMAL_REQUEST;

    public $out_trade_no;

    public $trade_no;

    public $out_request_no;

    protected function setData()
    {
        if (!empty($this->out_trade_no))
            $this->biz_data['out_trade_no'] = $this->out_trade_no;

        else if (!empty($this->trade_no))
            $this->biz_data['trade_no'] = $this->trade_no;

        if (!empty($this->out_request_no))
            $this->biz_data['out_request_no'] = $this->out_request_no;
    }
}
