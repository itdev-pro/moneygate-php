<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации
use sdk_moneygate\HostToHostDepositing;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['RIGHT_PRIVATE_KEY'], $_ENV['TOKEN']);

$hostToHostDepositing = new HostToHostDepositing($auth, true); // создание экземпляра класса
$resultCreating = $hostToHostDepositing->create(); // создание платёжного ордера
$id = $hostToHostDepositing->getId();
print_r('Результат запроса на создание платёжного ордера');
var_dump($resultCreating);
$resultPayment = $hostToHostDepositing->getPaymentInstruments(); // получения списка платежных инструментов для созданного платежного ордера
print_r('Результат запроса "получения списка платежных инструментов для созданного платежного ордера"');
var_dump($resultPayment);

// Получение инструмента
$sbp = [];
$card2card = [];
foreach ($resultPayment['data']['payment_instruments'] as $paymentInstrument) {
    if ($paymentInstrument['payment_type'] == "sbp") {
        $sbp = $paymentInstrument;
        break;
    }
}

// Выбор платежного инструмента для ранее созданного платежного ордера
$exampleSetPaymentInstruments = new HostToHostDepositing($auth, true);
$resultSetPaymentInstruments = $exampleSetPaymentInstruments->setPaymentInstruments($id, $sbp["payment_type"], $sbp["bank"], "2a1bc47b-38d2-4631-9f8c-0d497081f1ca");
print_r('Результат запроса "Выбор платежного инструмента для ранее созданного платежного ордера"');
var_dump($resultSetPaymentInstruments);

// Подтвердить перевод по платежному ордеру
$exampleConfirm = new HostToHostDepositing($auth, true);
$resultConfirm = $exampleConfirm->confirm($id);
print_r('Результат запроса "Подтвердить перевод по платежному ордеру"');
var_dump($resultConfirm);

// Получение статуса платежного ордера
$exampleGetStatus = new HostToHostDepositing($auth, true);
$resultGetStatus = $exampleGetStatus->getStatus($id);
print_r('Результат запроса "Получение статуса платежного ордера"');
var_dump($resultGetStatus);
