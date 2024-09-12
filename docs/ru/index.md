# sdk_moneygate Docs RU
Пользовательская документация sdk_moneygate на русском

## Оглавление
- [sdk\_moneygate Docs RU](#sdk_moneygate-docs-ru)
  - [Оглавление](#оглавление)
  - [Авторизация](#авторизация)
  - [Получение баланса счетов](#получение-баланса-счетов)
  - [Внесение денежных средств по методу host-to-host](#внесение-денежных-средств-по-методу-host-to-host)
  - [Вывод денежных средств по методу host-to-host](#вывод-денежных-средств-по-методу-host-to-host)
  - [Внесение денежных средств по методу host-to-host в синхронном режиме](#внесение-денежных-средств-по-методу-host-to-host-в-синхронном-режиме)
  - [Внесение денежных средств по методу on-site-redirect](#внесение-денежных-средств-по-методу-on-site-redirect)


## Авторизация
Для подключения к платежному шлюзу необходимо произвести обмен параметрами авторизации.
1. Передать в MoneyGate публичный ключ RSA
2. Получить от MoneyGate токен авторизации и публичный ключ RSA платежного шлюз

```php
<?php 
use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['privateKey'], $_ENV['TOKEN']);
?>
```

## Получение баланса счетов
```php
<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['privateKey'], $_ENV['TOKEN']);

use sdk_moneygate\Balance; // импорт класса

$balance = new Balance($auth, true); // создание нового объекта класса Balance 
$result = $balance->getBalance(); // вызов функции getBalance для получения балансов счетов
var_dump($result);

```
## Внесение денежных средств по методу host-to-host
```php
<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации
use sdk_moneygate\HostToHostDepositing;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['privateKey'], $_ENV['TOKEN']);

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

```
## Вывод денежных средств по методу host-to-host
```php
<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации
use sdk_moneygate\HostToHostWithdrawal;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['privateKey'], $_ENV['TOKEN']);

$example = new HostToHostWithdrawal($auth, true); // создание экземпляра класса
$resultCreating = $example->create(); // Создание нового платежного ордера на вывод денежных средств
$id = $example->getId();
print_r('Результат запроса на создание платёжного ордера');
var_dump($resultCreating);
$resultPayment = $example->getPaymentInstruments(); // получения списка платежных инструментов для созданного платежного ордера
print_r('Результат запроса "получения списка платежных инструментов для созданного платежного ордера"');
var_dump($resultPayment);

// Получение инструмента
$sbp = [];
foreach ($resultPayment['data']['payment_instruments'] as $paymentInstrument) {
    if ($paymentInstrument['payment_type'] == "sbp") {
        $sbp = $paymentInstrument;
        break;
    }
}

// Выбор платежного инструмента для ранее созданного платежного ордера
$exampleSetPaymentInstruments = new HostToHostWithdrawal($auth, true);
$resultSetPaymentInstruments = $exampleSetPaymentInstruments->setPaymentInstruments($id, $sbp["payment_type"], $sbp["bank"], "2a1bc47b-38d2-4631-9f8c-0d497081f1ca", phone:"+79991112233");
print_r('Результат запроса "Выбор платежного инструмента для ранее созданного платежного ордера"');
var_dump($resultSetPaymentInstruments);

// Подтвердить перевод по платежному ордеру
$exampleConfirm = new HostToHostWithdrawal($auth, true);
$resultConfirm = $exampleConfirm->confirm($id);
print_r('Результат запроса "Подтвердить перевод по платежному ордеру"');
var_dump($resultConfirm);

// Получение статуса платежного ордера
$exampleGetStatus = new HostToHostWithdrawal($auth, true);
$resultGetStatus = $exampleGetStatus->getStatus($id);
print_r('Результат запроса "Получение статуса платежного ордера"');
var_dump($resultGetStatus);

```
## Внесение денежных средств по методу host-to-host в синхронном режиме
```php
<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации
use sdk_moneygate\SynchronousHostToHostDepositing;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['privateKey'], $_ENV['TOKEN']);

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

```
## Внесение денежных средств по методу on-site-redirect
```php
<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv; // пакет для работы с переменными окружения
use sdk_moneygate\Auth; // класс для подготовки данных авторизации
use sdk_moneygate\OnSiteRedirectDepositing;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$auth = new Auth($_ENV['privateKey'], $_ENV['TOKEN']);

$example = new OnSiteRedirectDepositing($auth, true); // создание экземпляра класса
$resultCreating = $example->create(customer_id: "2a1bc47b-38d2-4631-9f8c-0d497081f1ca"); // Создание нового платежного запроса
print_r('Результат запроса на создание платёжного ордера');
var_dump($resultCreating);

// Получение статуса
$exampleGetStatus = new OnSiteRedirectDepositing($auth, true);
$resultGetStatus = $exampleGetStatus->getStatus($id);
print_r('Результат запроса "Получение статуса платежного ордера"');
var_dump($resultGetStatus);

```

