<?php

namespace sdk_moneygate;

use sdk_moneygate\Auth;

/**
 * BaseClass
 */
class BaseClass
{
    const STABLE_TEST_ENV = "https://moneygate.master.blowfish.api4ftx.cloud/v1/";
    const PRODUCT_ENV = "https://moneygate.blowfish.api4ftx.cloud/v1/";

    private string $method;
    private string $enviroment;
    private $data;
    public Auth $auth;

    public $id;

    private $callbackUrl;

    private $amount;

    private $currency;

    public function __construct(Auth $auth, bool $isTest = false, string $id = null)
    {
        $this->auth = $auth;
        $this->enviroment = self::PRODUCT_ENV;
        if ($isTest) {
            $this->enviroment = self::STABLE_TEST_ENV;
        }
        if (!$id) {
            $this->id = uniqid();
        }
    }

    function getAuth()
    {
        return $this->auth;
    }

    function setId(string $id)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    public function getData()
    {
        return json_encode($this->data);
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getEnviroment()
    {
        return $this->enviroment;
    }

    public function setCallbackUrl(string $callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
    }

    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }
    public function getCurrency()
    {
        return $this->currency;
    }

    public function updateData(array $data = [])
    {
        $array = array_merge([
            "id" => $this->getId(),
            "service_id" => 6001,
        ], $data);
        $this->setData($array);
    }

    public function getOptions()
    {
        return [
            'http' => [
                'method' => $this->getMethod(),
                'content' => $this->getData(),
                'header' => "X-Auth-Token: " . $this->auth->getXAuthToken() . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign($this->getData()) . "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'",
            ],
        ];
    }

    public function setMethod(string $method){
        $this->method = $method;
    }

    public function getMethod(){
        return $this->method;
    }
}
