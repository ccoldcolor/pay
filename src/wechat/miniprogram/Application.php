<?php

namespace coldcolor\pay\wechat\miniprogram;

use coldcolor\pay\wechat\Config;

class Application
{

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->config->app_type = "miniprogram";
    }

    public function payment()
    {

    }

}