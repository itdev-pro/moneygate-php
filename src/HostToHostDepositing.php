<?php

/**
 * for depositing money using the host-to-host method
 */

namespace sdk_moneygate;

use sdk_moneygate\Auth;

class HostToHostDepositing
{
    const STABLE_TEST_ENV = "https://moneygate.master.blowfish.api4ftx.cloud/v1/host-to-host";
    const PRODUCT_ENV = "https://moneygate.blowfish.api4ftx.cloud/v1/host-to-host";

    public $auth;
    public $X_Auth_Token;

    function __construct(Auth $auth, string $X_Auth_Token)
    {
        $this->auth = $auth;
        $this->X_Auth_Token = $X_Auth_Token;
    }

    function get_options()
    {
        return [
            'http' => [
                'method' => 'POST',
                'content' => $this->auth->data,
                'header' => "X-Auth-Token: " . $this->X_Auth_Token . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign() . "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'",
            ],
        ];
    }
    function create(): array
    {
        $context = stream_context_create($this->get_options());
        $result = file_get_contents(self::STABLE_TEST_ENV . '/deposit-orders/new', false, $context);
        return json_decode($result, true);
    }

    function get_payment_instruments(): array
    {

        $context = stream_context_create($this->get_options());
        $result = file_get_contents(self::STABLE_TEST_ENV . "/deposit-orders/get-payment-instruments", false, $context);
        return json_decode($result, true);
    }

    function set_payment_instruments()
    {
        $context = stream_context_create($this->get_options());
        $result = file_get_contents(self::STABLE_TEST_ENV . "/deposit-orders/set-payment-instrument", false, $context);
        return $result;
    }

    function confirm()
    {
        $context = stream_context_create($this->get_options());
        $result = file_get_contents(self::STABLE_TEST_ENV . "/deposit-orders/confirm", false, $context);
        return $result;
    }

    function get_status()
    {
        $context = stream_context_create($this->get_options());
        $result = file_get_contents(self::STABLE_TEST_ENV . "/withdraw-orders/get-status", false, $context);
        return $result;
    }

}
