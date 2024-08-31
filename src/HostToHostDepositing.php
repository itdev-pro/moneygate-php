<?php

/**
 * for depositing money using the host-to-host method
 */

namespace sdk_moneygate;

use sdk_moneygate\BaseClass;

class HostToHostDepositing extends BaseClass
{
    public function updateData()
    {

        $this->setData(array(
            "id" => $this->getId(),
            "service_id" => 6001,
            "data" => array(
                "callback_url" => "https://merchant-side.com/send-status-here",
                "amount" => 100, // 100
                "currency" => "RUB", //"RUB"
            ),
            "payment_instrument" => array(
                "bank" => 'tinkoff',
                "payment_type" => 'sbp',
            ),
            "customer_data" => array(
                "customer_id" => "2a1bc47b-38d2-4631-9f8c-0d497081f1ca",
                "card_no" => "1111222233334444",
                "card_holder_name" => "John Smith",
            ),

        ));
    }

    public function get_options()
    {
        return [
            'http' => [
                'method' => 'POST',
                'content' => $this->auth->data,
                'header' => "X-Auth-Token: " . $this->auth->getXAuthToken() . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign($this->getData()). "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'",
            ],
        ];
    }
    public function create()
    {
        $context = stream_context_create($this->get_options());
        $result = file_get_contents($this->getEnviroment() . '/deposit-orders/new', false, $context);
        return $result;//json_decode($result, true);
    }

    public function get_payment_instruments(): array
    {

        $context = stream_context_create($this->get_options());
        $result = file_get_contents($this->getEnviroment() . "/deposit-orders/get-payment-instruments", false, $context);
        return json_decode($result, true);
    }

    public function set_payment_instruments()
    {
        $context = stream_context_create($this->get_options());
        $result = file_get_contents($this->getEnviroment() . "/deposit-orders/set-payment-instrument", false, $context);
        return $result;
    }

    public function confirm()
    {
        $context = stream_context_create($this->get_options());
        $result = file_get_contents($this->getEnviroment() . "/deposit-orders/confirm", false, $context);
        return $result;
    }

    public function get_status()
    {
        $context = stream_context_create($this->get_options());
        $result = file_get_contents($this->getEnviroment() . "/withdraw-orders/get-status", false, $context);
        return $result;
    }

}
