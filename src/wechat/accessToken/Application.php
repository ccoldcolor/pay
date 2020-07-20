<?php

namespace coldcolor\pay\wechat\accessToken;

use coldcolor\pay\base\BaseApplication;
use coldcolor\pay\exceptions\WechatException;
use coldcolor\pay\Utils;
use coldcolor\pay\wechat\Config;
use coldcolor\pay\wechat\Links;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Application extends BaseApplication
{
    private $token_key = "wechat_access_token";

    private $cache;

    private $token_cache;

    protected function __construct(Config $config)
    {
        parent::__construct($config);

        $this->cache = new FilesystemAdapter();

        $key = md5($this->token_key . "_" . $this->config->app_id);
        $this->token_cache = $this->cache->getItem($key);
    }

    /**
     * 获取微信 token
     * @return mixed
     * @throws WechatException
     */
    public function getToken()
    {
        $token = $this->token_cache->get();
        if (!$token) {
            $tokenRes = $this->getTokenByWechat();
            $expireTime = $tokenRes['expires_in'];
            $token = $tokenRes['access_token'];

            $this->token_cache->set($token);
            $this->token_cache->expiresAfter($expireTime - 200);

            $this->cache->save($this->token_cache);
        }

        return $token;
    }

    private function getTokenByWechat()
    {
        $link = Links::GET_ACCESS_TOKEN;
        $link = str_replace('APPID', $this->config->app_id, $link);
        $link = str_replace('APPSECRET', $this->config->secret, $link);

        $res = Utils::getCurl($link);

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