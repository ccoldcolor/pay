<?php

namespace coldcolor\pay\wechat\accessToken;

use coldcolor\pay\base\BaseApplication;
use coldcolor\pay\cache\Cache;
use coldcolor\pay\wechat\Config;

class Application extends BaseApplication
{

    protected function __construct(Config $config)
    {
        parent::__construct($config);
    }

    public function getToken()
    {
        Cache::get("123");
    }

}