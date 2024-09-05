<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['privateKey'], $_ENV['Token']);

use sdk_moneygate\Balance; // импорт класса

$balance = new Balance($auth, true); // создание нового объекта класса Balance 
$result = $balance->getBalance(); // вызов функции getBalance для получения балансов счетов
var_dump($result);
