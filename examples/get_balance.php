<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$privateKey = file_get_contents('moneygate.key');
$auth = new \sdk_moneygate\Auth($privateKey, $_ENV['Token']);
$balance = new \sdk_moneygate\Balance($auth, true);

var_dump($balance->getBalance());
