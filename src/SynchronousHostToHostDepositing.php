<?php

/**
 * for depositing money using the host-to-host method in synchronous mode
 */

namespace sdk_moneygate;

use sdk_moneygate\BaseClass;

class SynchronousHostToHostDepositing extends BaseClass
{
    public function create(string $callbackUrl = "https://merchant-side.com/send-status-here", int $amount = 100,
        string $currency = "RUB", string $paymentType = "card2card", string $bank = '', string $customer_id = ''): array {
        $this->setCallbackUrl($callbackUrl);
        $this->setAmount($amount);
        $this->setCurrency($currency);
        $paymentInstrument = [
            "payment_type" => $paymentType,
            "bank" => $bank,
        ];

        $customerData = [
            "customer_id" => $customer_id,
        ];
        $data = ["data" => [
            "callback_url" => $this->getCallbackUrl(),
            "amount" => $this->getAmount(),
            "currency" => $this->getCurrency(),
            "payment_instrument" => $paymentInstrument,
            "customer_data" => $customerData,
        ]];
        $this->updateData($data);
        $this->setMethod("POST");
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . 'sync/deposit-orders/new', false, $context);
        return json_decode($result, true);
    }

    /**
     * getPaymentInstruments
     *
     * @return array
     */
    public function getPaymentInstruments(): array
    {
        $this->setMethod("POST");
        $data = ["filters" => [
            "currency" => "TRY",
        ]];
        $this->updateData($data);
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "sync/deposit-orders/get-payment-instruments", false, $context);
        return json_decode($result, true);
    }

    /**
     * getStatus
     *
     * @param  mixed $id
     * @return array
     */
    public function getStatus(string $id = null): array
    {
        if ($id) {
            $this->setId($id);
        }
        $this->updateData([]);
        $this->setMethod("POST");
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "sync/deposit-orders/get-status", false, $context);
        return json_decode($result, true);
    }

}
