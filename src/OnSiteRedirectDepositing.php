<?php

/**
 * for depositing money using the on-site-redirect method
 * Внесение денежных средств по методу on-site-redirect
 */

namespace sdk_moneygate;

use sdk_moneygate\BaseClass;

/**
 * OnSiteRedirectDepositing
 */
class OnSiteRedirectDepositing extends BaseClass
{    
    /**
     * create
     *
     * @return void
     */
    public function create(
        string $callbackUrl = "https://merchant-side.com/send-status-here",
        string $success_url = "https://front-merchant-side.com/for-successfull-payment",
        string $fail_url = "https://front-merchant-side.com/for-failture-payment",
        int $amount = 100,
        string $currency = "RUB",
        string $paymentType = "card2card",
        string $bank = '',
        string $customer_id = '',
        $value = null,
    ): array {
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
        $data = [
            "value" => $value,
            "data" => [
            "callback_url" => $this->getCallbackUrl(),
            "success_url" => $success_url,
            "fail_url" => $fail_url,
            "amount" => $this->getAmount(),
            "currency" => $this->getCurrency(),
            "payment_instrument" => $paymentInstrument,
            "customer_data" => $customerData,
        ]];
        $this->updateData($data);
        $this->setMethod("POST");
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . 'on-site-redirect/send', false, $context);
        return json_decode($result, true);
    }
    
    /**
     * getStatus
     *
     * @param  mixed $id
     * @return void
     */
    public function getStatus(string $id = null)
    {
        if ($id) {
            $this->setId($id);
        }
        $this->updateData([]);
        $this->setMethod("POST");
        $context = stream_context_create($this->getOptions());
        $result = file_get_contents($this->getEnviroment() . "on-site-redirect/status", false, $context);
        return json_decode($result, true);

    }
    
}
