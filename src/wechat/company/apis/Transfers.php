<?php

namespace coldcolor\pay\wechat\company\apis;

use coldcolor\pay\wechat\Links;
use coldcolor\pay\wechat\company\CompanyRequest;

class Transfers extends CompanyRequest
{
    protected $use_cert = true;

    protected $url = Links::TRANSFERS;

    public $mch_id;

    public $mch_appid;

    public $partner_trade_no;

    public $openid;

    public $check_name = "NO_CHECK";

    public $re_user_name;

    public $amount;

    public $desc;

    protected function setData()
    {
        if (!empty($this->mch_id))
            $this->data['mchid'] = $this->mch_id;

        if (!empty($this->mch_appid))
            $this->data['mch_appid'] = $this->mch_appid;

        if (!empty($this->partner_trade_no))
            $this->data['partner_trade_no'] = $this->partner_trade_no;

        if (!empty($this->openid))
            $this->data['openid'] = $this->openid;

        if (!empty($this->check_name))
            $this->data['check_name'] = $this->check_name;

        if (!empty($this->re_user_name))
            $this->data['re_user_name'] = $this->re_user_name;

        if (!empty($this->amount))
            $this->data['amount'] = $this->amount;

        if (!empty($this->desc))
            $this->data['desc'] = $this->desc;
    }
}