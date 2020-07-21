<?php

namespace coldcolor\pay\wechat\payment\apis;

use coldcolor\pay\wechat\Links;
use coldcolor\pay\wechat\payment\CompanyRequest;

/**
 * 微信订单关闭
 */
class OrderClose extends CompanyRequest
{
    protected $url = Links::CLOSE_ORDER;

    public $out_trade_no;

    protected function setData()
    {
        if (!empty($this->out_trade_no))
            $this->data['out_trade_no'] = $this->out_trade_no;
    }
}