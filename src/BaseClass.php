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

    private string $enviroment;
    private $data;
    public Auth $auth;

    public $id;

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
}
