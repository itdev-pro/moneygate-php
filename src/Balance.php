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

    public function updateData()
    {
        $this->setData(array(
            "id" => $this->getId(),
        ));
    }
    /**
     * get_balance
     *
     * @return array
     */
    public function get_balance()
    {
        $this->updateData();
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "X-Auth-Token: " . $this->auth->getXAuthToken() . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign($this->getData()) . "\r\n" .
                "X-Request-ID: " . $this->getData() . "\r\n" .
                "Accept: application/json'",

            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($this->getEnviroment() . 'balance', false, $context);

        if ($result === false) {
            /* Handle error */
        }
        return json_decode($result, true);
    }

}
