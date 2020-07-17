<?php

namespace coldcolor\pay\cache;

class Cache
{
    private static $suffix = "_cccache.temp";

    public static function get($key)
    {
        $dir = self::getCacheFileDir();
        $filename = $dir . $key . self::$suffix;

        if (!file_exists($filename)) return "";

        $inner = json_decode(file_get_contents($filename), true);

        if (!empty($inner['expire_time']) && $inner['expire_time'] < time()) {
            return "";
        }

        return $inner['body'];
    }

    public static function getCacheFileDir()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . "files" . DIRECTORY_SEPARATOR;
    }
}