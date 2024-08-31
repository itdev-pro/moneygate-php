<?php

/**
 * sdk_moneygate
 * 
 * for getting balance
 * 
 * @author Хомичук Михаил
 * @version 1.0.0
 */

namespace sdk_moneygate;

use sdk_moneygate\Auth;

class Balance
{

    // TODO: Сделать переменную mode в конструкторе
    const STABLE_TEST_ENV = "https://moneygate.master.blowfish.api4ftx.cloud/v1/balance";
    const PRODUCT_ENV = "https://moneygate.blowfish.api4ftx.cloud/v1/balance";
    
    /**
     * auth
     *
     * @var mixed
     */
    public $auth;   

    /**
     * X_Auth_Token
     *
     * @var mixed
     */
    public $X_Auth_Token;

    /**
     * __construct
     *
     * @param  Auth $auth
     * @param  string $X_Auth_Token
     * @return void
     */
    function __construct(Auth $auth, string $X_Auth_Token)
    {
        $this->auth = $auth;
        $this->X_Auth_Token = $X_Auth_Token;
    }
    
    /**
     * get_balance
     *
     * @return array
     */
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
        return json_decode($result, true);
    }

}
