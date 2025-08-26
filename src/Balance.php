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
                'header' => "X-Auth-Token: " . $this->getAuth()->getXAuthToken() . "\r\n" .
                "X-Auth-Sign: " . $this->getAuth()->getXAuthSign($this->getId()) . "\r\n" .
                "X-Request-ID: " . $this->getId() . "\r\n" .
                "Accept: application/json\r\n",

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
        $result = @file_get_contents($this->getEnviroment() . 'balance', false, $context);

        if ($result === false) {
            return [
                'error' => 'auth error',
                'error_code' => 400,
            ];
        }
        return json_decode($result, true);
    }

}
