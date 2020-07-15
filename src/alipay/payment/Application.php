<?php

namespace coldcolor\pay\alipay\payment;

use coldcolor\pay\base\BaseApplication;
use coldcolor\pay\base\BaseConfig;
use coldcolor\pay\alipay\Config;
use coldcolor\pay\exceptions\AlipayException;

class Application extends BaseApplication
{
    protected function __construct(Config $config)
    {
        parent::__construct($config);

        $this->config = $config;
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
        if (empty($config->app_id)) {
            throw new AlipayException("商户 id 参数不能为空");
        }

        return parent::getInstance($config);
    }

    public function tradeAppPay(
        string $outTradeNo,
        float $totalFee,
        string $subject,
        string $notifyUrl = ""
    ): array {
        //获取实例
        $tradeAppPay = PaymentFactory::tradeAppPay();

        //设置参数
        $tradeAppPay->subject = $subject;
        $tradeAppPay->out_trade_no = $outTradeNo;
        $tradeAppPay->total_amount = round($totalFee, 2);
        $tradeAppPay->app_id = $this->config->app_id;
        $tradeAppPay->public_key_file = $this->config->public_key_file;
        $tradeAppPay->private_key_file = $this->config->private_key_file;
        $tradeAppPay->notify_url = $notifyUrl ?: $this->config->notify_url;

        $response = $tradeAppPay->request();

        return $response;
    }

    public function tradeCreate(
        string $outTradeNo,
        float $totalFee,
        string $subject,
        string $notifyUrl = ""
    ): array {
        //获取实例
        $tradeCreate = PaymentFactory::tradeCreate();

        //设置参数
        $tradeCreate->subject = $subject;
        $tradeCreate->out_trade_no = $outTradeNo;
        $tradeCreate->total_amount = round($totalFee, 2);
        $tradeCreate->app_id = $this->config->app_id;
        $tradeCreate->public_key_file = $this->config->public_key_file;
        $tradeCreate->private_key_file = $this->config->private_key_file;
        $tradeCreate->notify_url = $notifyUrl ?: $this->config->notify_url;

        $response = $tradeCreate->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new AlipayException($response["err_code_des"]);
        }

        return $response;
    }

    public function tradeOrderQuery(string $outTradeNo): array {
        //获取实例
        $tradeQuery = PaymentFactory::tradeQuery();

        //设置参数
        $tradeQuery->out_trade_no = $outTradeNo;
        $tradeQuery->app_id = $this->config->app_id;
        $tradeQuery->public_key_file = $this->config->public_key_file;
        $tradeQuery->private_key_file = $this->config->private_key_file;

        $response = $tradeQuery->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new AlipayException($response["err_code_des"]);
        }

        return $response;
    }
}
