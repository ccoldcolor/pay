<?php

namespace coldcolor\pay\wechat\company;

use coldcolor\pay\base\BaseApplication;
use coldcolor\pay\base\BaseConfig;
use coldcolor\pay\exceptions\WechatException;
use coldcolor\pay\wechat\Config;

class Application extends BaseApplication
{
    protected function __construct(Config $config)
    {
        parent::__construct($config);
    }

    /**
     * 重载父类方法
     * 获取微信商户实例
     *
     * @param Config $config
     * @return Application
     */
    public static function getInstance(BaseConfig $config): BaseApplication
    {
        // 检查配置参数
        if (empty($config->mch_id)) {
            throw new WechatException("商户 id 参数不能为空");
        } else if (empty($config->key)) {
            throw new WechatException("商户 key 参数不能为空");
        }

        return parent::getInstance($config);
    }

    /**
     * 企业付款到零钱
     *
     * @param string $partnerTradeNo
     * @param string $openid
     * @param float $amount
     * @param string $desc
     * @param array $params
     * @return array
     * @throws WechatException
     */
    public function transfers(
        string $partnerTradeNo,
        string $openid,
        float $amount,
        string $desc,
        array $params = []
    ): array
    {
        //获取实例
        $transfers = CompanyFactory::transfers();

        //设置参数
        $transfers->mch_appid = $this->config->app_id;
        $transfers->mch_id = $this->config->mch_id;
        $transfers->key = $this->config->key;
        $transfers->openid = $openid;
        $transfers->amount = intval($amount * 100);
        $transfers->partner_trade_no = $partnerTradeNo;
        $transfers->openid = $openid;
        $transfers->desc = $desc;
        $transfers->cert_path = $this->config->cert_path;
        $transfers->key_path = $this->config->key_path;

        foreach ($params as $k => $v) {
            if (isset($transfers->$k))
                $transfers->$k = $v;
        }

        $response = $transfers->request();

//        if ($response["result_code"] !== "SUCCESS") {
//            throw new WechatException($response["err_code_des"]);
//        }

        return $response;
    }

}
