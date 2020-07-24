<?php

namespace coldcolor\pay\wechat\payment;

use coldcolor\pay\exceptions\WechatException;
use coldcolor\pay\Utils;

class PaymentRequest
{
    protected $url;

    protected $data = [];

    protected $nonce_str;

    protected $sign;

    protected $sign_type = "MD5";

    private $response;

    public $app_id;

    public $mch_id;

    public $key;

    protected $use_cert = false;

    public $cert_path = "";

    public $key_path = "";

    /**
     * 获取参数签名
     *
     * @return string
     */
    protected function getSign() : string
    {
        $data = $this->data;
        if (isset($data['sign'])) unset($data['sign']);

        // 签名步骤一：按字典排序参数
        ksort($data);
        $string = Utils::toUrlParams($data);

        // 签名步骤二：在string后加入key
        $string = $string . '&key=' . $this->key;

        // 签名步骤三：加密
        if (strtolower($this->sign_type) === 'md5')
            $string = md5($string);
        else
            $string = hash_hmac("sha256", $string, $this->key, false);
        
        // 签名步骤四：所有字符转为大写
        $result = strtoupper($string);

        return $result;
    }

    /**
     * 设置请求参数，多态，由子类实现
     */
    protected function setData() {}

    /**
     * 微信接口发送请求
     *
     * @return array
     */
    public function request() : array
    {
        $this->nonce_str = Utils::getNonceStr();

        $this->data['appid'] = $this->app_id;
        $this->data['mch_id'] = $this->mch_id;
        $this->data['nonce_str'] = $this->nonce_str;
        $this->data['sign_type'] = $this->sign_type;
        
        $this->setData();

        $this->data['sign'] = $this->getSign();

        $params = Utils::arrayToXml($this->data);

        if (true === $this->use_cert)
            $responseXml = Utils::postCurl($params, $this->url, true, $this->cert_path, $this->key_path);
        else
            $responseXml = Utils::postCurl($params, $this->url);
       

        $this->response = Utils::xmlToArray($responseXml);

        $this->validateResponse();

        return $this->response;
    }

    /**
     * 验证返回值
     *
     * @return boolean
     */
    private function validateResponse() : bool
    {
        if ($this->response["return_code"] !== "SUCCESS") {
            throw new WechatException($this->response["return_msg"]);
        }

        return true;
    }
}