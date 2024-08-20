<?php

require __DIR__ . '/../vendor/autoload.php';
$privateKey = file_get_contents('moneygate.key');
$X_Auth  = '<your_X-Auth-Token>';
$data = json_encode(array(
    "id" => '66ba50cf5d0a3', //66ba50cf5d0f0
    "service_id" => 6001,
        "data" => array(
            "callback_url" => "https://merchant-side.com/send-status-here",
            "amount" => 100, // 100
            "currency" => "RUB", //"RUB"
        ),
    "payment_instrument" => array(
            "bank" => 'tinkoff',
            "payment_type" => 'sbp',
        ),
        "customer_data" => array(
            "customer_id"=> "2a1bc47b-38d2-4631-9f8c-0d497081f1ca",
            "card_no"=> "1111222233334444",
            "card_holder_name"=> "John Smith"
        ),
   
));
$auth = new \sdk_moneygate\Auth($privateKey, $data);
$balance = new \sdk_moneygate\Balance($auth, '7edbbe5b-1661-4959-b5c8-4dd083995935');
echo $balance->get_balance();

$HtHD = new \sdk_moneygate\HostToHostDepositing($auth, $X_Auth);
print_r($HtHD->create());
echo gettype($HtHD->create());
print_r($HtHD->get_payment_instruments());
echo gettype($HtHD->get_payment_instruments());


 print_r($HtHD->set_payment_instruments());
 print_r($HtHD->confirm());
 print_r($HtHD->get_status());