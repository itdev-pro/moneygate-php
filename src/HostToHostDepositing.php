<?php

/**
 * for depositing money using the host-to-host method
 * Внесение денежных средств по методу host-to-host
 */

namespace sdk_moneygate;

use sdk_moneygate\BaseClass;

class HostToHostDepositing extends BaseClass
{
    public function create(string $callbackUrl = "https://merchant-side.com/send-status-here", int $amount = 100, string $currency = "RUB"): array
    {
        $this->setCallbackUrl($callbackUrl);
        $this->setAmount($amount);
        $this->setCurrency($currency);
        $this->setMethod("POST");
        $data = ["data" => [
            "callback_url" => $this->getCallbackUrl(),
            "amount" => $this->getAmount(),
            "currency" => $this->getCurrency(),
        ]];
        $this->updateData($data);
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . 'host-to-host/deposit-orders/new', false, $context);
        return json_decode($result, true);
    }

    public function getPaymentInstruments(string $id = null): array
    {
        if ($id) {
            $this->setId($id);
        }
        $this->setMethod("POST");
        $this->updateData([]);
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/deposit-orders/get-payment-instruments", false, $context);
        return json_decode($result, true);
    }

    public function setPaymentInstruments(string $id = null, string $paymentType = "card2card", string $bank = '', string $customer_id = '', string $last_card_digits = ''): array
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
            $customerData["last_card_digits"] = $last_card_digits;
        } else if ($paymentType == "sbp") {
            $customerData["bank"] = $bank;
        }

        $this->updateData([
            "payment_instrument" => $paymentInstrument,
            "customer_data" => $customerData,
        ]);
        $this->setMethod("POST");
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/deposit-orders/set-payment-instrument", false, $context);
        return json_decode($result, true);
    }

    public function confirm(string $id = null)
    {
        if ($id) {
            $this->setId($id);
        }
        $this->updateData([]);
        $this->setMethod("POST");
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/deposit-orders/confirm", false, $context);
        return json_decode($result, true);
    }

    public function getStatus(string $id = null)
    {
        if ($id) {
            $this->setId($id);
        }
        $this->updateData([]);
        $this->setMethod("POST");
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "host-to-host/withdraw-orders/get-status", false, $context);
        return json_decode($result, true);
    }

}
