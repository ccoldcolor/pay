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

    public $cert_path = "";

    public $key_path = "";

    private function __construct(array $config)
    {
        $this->app_id = $config['app_id'] ?? "";
        $this->secret = $config['secret'] ?? "";
        $this->mch_id = $config['mch_id'] ?? "";
        $this->key = $config['key'] ?? "";
        $this->notify_url = $config['notify_url'] ?? "";
        $this->cert_path = $config['cert_path'] ?? "";
        $this->key_path = $config['key_path'] ?? "";
    }

    public static function init(array $config = [])
    {
        return new self($config);
    }

}