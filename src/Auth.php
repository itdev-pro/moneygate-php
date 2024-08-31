<?php

namespace sdk_moneygate;

/**
 * sdk_moneygate
 *
 * for auth
 *
 * @author Хомичук Михаил
 * @version 1.0.0
 */

class Auth
{
    public string $xAuthToken;

    public $privateKey;

    public $data;

    /**
     * __construct
     *
     * @param  mixed $privateKey
     * @param  mixed $data
     * @return void
     */
    function __construct(string $privateKey, string $data, string $xAuthToken)
    {
        $this->privateKey = $privateKey;
        $this->data = $data;
        $this->xAuthToken = $xAuthToken;
    }

    /**
     * get_X_Auth_Sign
     *
     * @return string
     */
    function get_X_Auth_Sign(): string
    {
        // Функция для получения X-Auth-Sign
        // Подписываем данные
        openssl_sign($this->data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
        // Преобразуем подпись в base64
        $base64Signature = base64_encode($signature);
        return $base64Signature;
    }

    function getXAuthToken(): string
    {
        return $this->xAuthToken;
    }

    function getData(): string
    {
        return $this->data;
    }
}
