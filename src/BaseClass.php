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

    /**
     * __construct
     *
     * @param  mixed $auth
     * @param  mixed $isTest
     * @param  mixed $id
     * @return void
     */
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

    /**
     * getAuth
     *
     * @return Auth
     */
    function getAuth(): Auth
    {
        return $this->auth;
    }

    /**
     * setId
     *
     * @param  mixed $id
     * @return void
     */
    function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * getId
     *
     * @return string
     */
    function getId(): string
    {
        return $this->id;
    }

    /**
     * getData
     *
     * @return string
     */
    public function getData(): string | false
    {
        return json_encode($this->data);
    }

    /**
     * setData
     *
     * @param  mixed $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * getEnviroment
     *
     * @return string
     */
    public function getEnviroment(): string
    {
        return $this->enviroment;
    }

    /**
     * setCallbackUrl
     *
     * @param  mixed $callbackUrl
     * @return void
     */
    public function setCallbackUrl(string $callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
    }

    /**
     * getCallbackUrl
     *
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }

    /**
     * setAmount
     *
     * @param  mixed $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * getAmount
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
    /**
     * setCurrency
     *
     * @param  mixed $currency
     * @return void
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }
    /**
     * getCurrency
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * updateData
     *
     * @param  mixed $data
     * @return void
     */
    public function updateData(array $data = [])
    {
        $array = array_merge([
            "id" => $this->getId(),
            "service_id" => 6001,
        ], $data);
        $this->setData($array);
    }

    /**
     * getOptions
     *
     * @return array
     */
    public function getOptions(): array
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

    /**
     * setMethod
     *
     * @param  mixed $method
     * @return void
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * getMethod
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
