<?php

namespace coldcolor\pay\wechat\miniprogram;

use coldcolor\pay\wechat\Config;
use coldcolor\pay\wechat\payment\Application as PaymentApplication;

class Application
{

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->config->app_type = "miniprogram";
    }

    /**
     * 获取支付实例
     *
     * @return PaymentApplication
     */
    public function payment() : PaymentApplication
    {
        return PaymentApplication::getPayment($this->config);
    }

}