<?php

namespace coldcolor\pay\wechat\miniprogram;

use coldcolor\pay\base\BaseApplication;
use coldcolor\pay\wechat\Config;
use coldcolor\pay\wechat\payment\Application as PaymentApplication;

class Application extends BaseApplication
{
    /**
     * @var PaymentApplication
     */
    private $payment;

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
        if (empty($this->payment)) {
            $this->payment = PaymentApplication::getInstance($this->config);
        }

        return $this->payment;
    }
}