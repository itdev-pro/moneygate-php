<?php

namespace sdk_moneygate;

/**
 * Connection
 *
 * This class is designed to store data for a connection
 *
 * @author Хомичук Михаил
 * @version 1.0.0
 */
class Request
{
    const STABLE_TEST_ENV = "https://moneygate.master.blowfish.api4ftx.cloud/v1/";
    const PRODUCT_ENV = "https://moneygate.blowfish.api4ftx.cloud/v1/";

    private string $enviroment;
    private array $options;

    function __construct(bool $isTest = false)
    {
        $this->enviroment = self::PRODUCT_ENV;
        if ($isTest) {
            $this->enviroment = self::STABLE_TEST_ENV;
        }

    }

    public function getEnviroment()
    {
        return $this->enviroment;
    }

    public function setOptions()
    {

    }

    public function getOptions()
    {}

}
