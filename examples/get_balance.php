<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$privateKey = file_get_contents('moneygate.key');
$X_Auth = $_ENV['Token'];

$t = new \sdk_moneygate\Auth($privateKey, '123');

$balance = new \sdk_moneygate\Balance($t, $X_Auth);

echo $balance->get_balance();