<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации
use sdk_moneygate\SynchronousHostToHostDepositing;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['privateKey'], $_ENV['Token']);

$example = new SynchronousHostToHostDepositing($auth, true); // создание экземпляра класса
$resultCreating = $example->create(customer_id: "2a1bc47b-38d2-4631-9f8c-0d497081f1ca"); // Создание нового платежного ордера на вывод денежных средств
$id = $example->getId();
print_r('Результат запроса на создание платёжного ордера');
var_dump($resultCreating);
$resultPayment = $example->getPaymentInstruments(); // получения списка платежных инструментов для созданного платежного ордера
print_r('Результат запроса "получения списка платежных инструментов для созданного платежного ордера"');
var_dump($resultPayment);

// Получение статуса платежного ордера
$exampleGetStatus = new SynchronousHostToHostDepositing($auth, true);
$resultGetStatus = $exampleGetStatus->getStatus($id);
print_r('Результат запроса "Получение статуса платежного ордера"');
var_dump($resultGetStatus);
