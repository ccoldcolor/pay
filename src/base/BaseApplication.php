<?php

namespace coldcolor\pay\base;

class BaseApplication
{
    /**
     * @var BaseConfig
     */
    protected $config;

    protected function __construct(BaseConfig $config)
    {
        $this->config = $config;
    }

    /**
     * 使用单例模式，单连接只实例化一次
     * static 指向最终子类 self 指向当前类
     *
     * @param BaseConfig $config
     * @return BaseApplication
     */
    public static function getInstance(BaseConfig $config): BaseApplication
    {
        return new static($config);
    }
}