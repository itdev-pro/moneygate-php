# sdk_moneygate

PHP-SDK library for work with Moneygate API


## Developer Documentation ##

The [docs folder](docs/) provides detailed guides for using this library.

## Installation ##
```console
$composer require homi/sdk_moneygate
$composer install
```

In your php file

```
require __DIR__ . '/../vendor/autoload.php';
$privateKey = file_get_contents('moneygate.key');
$X_Auth  = '<your_X-Auth-Token>';

$t = new \sdk_moneygate\Auth($privateKey, '123') ;
```