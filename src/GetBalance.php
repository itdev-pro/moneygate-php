<?
/**
 * for getting balance
 */
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
            "Accept: application/json'",

        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
        /* Handle error */
    }
    return $result;
}
