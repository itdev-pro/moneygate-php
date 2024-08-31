<?php

namespace sdk_moneygate;

/**
 * Connection
 *
 * This class is designed to store data for a connection
 */
class Connection
{
    const STABLE_TEST_ENV = "https://moneygate.master.blowfish.api4ftx.cloud/v1/balance";
    const PRODUCT_ENV = "https://moneygate.blowfish.api4ftx.cloud/v1/balance";

    private $enviroment;
    
    function __construct(bool $isTest = false)
    {
        $this->enviroment = self::PRODUCT_ENV;
        if ($isTest) {
            $this->enviroment = self::STABLE_TEST_ENV;
        }



    }
}
