<?php

require __DIR__ . '/../vendor/autoload.php';
$privateKey = file_get_contents('moneygate.key');
$X_Auth  = $_ENV['X-Auth-Token'];

$t = new \sdk_moneygate\Auth($privateKey, '123') ;

$balance = new \sdk_moneygate\Balance($t, $X_Auth);

echo $balance->get_balance();