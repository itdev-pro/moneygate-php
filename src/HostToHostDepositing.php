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

    public function getOptions()
    {
        return [
            'http' => [
                'method' => 'POST',
                'content' => $this->getData(),
                'header' => "X-Auth-Token: " . $this->auth->getXAuthToken() . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign($this->getData()). "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'",
            ],
        ];
    }
    public function create(): array
    {

        $this->updateData();
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . 'host-to-host/deposit-orders/new', false, $context);
        return json_decode($result, true);
    }

    public function getPaymentInstruments(): array
    {
        // $this->updateData();
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/deposit-orders/get-payment-instruments", false, $context);
        return json_decode($result, true);
    }

    public function setPaymentInstruments()
    {
        $this->updateData();
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/deposit-orders/set-payment-instrument", false, $context);
        return $result;
    }

    public function confirm()
    {
        $this->updateData();
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/deposit-orders/confirm", false, $context);
        return $result;
    }

    public function getStatus()
    {
        $this->updateData();
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/withdraw-orders/get-status", false, $context);
        return $result;
    }

}
