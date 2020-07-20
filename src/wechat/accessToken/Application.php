<?php

namespace coldcolor\pay\wechat\accessToken;

use coldcolor\pay\base\BaseApplication;
use coldcolor\pay\cache\Cache;
use coldcolor\pay\exceptions\WechatException;
use coldcolor\pay\Utils;
use coldcolor\pay\wechat\Config;
use coldcolor\pay\wechat\Links;

class Application extends BaseApplication
{
    private $token_key = "wechat_access_token";

    protected function __construct(Config $config)
    {
        parent::__construct($config);
    }

    /**
     * 获取微信 token
     * @return mixed
     * @throws WechatException
     */
    public function getToken()
    {
        $key = $this->getTokenKey();

        $token = Cache::get($key);
        if (!$token) {
            $tokenRes = $this->getTokenByWechat();
            $expireTime = $tokenRes['expires_in'];
            $token = $tokenRes['access_token'];

            Cache::set($key, $token, $expireTime);
        }

        return $token;
    }

    private function getTokenKey()
    {
        return $this->token_key . "_" . $this->config->app_id;
    }

    private function getTokenByWechat()
    {
        $link = Links::GET_ACCESS_TOKEN;
        $link = str_replace('APPID', $this->config->app_id, $link);
        $link = str_replace('APPSECRET', $this->config->secret, $link);

        $res =Utils::getCurl($link);

        if (!$res) {
            throw new WechatException("获取 token 失败");
        }

        $res = json_decode($res, true);
        if (!isset($res['access_token'])) {
            throw new WechatException($res['errmsg']);
        }

        return $res;
    }
}