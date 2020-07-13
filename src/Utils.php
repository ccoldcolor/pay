<?php

namespace coldcolor\pay;

use coldcolor\pay\exceptions\Exception;

/**
 * 工具类
 */
class Utils
{
    /**
     * 获取随机字符串
     *
     * @return void
     */
    public static function getNonceStr($length = 32) : string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $str   = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 格式化参数为URL参数
     *
     * @param array $data
     * @return string
     */
    public static function toUrlParams($data = []) : string
    {
        $buff = '';
        foreach ($data as $key => $val) {
            if ($key != 'sign' && $val != '' && !is_array($val)) {
                $buff .= $key . '=' . $val . '&';
            }
        }
        $buff = trim($buff, '&');
        return $buff;
    }
    
    /**
     * 获取客户端IP地址
     *
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    public static function getClientIP($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;

        static $ip = null;

        if (null !== $ip) {
            return $ip[$type];
        }

        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }
                $ip = trim(current($arr));
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];

        return $ip[$type];
    }

    /**
     * 数组转 XML 字符串
     *
     * @param array $data
     * @return string
     */
    public static function arrayToXml(array $data) : string
    {
        $xml = '<xml>';

        foreach ($data as $key => $val) {
            if (is_numeric($val)) {
                $xml .= '<' . $key . '>' . $val . '</' . $key . '>';
            } else {
                $xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
            }
        }

        $xml .= '</xml>';

        return $xml;
    }

    /**
     * XML 字符串转数组
     *
     * @param string $xml
     * @return array
     */
    public static function xmlToArray(string $xml) : array
    {
        // 将XML转为array
        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        $data = json_decode(
            json_encode(
                simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)
            ), true
        );

        return $data;
    }

    /**
     * post 请求
     *
     * @param string $data
     * @param string $url
     * @param boolean $useCert
     * @param integer $timeout
     * @return string
     */
    public static function postCurl(
        string $data,
        string $url,
        $useCert = false,
        $certFile = "",
        $keyFile = "",
        $timeout = 30
    )
    {
        $ch = curl_init();

        // 设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 严格校验
        // 设置header
        curl_setopt($ch, CURLOPT_HEADER, false);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($useCert == true) {
            // 设置证书
            // 使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
        }

        // post方式提交数据
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // 运行curl
        $result = curl_exec($ch);

        // 返回结果
        if ($result) {
            curl_close($ch);
            return $result;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new Exception('curl出错，错误码: ' . $error);
        }
    }

    /**
     * get 请求
     *
     * @param string $url
     * @param integer $timeout
     * @return void
     */
    public static function getCurl(string $url, $timeout = 5)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}