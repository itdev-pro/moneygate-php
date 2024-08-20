<?php

namespace sdk_moneygate;
/**
 * for auth
 */


class Auth {

    public $privateKey, $data;

    function __construct($privateKey, $data){
        $this->privateKey = $privateKey;
        $this->data = $data;
    }

    function get_X_Auth_Sign()
    {
        // Функция для получения X-Auth-Sign
        // Подписываем данные
        openssl_sign($this->data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
        // Преобразуем подпись в base64
        $base64Signature = base64_encode($signature);
        return $base64Signature;
    }
}
