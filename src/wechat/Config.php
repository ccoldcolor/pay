<?php

namespace coldcolor\pay\wechat;

class Config
{
    
    public $app_id = "";

    public $secret = "";

    public $mch_id = "";

    public $key = "";
    
    public $app_type = "";

    public $notify_url = "";

    private function __construct(array $config)
    {
        $this->app_id = $config['app_id'] ?? "";
        $this->secret = $config['secret'] ?? "";
        $this->mch_id = $config['mch_id'] ?? "";
        $this->key = $config['key'] ?? "";
        $this->notify_url = $config['notify_url'] ?? "";
    }

    public static function init(array $config = [])
    {
        return new self($config);
    }

}