<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['RIGHT_PRIVATE_KEY'], $_ENV['TOKEN']);
