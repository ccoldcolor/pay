<?php

namespace coldcolor\pay\wechat\payment;

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
     * 统一下单
     *
     * @param string $outTradeNo 商户订单号
     * @param float $totalFee 订单金额，单位元
     * @param string $body 商品描述
     * @param string $notifyUrl 回调地址
     * @param string $openid 用户openid
     * @param string $productId 商品信息，pcweb必传
     * @return array
     */
    public function unifiedorder(
        string $outTradeNo,
        float $totalFee,
        string $body,
        string $notifyUrl = "",
        string $openid = "",
        string $productId = ""
    ): array {
        //获取实例
        $unifiedorder = PaymentFactory::unifiedorder();

        //设置参数
        $unifiedorder->body = $body;
        $unifiedorder->out_trade_no = $outTradeNo;
        $unifiedorder->total_fee = intval($totalFee * 100);
        $unifiedorder->app_id = $this->config->app_id;
        $unifiedorder->mch_id = $this->config->mch_id;
        $unifiedorder->key = $this->config->key;
        $unifiedorder->notify_url = $notifyUrl ?: $this->config->notify_url;
        $unifiedorder->trade_type = $this->getPayType();

        //判断支付方式
        if ($unifiedorder->trade_type === "JSAPI") {
            if (empty($openid)) {
                throw new WechatException("openid 不能为空");
            }
            $unifiedorder->openid = $openid;

        } else if ($unifiedorder->trade_type === "NATIVE") {
            if (empty($productId)) {
                throw new WechatException("productId 不能为空");
            }
            $unifiedorder->product_id = $productId;
        }

        $response = $unifiedorder->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 微信正扫
     *
     * @param string $outTradeNo 商户订单号
     * @param float $totalFee 订单金额
     * @param string $body 商品说明
     * @param string $authCode 用户条码
     * @return array
     * @throws WechatException
     */
    public function microPay(
        string $outTradeNo,
        float $totalFee,
        string $body,
        string $authCode
    ): array {
        //获取实例
        $microPay = PaymentFactory::microPay();

        //设置参数
        $microPay->body = $body;
        $microPay->out_trade_no = $outTradeNo;
        $microPay->total_fee = intval($totalFee * 100);
        $microPay->app_id = $this->config->app_id;
        $microPay->mch_id = $this->config->mch_id;
        $microPay->key = $this->config->key;
        $microPay->auth_code = $authCode;

        $response = $microPay->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 通过微信订单号查询订单
     *
     * @param string $transactionId 微信订单号
     * @return array
     */
    public function queryOrderByTransactionId(string $transactionId): array
    {
        //获取实例
        $orderQuery = PaymentFactory::orderQuery();

        //设置参数
        $orderQuery->app_id = $this->config->app_id;
        $orderQuery->mch_id = $this->config->mch_id;
        $orderQuery->key = $this->config->key;
        $orderQuery->transaction_id = $transactionId;

        $response = $orderQuery->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 通过商户订单号查询订单
     *
     * @param string $outTradeNo 商户订单号
     * @return array
     */
    public function queryOrderByOutTradeNo(string $outTradeNo): array
    {
        //获取实例
        $orderQuery = PaymentFactory::orderQuery();

        //设置参数
        $orderQuery->app_id = $this->config->app_id;
        $orderQuery->mch_id = $this->config->mch_id;
        $orderQuery->key = $this->config->key;
        $orderQuery->out_trade_no = $outTradeNo;

        $response = $orderQuery->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 订单关闭
     *
     * @param string $outTradeNo 商户订单号
     * @return array
     */
    public function closeOrder(string $outTradeNo): array
    {
        //获取实例
        $orderClose = PaymentFactory::orderClose();

        //设置参数
        $orderClose->app_id = $this->config->app_id;
        $orderClose->mch_id = $this->config->mch_id;
        $orderClose->key = $this->config->key;
        $orderClose->out_trade_no = $outTradeNo;

        $response = $orderClose->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 通过商户订单号退款
     *
     * @param string $outTradeNo 商户订单号
     * @param string $refundNo 商户退款单号
     * @param float $totalFee 订单总金额
     * @param float $refundFee 退款金额
     * @return array
     */
    public function refundByOutTradeNo(
        string $outTradeNo,
        string $refundNo,
        float $totalFee,
        float $refundFee
    ): array {
        //获取实例
        $refund = PaymentFactory::refund();

        //设置参数
        $refund->app_id = $this->config->app_id;
        $refund->mch_id = $this->config->mch_id;
        $refund->key = $this->config->key;
        $refund->out_trade_no = $outTradeNo;
        $refund->cert_path = $this->config->cert_path;
        $refund->key_path = $this->config->key_path;
        $refund->total_fee = intval($totalFee * 100);
        $refund->refund_fee = intval($refundFee * 100);
        $refund->out_refund_no = $refundNo;

        $response = $refund->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 通过微信订单号退款
     *
     * @param string $transactionId 微信订单号
     * @param string $refundNo 商户退款单号
     * @param float $totalFee 订单总金额
     * @param float $refundFee 退款金额
     * @return array
     */
    public function refundByTransactionId(
        string $transactionId,
        string $refundNo,
        float $totalFee,
        float $refundFee
    ): array {
        //获取实例
        $refund = PaymentFactory::refund();

        //设置参数
        $refund->app_id = $this->config->app_id;
        $refund->mch_id = $this->config->mch_id;
        $refund->key = $this->config->key;
        $refund->transaction_id = $transactionId;
        $refund->cert_path = $this->config->cert_path;
        $refund->key_path = $this->config->key_path;
        $refund->total_fee = intval($totalFee * 100);
        $refund->refund_fee = intval($refundFee * 100);
        $refund->out_refund_no = $refundNo;

        $response = $refund->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 通过微信订单号查询退款
     *
     * @param string $transactionId 微信订单号
     * @param integer $offset 偏移量
     * @return array
     */
    public function refundQueryByTransactionId(string $transactionId, int $offset = 0): array
    {
        //获取实例
        $refundQuery = PaymentFactory::refundQuery();

        //设置参数
        $refundQuery->app_id = $this->config->app_id;
        $refundQuery->mch_id = $this->config->mch_id;
        $refundQuery->key = $this->config->key;
        $refundQuery->transaction_id = $transactionId;

        if ($offset > 0)
            $refundQuery->offset = $offset;

        $response = $refundQuery->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 通过商户订单号查询退款
     *
     * @param string $outTradeNo 商户订单号
     * @param integer $offset 偏移量
     * @return array
     */
    public function refundQueryByOutTradeNo(string $outTradeNo, int $offset = 0): array
    {
        //获取实例
        $refundQuery = PaymentFactory::refundQuery();

        //设置参数
        $refundQuery->app_id = $this->config->app_id;
        $refundQuery->mch_id = $this->config->mch_id;
        $refundQuery->key = $this->config->key;
        $refundQuery->out_trade_no = $outTradeNo;

        if ($offset > 0)
            $refundQuery->offset = $offset;

        $response = $refundQuery->request();

        return $response;
    }

    /**
     * 通过商户退款单号查询退款
     *
     * @param string $outRefundNo 商户退款单号
     * @param integer $offset 偏移量
     * @return array
     */
    public function refundQueryByOutRefundNo(string $outRefundNo, int $offset = 0): array
    {
        //获取实例
        $refundQuery = PaymentFactory::refundQuery();

        //设置参数
        $refundQuery->app_id = $this->config->app_id;
        $refundQuery->mch_id = $this->config->mch_id;
        $refundQuery->key = $this->config->key;
        $refundQuery->out_refund_no = $outRefundNo;

        if ($offset > 0)
            $refundQuery->offset = $offset;

        $response = $refundQuery->request();

        if ($response["result_code"] !== "SUCCESS") {
            throw new WechatException($response["err_code_des"]);
        }

        return $response;
    }

    /**
     * 通过微信退款单号查询退款
     *
     * @param string $refundId 微信退款单号
     * @param integer $offset 偏移量
     * @return array
     */
    public function refundQueryByRefundId(string $refundId, int $offset = 0): array
    {
        //获取实例
        $refundQuery = PaymentFactory::refundQuery();

        //设置参数
        $refundQuery->app_id = $this->config->app_id;
        $refundQuery->mch_id = $this->config->mch_id;
        $refundQuery->key = $this->config->key;
        $refundQuery->refund_id = $refundId;

        if ($offset > 0)
            $refundQuery->offset = $offset;

        $response = $refundQuery->request();

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
    private function getPayType(): string
    {
        switch ($this->config->app_type) {
            case "miniprogram":
            case "wxweb":
                return "JSAPI";

            case "openPlatform":
                return "APP";

            case "pcweb":
                return "NATIVE";

            case "mweb":
                return "MWEB";

            default:
                throw new WechatException("错误的支付方式");
        }
    }
}
