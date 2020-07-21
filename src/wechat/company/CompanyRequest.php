<?php

namespace coldcolor\pay\wechat\company;

use coldcolor\pay\exceptions\WechatException;
use coldcolor\pay\Utils;

class CompanyRequest
{
    protected $url;

    protected $data = [];

    protected $nonce_str;

    private $response;

    public $key;

    protected $use_cert = false;

    public $cert_path = "";

    public $key_path = "";

    /**
     * 获取参数签名
     *
     * @return string
     */
    private function getSign() : string
    {
        // 签名步骤一：按字典排序参数
        ksort($this->data);
        $string = Utils::toUrlParams($this->data);

        // 签名步骤二：在string后加入key
        $string = $string . '&key=' . $this->key;

        // 签名步骤三：MD5加密
        $string = md5($string);
        
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

        $this->data['nonce_str'] = $this->nonce_str;

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