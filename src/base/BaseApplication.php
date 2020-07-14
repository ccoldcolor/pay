<?php

namespace coldcolor\pay\base;

class BaseApplication
{
    /**
     * @var array
     */
    protected static $instances = [];

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
        if (empty(self::$instances[static::class])) {
            var_dump(self::$instances);
            self::$instances[static::class] = new static($config);
        }

        return self::$instances[static::class];
    }
}