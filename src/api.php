<?php


// Получение X-Auth-Sign
function get_X_Auth_Sign($data, $privateKey)
{
    // Функция для получения X-Auth-Sign
    // Подписываем данные
    openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
    // Преобразуем подпись в base64
    $base64Signature = base64_encode($signature);
    return $base64Signature;
}

// Получить баланс денежных средств на счетах пользователя
function get_balance($X_Auth_Token, $privateKey)
{
    $url = "https://moneygate.master.blowfish.api4ftx.cloud/v1/balance";
    $X_Request_ID = uniqid();

    $X_Auth_Sign = get_X_Auth_Sign($X_Request_ID, $privateKey);
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "X-Auth-Token: " . $X_Auth_Token . "\r\n" .
                "X-Auth-Sign: " . $X_Auth_Sign . "\r\n" .
                "X-Request-ID: " . $X_Request_ID . "\r\n" .
                "Accept: application/json'"


        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
        /* Handle error */
    }
    return $result;
}

/**
 * Шаг 1 – Создание платежного ордера
 *
 * @param str $X_Auth_Token
 * @param str $privateKey 
 * @param str $paymentOrderID
 * @param str $amount 
 * @param str $currency
 * @param str $callback_url 
 * //Пример использования
 * $privateKey = file_get_contents('moneygate.key');
 * $X_Auth_Token = "7edbbe5b-1661-4959-b5c8-4dd083995935";
 * $paymentOrderID = uniqid(); //с помощью него можно сгенерировать уникальные id;
 * create_paymentOrder($X_Auth_Token, $privateKey, $paymentOrderID, 100, "RUB", "https://merchant-side.com/send-status-here")
 * // Вывод:
 * {
 *   "data": {
 *       "blowfish_id": "21c79663-3efe-41bd-993f-5e2d3b631369"
 *   },
 *   "id": "66ba50cf5d0f0",
 *   "success": true
 *}
 */
function create_paymentOrder($X_Auth_Token, $privateKey, $paymentOrderID, $amount = 100, $currency = "RUB", $callback_url = "https://merchant-side.com/send-status-here")
{
    
    $url = "https://moneygate.master.blowfish.api4ftx.cloud/v1/host-to-host/deposit-orders/new";
    $data = array(
        "id" => $paymentOrderID,
        "service_id" => 6001,
        "data" => array(
            "callback_url" => $callback_url,
            "amount" => $amount,
            "currency" => $currency
        )
    );
    $X_Auth_Sign = get_X_Auth_Sign(json_encode($data), $privateKey);
    $options = [
        'http' => [
            'method' => 'POST',
            'content' => json_encode($data),
            'header' => "X-Auth-Token: " . $X_Auth_Token . "\r\n" .
                "X-Auth-Sign: " . $X_Auth_Sign . "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'"
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

/**
 * Шаг 2 – Получение списка платежных инструментов
 *
 * @param str $X_Auth_Token
 * @param str $privateKey 
 * @param str $paymentOrderID
 * //Пример использования
 * $privateKey = file_get_contents('moneygate.key');
 * $X_Auth_Token = "7edbbe5b-1661-4959-b5c8-4dd083995935";
 * $paymentOrderID = "66ba50cf5d0f0";
 * get_payment_instruments($X_Auth_Token, $privateKey, $paymentOrderID);
 * // Вывод:
 * {
    "success": true,
    "data": {
        "id": "66ba50cf5d0f0",
        "payment_instruments": [
            {
                "bank": "tinkoff",
                "bank_name": "Тинькофф",
                "payment_type": "card2card",
                "payment_type_name": "Card to Card"
            },
            {
                "bank": "tinkoff",
                "bank_name": "Тинькофф",
                "payment_type": "sbp",
                "payment_type_name": "СБП"
            },
            {
                "bank": "sberbank",
                "bank_name": "СберБанк",
                "payment_type": "sbp",
                "payment_type_name": "СБП"
            },
            {
                "bank": "sberbank",
                "bank_name": "СберБанк",
                "payment_type": "card2card",
                "payment_type_name": "Card to Card"
            },
            {
                "bank": "otherrfbank",
                "bank_name": "Другой РФ банк",
                "payment_type": "card2card",
                "payment_type_name": "Card to Card"
            },
            {
                "bank": "vtb",
                "bank_name": "ВТБ",
                "payment_type": "sbp",
                "payment_type_name": "СБП"
            },
            {
                "bank": "alfa",
                "bank_name": "Альфа Банк",
                "payment_type": "card2card",
                "payment_type_name": "Card to Card"
            },
            {
                "bank": "alfa",
                "bank_name": "Альфа Банк",
                "payment_type": "sbp",
                "payment_type_name": "СБП"
            },
            {
                "bank": "raifru",
                "bank_name": "Райффайзенбанк",
                "payment_type": "sbp",
                "payment_type_name": "СБП"
            },
            {
                "bank": "vtb",
                "bank_name": "ВТБ",
                "payment_type": "card2card",
                "payment_type_name": "Card to Card"
            },
            {
                "bank": "raifru",
                "bank_name": "Райффайзенбанк",
                "payment_type": "card2card",
                "payment_type_name": "Card to Card"
            },
            {
                "bank": "sberbank",
                "bank_name": "СберБанк",
                "payment_type": "sberpay",
                "payment_type_name": "SberPay"
            }
        ]
    }
}
 */
function get_payment_instruments($X_Auth_Token, $privateKey, $paymentOrderID)
{
    $url = "https://moneygate.master.blowfish.api4ftx.cloud/v1/host-to-host/deposit-orders/get-payment-instruments";
    $data = array(
        "id" => $paymentOrderID
    );
    $X_Auth_Sign = get_X_Auth_Sign(json_encode($data), $privateKey);
    $options = [
        'http' => [
            'method' => 'POST',
            'content' => json_encode($data),
            'header' => "X-Auth-Token: " . $X_Auth_Token . "\r\n" .
                "X-Auth-Sign: " . $X_Auth_Sign . "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'"
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}


/**
 * Шаг 3 – Выбор платежного инструмента
 *
 * @param str $X_Auth_Token
 * @param str $privateKey 
 * @param str $paymentOrderID
 * @param str $bank
 * @param str $payment_type
 * @param str $last_card_digits
 * //Пример использования
 * $privateKey = file_get_contents('moneygate.key');
 * $X_Auth_Token = "7edbbe5b-1661-4959-b5c8-4dd083995935";
 * $paymentOrderID = "66ba50cf5d0f0";
 * set_payment_instruments($X_Auth_Token, $privateKey, $paymentOrderID, "tinkoff", "sbp", "1234" );
 * // Вывод:
 * {
    "success": true,
}
 */
function set_payment_instruments($X_Auth_Token, $privateKey, $paymentOrderID, $bank, $payment_type, $last_card_digits)
{
    $url = "https://moneygate.master.blowfish.api4ftx.cloud/v1/host-to-host/deposit-orders/set-payment-instrument";
    $data = array(
        "id" => $paymentOrderID,
        "payment_instrument" => array(
            "bank" => $bank,
            "payment_type" => $payment_type
        ),
        "customer_data" => array(
            "last_card_digits" => $last_card_digits
        ),
    );
    $X_Auth_Sign = get_X_Auth_Sign(json_encode($data), $privateKey);
    $options = [
        'http' => [
            'method' => 'POST',
            'content' => json_encode($data),
            'header' => "X-Auth-Token: " . $X_Auth_Token . "\r\n" .
                "X-Auth-Sign: " . $X_Auth_Sign . "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'"
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}


/**
 * Шаг 4 – Подтверждение платежа
 *
 * @param str $X_Auth_Token
 * @param str $privateKey 
 * @param str $paymentOrderID
 * //Пример использования
 * $privateKey = file_get_contents('moneygate.key');
 * $X_Auth_Token = "7edbbe5b-1661-4959-b5c8-4dd083995935";
 * $paymentOrderID = "66ba50cf5d0f0";
 * confirm($X_Auth_Token, $privateKey, $paymentOrderID)
 * // Вывод:
 * {
    "success": true,
}
 */
function confirm($X_Auth_Token, $privateKey, $paymentOrderID)
{
    $url = "https://moneygate.master.blowfish.api4ftx.cloud/v1/host-to-host/deposit-orders/confirm";
    $data = array(
        "id" => $paymentOrderID
    );
    $X_Auth_Sign = get_X_Auth_Sign(json_encode($data), $privateKey);
    $options = [
        'http' => [
            'method' => 'POST',
            'content' => json_encode($data),
            'header' => "X-Auth-Token: " . $X_Auth_Token . "\r\n" .
                "X-Auth-Sign: " . $X_Auth_Sign . "\r\n" .
                "Content-Type: application/json\r\n" .
                "Accept: application/json'"
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}
