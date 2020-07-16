<?php

namespace coldcolor\pay\alipay\payment;

use coldcolor\pay\alipay\RequestMethod;
use coldcolor\pay\exceptions\AlipayException;
use coldcolor\pay\Utils;

class PaymentRequest
{
    protected $gateway = "https://openapi.alipaydev.com/gateway.do";

    protected $data = [];

    protected $biz_data = [];

    protected $nonce_str;

    protected $sign;

    protected $sign_type = "RSA2";

    protected $charset = "UTF-8";

    protected $format = "json";

    protected $timestamp;

    protected $version = "1.0";

    private $response;

    protected $method;

    public $app_id;

    public $public_key_file;

    public $private_key_file;

    protected $sdk_version = "alipay-sdk-php-20161101";

    protected $request_type = RequestMethod::NORMAL_REQUEST;

    /**
     * 获取参数签名
     *
     * @return string
     */
    private function getSign(): string
    {
        return $this->sign($this->getSignContent($this->data), $this->sign_type);
    }

    /**
     * 设置请求参数，多态，由子类实现
     */
    protected function setData()
    {
    }

    /**
     * 支付宝接口发送请求
     *
     * @return array
     */
    public function request(): array
    {
        $this->data['app_id'] = $this->app_id;
        $this->data['method'] = $this->method;
        $this->data['format'] = $this->format;
        $this->data['charset'] = $this->charset;
        $this->data['sign_type'] = $this->sign_type;
        $this->data['timestamp'] = date("Y-m-d H:i:s", time() + 3600 * 8);
        $this->data['version'] = $this->version;

        if ($this->request_type !== RequestMethod::NORMAL_REQUEST) {
            $this->data['alipay_sdk'] = $this->sdk_version;
        }

        $this->setData();

        $this->data['biz_content'] = json_encode($this->biz_data);

        $this->data['sign'] = $this->getSign();

        switch ($this->request_type) {
            case RequestMethod::NORMAL_REQUEST:
                $res = $this->execute();
                break;

            case RequestMethod::SDK_REQUEST:
                $res = $this->sdkExecute();
                break;

            case RequestMethod::PAGE_REQUEST:
                $res = $this->pageExecute();
                break;

            default:
                $res = null;
        }

        if (!$res) {
            throw new AlipayException("请求失败");
        }

        return $res;
    }

    private function getRequestUrl()
    {
        //系统参数放入GET请求串
        $requestUrl = $this->gateway . "?";
        foreach ($this->data as $key => $value) {
            $requestUrl .= "$key=" . urlencode($value) . "&";
        }
        $requestUrl = substr($requestUrl, 0, -1);

        return $requestUrl;
    }

    /**
     * 获取签名
     *
     * @param [type] $data
     * @param [type] $signType
     * @return string
     */
    private function sign($data, $signType): string
    {
        $priKey = file_get_contents($this->private_key_file);

        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        if ("RSA2" == $signType)
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        else
            openssl_sign($data, $sign, $res);

        $sign = base64_encode($sign);

        return $sign;
    }

    /**
     * 获取要签名的数据
     *
     * @param [type] $params
     * @return void
     */
    private function getSignContent($params)
    {
        ksort($params);

        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === Utils::checkEmpty($v)) {
                if ($i == 0) {
                    $stringToBeSigned .= $k . "=" . $v;
                } else {
                    $stringToBeSigned .= "&" . $k . "=" . $v;
                }
                $i++;
            }
        }

        unset($k, $v);
        return $stringToBeSigned;
    }

    private function sdkExecute()
    {
        return ["buildstr" => http_build_query($this->data)];
    }

    private function pageExecute()
    {
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . $this->gateway . "?charset=" . trim($this->charset) . "' method='POST'>";

        foreach ($this->data as $key => $val) {
            if (false === Utils::checkEmpty($val)) {
                $val = str_replace("'", "&apos;", $val);
                $sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
            }
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml . "<input type='submit' value='ok' style='display:none;''></form>";
        $sHtml = $sHtml . "<script>document.forms['alipaysubmit'].submit();</script>";

        return ["buildstr" => $sHtml];
    }

    private function execute()
    {
        $url = $this->getRequestUrl();

        $res = Utils::getCurl($url);

        $res = json_decode($res, true);

        $responseKey = str_replace('.', '_', $this->method . "_response");
        if (!isset($res[$responseKey])) {
            throw new AlipayException("请求失败");
        }

        $data = $res[$responseKey];

        if ($data['code'] != '10000') {
            throw new AlipayException($data['sub_msg']);
        }

        return $data;
    }
}
