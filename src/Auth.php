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
    private string $xAuthToken;

    private string $privateKey;

    /**
     * __construct
     *
     * @param  mixed $privateKey
     * @param  mixed $xAuthToken
     * @return void
     */
    function __construct(string $privateKey, string $xAuthToken)
    {
        $this->setPrivateKey($privateKey);
        $this->setXAuthToken($xAuthToken);
    }

    /**
     * getXAuthSign
     *
     * @param  mixed $data
     * @return string
     */
    function getXAuthSign($data): string
    {
        // Функция для получения X-Auth-Sign
        // Подписываем данные
        openssl_sign($data, $signature, $this->getPrivateKey(), OPENSSL_ALGO_SHA256);
        // Преобразуем подпись в base64
        $base64Signature = base64_encode($signature);
        return $base64Signature;
    }
    
    /**
     * setPrivateKey
     *
     * @param  mixed $privateKey
     * @return void
     */
    function setPrivateKey(string $privateKey): void
    {
        $this->privateKey = $privateKey;
    }

    function setXAuthToken(string $XAuthToken): void
    {
        $this->xAuthToken = $XAuthToken; 
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
    
    /**
     * getPrivateKey
     *
     * @return string
     */
    function getPrivateKey(): string
    {
        return $this->privateKey;
    }

}
