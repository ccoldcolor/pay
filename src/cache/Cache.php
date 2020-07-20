<?php

namespace coldcolor\pay\cache;

class Cache
{
    private static $suffix = "_cccache.temp";

    public static function get($key)
    {
        $dir = self::getCacheFileDir();
        $filename = $dir . $key . self::$suffix;

        if (!file_exists($filename)) return null;

        $inner = json_decode(file_get_contents($filename), true);

        if (!empty($inner['expire_time']) && $inner['expire_time'] > 0 && $inner['expire_time'] < time()) {
            return null;
        }

        return $inner['body'];
    }

    public static function set($key, $value, $expireTime = 0)
    {
        $dir = self::getCacheFileDir();
        $filename = $dir . $key . self::$suffix;

        $inner = [
            'body' => $value,
            'expire_time' => $expireTime === 0 ? 0 : $expireTime + time()
        ];

        $res = file_put_contents($filename, json_encode($inner));

        if (!$res) return false;
        return true;
    }

    public static function getCacheFileDir()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . "files" . DIRECTORY_SEPARATOR;
    }
}