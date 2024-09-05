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

    /**
     * __construct
     *
     * @param  mixed $privateKey
     * @param  mixed $xAuthToken
     * @return void
     */
    function __construct(string $privateKey, string $xAuthToken)
    {
        $this->privateKey = $privateKey;
        $this->xAuthToken = $xAuthToken;
    }

    /**
     * get_X_Auth_Sign
     *
     * @param  mixed $data
     * @return string
     */
    function get_X_Auth_Sign($data): string
    {
        // Функция для получения X-Auth-Sign
        // Подписываем данные
        openssl_sign($data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
        // Преобразуем подпись в base64
        $base64Signature = base64_encode($signature);
        return $base64Signature;
    }

    /**
     * getXAuthToken
     *
     * @return string
     */
    function getXAuthToken(): string
    {
        return $this->xAuthToken;
    }

}
