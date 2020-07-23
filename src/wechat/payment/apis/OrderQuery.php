<?php

namespace coldcolor\pay\wechat\payment\apis;

use coldcolor\pay\wechat\Links;
use coldcolor\pay\wechat\payment\PaymentRequest;

/**
 * 微信订单查询
 */
class OrderQuery extends PaymentRequest
{
    protected $url = Links::ORDER_QUERY;

    public $transaction_id;

    public $out_trade_no;

    protected function setData()
    {
        if (!empty($this->transaction_id))
            $this->data['transaction_id'] = $this->transaction_id;

        else if (!empty($this->out_trade_no))
            $this->data['out_trade_no'] = $this->out_trade_no;
    }
}