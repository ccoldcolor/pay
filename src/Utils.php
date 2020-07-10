<?php

namespace coldcolor\pay;

class Utils {

    /**
     * 获取随机32位字符串
     *
     * @return void
     */
    public static function getRandStr()
    {
        return md5(uniqid(microtime(true),true));
    }

}