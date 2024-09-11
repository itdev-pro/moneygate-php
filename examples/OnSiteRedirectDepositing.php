<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации
use sdk_moneygate\OnSiteRedirectDepositing;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['RIGHT_PRIVATE_KEY'], $_ENV['TOKEN']);

$example = new OnSiteRedirectDepositing($auth, true); // создание экземпляра класса
$resultCreating = $example->create(customer_id: "2a1bc47b-38d2-4631-9f8c-0d497081f1ca"); // Создание нового платежного запроса
print_r('Результат запроса на создание платёжного ордера');
var_dump($resultCreating);

// Получение статуса
$exampleGetStatus = new OnSiteRedirectDepositing($auth, true);
$resultGetStatus = $exampleGetStatus->getStatus($id);
print_r('Результат запроса "Получение статуса платежного ордера"');
var_dump($resultGetStatus);
