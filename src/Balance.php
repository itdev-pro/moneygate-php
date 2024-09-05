<?php

namespace sdk_moneygate;

use sdk_moneygate\BaseClass;

/**
 * sdk_moneygate
 *
 * for getting balance
 *
 * @author Хомичук Михаил
 * @version 1.0.0
 */
class Balance extends BaseClass
{

    /**
     * getOptions
     *
     * redefined the function for getting parameters
     *
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'http' => [
                'method' => 'GET',
                'header' => "X-Auth-Token: " . $this->auth->getXAuthToken() . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign($this->getData()) . "\r\n" .
                "X-Request-ID: " . $this->getData() . "\r\n" .
                "Accept: application/json'",

            ],
        ];
    }
    /**
     * getBalance
     *
     * @return array
     */
    public function getBalance(): array
    {
        $this->updateData();
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . 'balance', false, $context);

        if ($result === false) {
            /* Handle error */
        }
        return json_decode($result, true);
    }

}
