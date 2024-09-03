# sdk_moneygate

PHP-SDK library for work with Moneygate API


## Developer Documentation ##

The [docs folder](docs/) provides detailed guides for using this library.

## Installation ##
This library can be found on [Packagist](https://packagist.org/packages/homi/sdk_moneygate).
The recommended way to install this is through [composer](http://getcomposer.org).
```bash
$composer require homi/sdk_moneygate
```
Examples
------
```bash
require __DIR__ . '/../vendor/autoload.php';
$privateKey = file_get_contents('moneygate.key');
$X_Auth  = '<your_X-Auth-Token>';

$t = new \sdk_moneygate\Auth($privateKey, '123') ;
```
Usage
------
For usage, please see the examples.

Tests
------
```bash
vendor/bin/phpunit
```

