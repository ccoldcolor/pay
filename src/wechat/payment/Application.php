<?php

namespace coldcolor\pay\wechat\payment;

use coldcolor\pay\wechat\Config;

class Application {

    private $config;

    private function __construct(Config $config)
    {
         $this->config = $config;
    }

    /**
     * 获取微信商户实例
     *
     * @param Config $config
     * @return Application
     */
    public static function getPayment(Config $config) : Application
    {
        return new self($config);
    }

    public function unifiedorder()
    {
        $url = Links::CREATE_ORDER;
    }

}