<?php

/**
 * for withdrawing money using the host-to-host method
 * Вывод денежных средств по методу host-to-host
 */

namespace sdk_moneygate;

use sdk_moneygate\BaseClass;

class HostToHostWithdrawal extends BaseClass
{

    public function getOptions()
    {
        return [
            'http' => [
                'method' => 'POST',
                'content' => $this->getData(),
                'header' => "X-Auth-Token: " . $this->auth->getXAuthToken() . "\r\n" .
                "X-Auth-Sign: " . $this->auth->get_X_Auth_Sign($this->getData()) . "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'",
            ],
        ];
    }
    public function create(string $callbackUrl = "https://merchant-side.com/send-status-here", int $amount = 100, string $currency = "RUB"): array
    {
        $this->setCallbackUrl($callbackUrl);
        $this->setAmount($amount);
        $this->setCurrency($currency);
        $data = ["data" => [
            "callback_url" => $this->getCallbackUrl(),
            "amount" => $this->getAmount(),
            "currency" => $this->getCurrency(),
        ]];
        $this->updateData($data);
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . 'host-to-host/withdraw-orders/new', false, $context);
        return json_decode($result, true);
    }

    public function getPaymentInstruments(string $id = null): array
    {
        if ($id) {
            $this->setId($id);
        }
        $this->updateData([]);
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/withdraw-orders/get-payment-instruments", false, $context);
        return json_decode($result, true);
    }

    public function setPaymentInstruments(string $id = null, string $paymentType = "card2card", 
    string $bank = '', string $customer_id = '', string $card_no = '', string $card_holder_name = '', 
    string $phone=''): array
    {
        if ($id) {
            $this->setId($id);
        }

        $paymentInstrument = [
            "payment_type" => $paymentType,
        ];

        $customerData = [
            "customer_id" => $customer_id,
        ];

        if ($paymentType == "card2card") {
            $paymentInstrument["bank"] = $bank;
            $customerData["card_no"] = $card_no;
            $customerData["card_holder_name"] = $card_holder_name;
        } else if ($paymentType == "sbp") {
            $customerData["bank"] = $bank;
            $customerData["phone"] = $phone;
        }

        $this->updateData([
            "payment_instrument" => $paymentInstrument,
            "customer_data" => $customerData,
        ]);
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/withdraw-orders/set-payment-instrument", false, $context);
        return json_decode($result, true);
    }

    public function confirm(string $id = null)
    {
        if ($id) {
            $this->setId($id);
        }
        $this->updateData([]);
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/withdraw-orders/confirm", false, $context);
        return json_decode($result, true);
    }

    public function getStatus(string $id = null)
    {
        if ($id) {
            $this->setId($id);
        }
        $this->updateData([]);
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/withdraw-orders/get-status", false, $context);
        return json_decode($result, true);
    }


}
