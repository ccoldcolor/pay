<?php

namespace coldcolor\pay\wechat\payment;

use coldcolor\pay\exceptions\WechatException;
use coldcolor\pay\wechat\Config;
use coldcolor\pay\wechat\payment\apis\Unifiedorder;

class Application
{
    private $config;

    private function __construct(Config $config)
    {
         $this->config = $config;
    }

    /**
     * 获取微信商户实例
     *
     * @param Config $config
     * @return Application
     */
    public static function getPayment(Config $config) : Application
    {
        //检查配置参数
        if (empty($config->mch_id)) {
            throw new WechatException("商户 id 参数不能为空");
        } else if (empty($config->key)) {
            throw new WechatException("商户 key 参数不能为空");
        }

        return new self($config);
    }

    /**
     * 统一下单
     *
     * @param string $out_trade_no 商户订单号
     * @param float $total_fee 订单金额，单位元
     * @param string $body 商品描述
     * @param string $notify_url 回调地址
     * @param string $openid 用户openid
     * @return array
     */
    public function unifiedorder(
        string $out_trade_no,
        float $total_fee,
        string $body,
        string $notify_url = "",
        string $openid = ""
    ) : array
    {
        //获取实例
        $unifiedorder = new Unifiedorder;
        
        //设置参数
        $unifiedorder->body = $body;
        $unifiedorder->out_trade_no = $out_trade_no;
        $unifiedorder->total_fee = intval($total_fee * 100);
        $unifiedorder->app_id = $this->config->app_id;
        $unifiedorder->mch_id = $this->config->mch_id;
        $unifiedorder->key = $this->config->key;
        $unifiedorder->notify_url = $notify_url ?: $this->config->notify_url;
        $unifiedorder->trade_type = $this->getPayType();

        //判断支付方式
        if ($unifiedorder->trade_type === "JSAPI") {
            if (empty($openid)) {
                throw new WechatException("openid 不能为空");
            }

            $unifiedorder->openid = $openid;
        }

        $response = $unifiedorder->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }
        
        return $response;
    }
    
    /**
     * 获取支付方式
     *
     * @return string
     */
    private function getPayType() : string
    {
        switch ($this->config->app_type) {
            case "miniprogram":
            case "wxweb" :
                return "JSAPI";

            case "openPlatform":
                return "APP";

            default:
                throw new WechatException("错误的支付方式");
        }
    }
}