<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$privateKey = file_get_contents('moneygate.key');
$X_Auth  = $_ENV['Token'];


$auth = new \sdk_moneygate\Auth($privateKey, $_ENV['Token']);

$HtHD = new \sdk_moneygate\HostToHostDepositing($auth, true);

print_r($HtHD->create());

print_r($HtHD->get_payment_instruments());
// echo gettype($HtHD->get_payment_instruments());


//  print_r($HtHD->set_payment_instruments());
//  print_r($HtHD->confirm());
//  print_r($HtHD->get_status());

//https://moneygate.master.blowfish.api4ftx.cloud/v1/deposit-orders/new
//https://moneygate.master.blowfish.api4ftx.cloud/v1/host-to-host/deposit-orders/new