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

    /**
     * app 下单
     *
     * @param string $outTradeNo
     * @param float $totalFee
     * @param string $subject
     * @param string $notifyUrl
     * @return array
     */
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

    /**
     * 同意收单
     *
     * @param string $outTradeNo
     * @param float $totalFee
     * @param string $subject
     * @param string $notifyUrl
     * @return array
     */
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

        return $response;
    }

    /**
     * 手机网页下单
     *
     * @param string $outTradeNo
     * @param float $totalFee
     * @param string $subject
     * @param string $quitUrl
     * @param string $notifyUrl
     * @param string $returnUrl
     * @return array
     */
    public function tradeWapPay(
        string $outTradeNo,
        float $totalFee,
        string $subject,
        string $quitUrl,
        string $notifyUrl = "",
        string $returnUrl = ""
    ): array {
        //获取实例
        $tradeWapPay = PaymentFactory::tradeWapPay();

        //设置参数
        $tradeWapPay->subject = $subject;
        $tradeWapPay->quit_url = $quitUrl;
        $tradeWapPay->out_trade_no = $outTradeNo;
        $tradeWapPay->return_url = $returnUrl;
        $tradeWapPay->total_amount = round($totalFee, 2);
        $tradeWapPay->app_id = $this->config->app_id;
        $tradeWapPay->public_key_file = $this->config->public_key_file;
        $tradeWapPay->private_key_file = $this->config->private_key_file;
        $tradeWapPay->notify_url = $notifyUrl ?: $this->config->notify_url;

        $response = $tradeWapPay->request();

        return $response;
    }

    /**
     * PC 网页下单
     *
     * @param string $outTradeNo
     * @param float $totalFee
     * @param string $subject
     * @param string $quitUrl
     * @param string $notifyUrl
     * @param string $returnUrl
     * @return array
     */
    public function tradePagePay(
        string $outTradeNo,
        float $totalFee,
        string $subject,
        string $quitUrl,
        string $notifyUrl = "",
        string $returnUrl = ""
    ): array {
        //获取实例
        $tradePagePay = PaymentFactory::tradePagePay();

        //设置参数
        $tradePagePay->subject = $subject;
        $tradePagePay->quit_url = $quitUrl;
        $tradePagePay->out_trade_no = $outTradeNo;
        $tradePagePay->return_url = $returnUrl;
        $tradePagePay->total_amount = round($totalFee, 2);
        $tradePagePay->app_id = $this->config->app_id;
        $tradePagePay->public_key_file = $this->config->public_key_file;
        $tradePagePay->private_key_file = $this->config->private_key_file;
        $tradePagePay->notify_url = $notifyUrl ?: $this->config->notify_url;

        $response = $tradePagePay->request();

        return $response;
    }

    /**
     * 订单查询通过商户订单号
     *
     * @param string $outTradeNo
     * @return array
     */
    public function tradeOrderQueryByOutTradeNo(string $outTradeNo): array
    {
        //获取实例
        $tradeQuery = PaymentFactory::tradeQuery();

        //设置参数
        $tradeQuery->out_trade_no = $outTradeNo;
        $tradeQuery->app_id = $this->config->app_id;
        $tradeQuery->public_key_file = $this->config->public_key_file;
        $tradeQuery->private_key_file = $this->config->private_key_file;

        $response = $tradeQuery->request();

        return $response;
    }

    /**
     * 订单查询通过支付宝订单号
     *
     * @param string $tradeNo
     * @return array
     */
    public function tradeOrderQueryByTradeNo(string $tradeNo): array
    {
        //获取实例
        $tradeQuery = PaymentFactory::tradeQuery();

        //设置参数
        $tradeQuery->trade_no = $tradeNo;
        $tradeQuery->app_id = $this->config->app_id;
        $tradeQuery->public_key_file = $this->config->public_key_file;
        $tradeQuery->private_key_file = $this->config->private_key_file;

        $response = $tradeQuery->request();

        return $response;
    }

    /**
     * 订单取消通过商户订单号
     *
     * @param string $outTradeNo
     * @return array
     */
    public function tradeCancelByOutTradeNo(string $outTradeNo): array
    {
        //获取实例
        $tradeCancel = PaymentFactory::tradeCancel();

        //设置参数
        $tradeCancel->out_trade_no = $outTradeNo;
        $tradeCancel->app_id = $this->config->app_id;
        $tradeCancel->public_key_file = $this->config->public_key_file;
        $tradeCancel->private_key_file = $this->config->private_key_file;

        $response = $tradeCancel->request();

        return $response;
    }

    /**
     * 订单取消通过支付宝订单号
     *
     * @param string $tradeNo
     * @return array
     */
    public function tradeCancelByTradeNo(string $tradeNo): array
    {
        //获取实例
        $tradeCancel = PaymentFactory::tradeCancel();

        //设置参数
        $tradeCancel->trade_no = $tradeNo;
        $tradeCancel->app_id = $this->config->app_id;
        $tradeCancel->public_key_file = $this->config->public_key_file;
        $tradeCancel->private_key_file = $this->config->private_key_file;

        $response = $tradeCancel->request();

        return $response;
    }

    /**
     * 订单关闭通过商户订单号
     *
     * @param string $outTradeNo
     * @return array
     */
    public function tradeCloseByOutTradeNo(string $outTradeNo): array
    {
        //获取实例
        $tradeClose = PaymentFactory::tradeClose();

        //设置参数
        $tradeClose->out_trade_no = $outTradeNo;
        $tradeClose->app_id = $this->config->app_id;
        $tradeClose->public_key_file = $this->config->public_key_file;
        $tradeClose->private_key_file = $this->config->private_key_file;

        $response = $tradeClose->request();

        return $response;
    }

    /**
     * 订单关闭通过支付宝订单号
     *
     * @param string $tradeNo
     * @return array
     */
    public function tradeCloseByTradeNo(string $tradeNo): array
    {
        //获取实例
        $tradeClose = PaymentFactory::tradeClose();

        //设置参数
        $tradeClose->trade_no = $tradeNo;
        $tradeClose->app_id = $this->config->app_id;
        $tradeClose->public_key_file = $this->config->public_key_file;
        $tradeClose->private_key_file = $this->config->private_key_file;

        $response = $tradeClose->request();

        return $response;
    }

    /**
     * 申请退款通过商户订单号
     *
     * @param string $outTradeNo
     * @param float $refundAmount
     * @param string $outRequestNo
     * @return array
     */
    public function tradeRefundByOutTradeNo(string $outTradeNo, float $refundAmount, string $outRequestNo = ""): array
    {
        //获取实例
        $tradeRefund = PaymentFactory::tradeRefund();

        //设置参数
        $tradeRefund->out_trade_no = $outTradeNo;
        $tradeRefund->refund_amount = $refundAmount;
        $tradeRefund->out_request_no = $outRequestNo;
        $tradeRefund->app_id = $this->config->app_id;
        $tradeRefund->public_key_file = $this->config->public_key_file;
        $tradeRefund->private_key_file = $this->config->private_key_file;

        $response = $tradeRefund->request();

        return $response;
    }

    /**
     * 申请退款通过支付宝订单号
     *
     * @param string $tradeNo
     * @param float $refundAmount
     * @param string $outRequestNo
     * @return array
     */
    public function tradeRefundByTradeNo(string $tradeNo, float $refundAmount, string $outRequestNo = ""): array
    {
        //获取实例
        $tradeRefund = PaymentFactory::tradeRefund();

        //设置参数
        $tradeRefund->trade_no = $tradeNo;
        $tradeRefund->refund_amount = $refundAmount;
        $tradeRefund->out_request_no = $outRequestNo;
        $tradeRefund->app_id = $this->config->app_id;
        $tradeRefund->public_key_file = $this->config->public_key_file;
        $tradeRefund->private_key_file = $this->config->private_key_file;

        $response = $tradeRefund->request();

        return $response;
    }

    /**
     * 页面退款通过商户订单号
     *
     * @param string $outTradeNo
     * @param float $refundAmount
     * @param string $outRequestNo
     * @return array
     */
    public function tradePageRefundByOutTradeNo(string $outTradeNo, float $refundAmount, string $outRequestNo): array
    {
        //获取实例
        $tradePageRefund = PaymentFactory::tradePageRefund();

        //设置参数
        $tradePageRefund->out_trade_no = $outTradeNo;
        $tradePageRefund->refund_amount = $refundAmount;
        $tradePageRefund->out_request_no = $outRequestNo;
        $tradePageRefund->app_id = $this->config->app_id;
        $tradePageRefund->public_key_file = $this->config->public_key_file;
        $tradePageRefund->private_key_file = $this->config->private_key_file;

        $response = $tradePageRefund->request();

        return $response;
    }

    /**
     * 页面退款通过支付宝订单号
     *
     * @param string $tradeNo
     * @param float $refundAmount
     * @param string $outRequestNo
     * @return array
     */
    public function tradePageRefundByTradeNo(string $tradeNo, float $refundAmount, string $outRequestNo): array
    {
        //获取实例
        $tradePageRefund = PaymentFactory::tradePageRefund();

        //设置参数
        $tradePageRefund->trade_no = $tradeNo;
        $tradePageRefund->refund_amount = $refundAmount;
        $tradePageRefund->out_request_no = $outRequestNo;
        $tradePageRefund->app_id = $this->config->app_id;
        $tradePageRefund->public_key_file = $this->config->public_key_file;
        $tradePageRefund->private_key_file = $this->config->private_key_file;

        $response = $tradePageRefund->request();

        return $response;
    }

    /**
     * 查询退款通过商户订单号
     *
     * @param string $outTradeNo
     * @param string $outRequestNo
     * @return array
     */
    public function tradeRefundQueryByOutTradeNo(string $outTradeNo, string $outRequestNo): array
    {
        //获取实例
        $tradeRefundQuery = PaymentFactory::tradeRefundQuery();

        //设置参数
        $tradeRefundQuery->out_trade_no = $outTradeNo;
        $tradeRefundQuery->out_request_no = $outRequestNo;
        $tradeRefundQuery->app_id = $this->config->app_id;
        $tradeRefundQuery->public_key_file = $this->config->public_key_file;
        $tradeRefundQuery->private_key_file = $this->config->private_key_file;

        $response = $tradeRefundQuery->request();

        return $response;
    }

    /**
     * 查询退款通过支付宝订单号
     *
     * @param string $tradeNo
     * @param string $outRequestNo
     * @return array
     */
    public function tradeRefundQueryByTradeNo(string $tradeNo, string $outRequestNo): array
    {
        //获取实例
        $tradeRefundQuery = PaymentFactory::tradeRefundQuery();

        //设置参数
        $tradeRefundQuery->trade_no = $tradeNo;
        $tradeRefundQuery->out_request_no = $outRequestNo;
        $tradeRefundQuery->app_id = $this->config->app_id;
        $tradeRefundQuery->public_key_file = $this->config->public_key_file;
        $tradeRefundQuery->private_key_file = $this->config->private_key_file;

        $response = $tradeRefundQuery->request();

        return $response;
    }
}
