<?php

namespace coldcolor\pay\alipay;

use coldcolor\pay\base\BaseConfig;

class Config extends BaseConfig
{
    public $app_id = "";

    public $public_key_file = "";

    public $private_key_file = "";

    public $notify_url = "";

    protected function __construct(array $config)
    {
        $this->app_id = $config['app_id'] ?? "";
        $this->public_key_file = $config['public_key_file'] ?? "";
        $this->private_key_file = $config['private_key_file'] ?? "";
        $this->notify_url = $config['notify_url'] ?? "";
    }
}