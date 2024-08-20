<?php

/**
 * for getting balance
 */

namespace sdk_moneygate;

use sdk_moneygate\Auth;

class Balance
{
    const STABLE_TEST_ENV = "https://moneygate.master.blowfish.api4ftx.cloud/v1/balance";
    const PRODUCT_ENV = "https://moneygate.blowfish.api4ftx.cloud/v1/balance";

    public $auth;
    public $X_Auth_Token;

    function __construct(Auth $auth, string $X_Auth_Token)
    {
        $this->auth = $auth;
        $this->X_Auth_Token = $X_Auth_Token;
    }
    function get_balance()
    {
        $url = self::STABLE_TEST_ENV;
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "X-Auth-Token: " . $this->X_Auth_Token . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign() . "\r\n" .
                "X-Request-ID: " . $this->auth->data . "\r\n" .
                "Accept: application/json'",

            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) {
            /* Handle error */
        }
        return $result;
    }

}
