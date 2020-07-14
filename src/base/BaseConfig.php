<?php

namespace coldcolor\pay\base;

class BaseConfig
{
    /**
     * 初始化配置
     *
     * @param array $config
     * @return BaseConfig
     */
    public static function init(array $config = []): BaseConfig
    {
        return new static($config);
    }
}