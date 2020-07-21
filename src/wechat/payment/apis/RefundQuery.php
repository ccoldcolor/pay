<?php

namespace coldcolor\pay\wechat\payment\apis;

use coldcolor\pay\wechat\Links;
use coldcolor\pay\wechat\payment\CompanyRequest;

/**
 * 微信退款查询
 */
class RefundQuery extends CompanyRequest
{
    protected $url = Links::REFUND_QUERY;

    public $transaction_id;

    public $out_trade_no;

    public $out_refund_no;

    public $refund_id;

    public $offset;

    protected function setData()
    {
        if (!empty($this->transaction_id))
            $this->data['transaction_id'] = $this->transaction_id;

        else if (!empty($this->out_trade_no))
            $this->data['out_trade_no'] = $this->out_trade_no;

        else if (!empty($this->out_refund_no))
            $this->data['out_refund_no'] = $this->out_refund_no;

        else if (!empty($this->refund_id))
            $this->data['refund_id'] = $this->refund_id;

        if (!empty($this->offset))
            $this->data['offset'] = $this->offset;
    }
}