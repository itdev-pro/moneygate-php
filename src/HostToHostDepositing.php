<?php

/**
 * for depositing money using the host-to-host method
 */

namespace sdk_moneygate;

use sdk_moneygate\Auth;

class HostToHostDepositing
{
    const STABLE_TEST_ENV = "https://moneygate.master.blowfish.api4ftx.cloud/v1/host-to-host/deposit-orders/new";
    const PRODUCT_ENV = "https://moneygate.blowfish.api4ftx.cloud/v1/host-to-host/deposit-orders/new";

    public $auth;
    public $X_Auth_Token;

    function __construct(Auth $auth, string $X_Auth_Token)
    {
        $this->auth = $auth;
        $this->X_Auth_Token = $X_Auth_Token;
    }

    function create(): array
    {

        $url = self::STABLE_TEST_ENV;
        $options = [
            'http' => [
                'method' => 'POST',
                'content' => $this->auth->data,
                'header' => "X-Auth-Token: " . $this->X_Auth_Token . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign() . "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'",
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result, true);
    }

}
