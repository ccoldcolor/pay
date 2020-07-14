<?php

namespace coldcolor\pay\wechat\miniprogram;

use coldcolor\pay\base\BaseApplication;
use coldcolor\pay\wechat\Config;
use coldcolor\pay\wechat\payment\Application as PaymentApplication;

class Application extends BaseApplication
{
    protected function __construct(Config $config)
    {
        parent::__construct($config);

        $this->config->app_type = "miniprogram";
    }

    /**
     * 获取支付实例
     *
     * @return PaymentApplication
     */
    public function payment() : PaymentApplication
    {
        return PaymentApplication::getInstance($this->config);
    }
}