# SweetPay PHP bindings

[![Latest Stable Version](https://poser.pugx.org/sweetpay/sweetpay-php/v/stable)](https://packagist.org/packages/sweetpay/sweetpay-php)
[![Total Downloads](https://poser.pugx.org/sweetpay/sweetpay-php/downloads)](https://packagist.org/packages/sweetpay/sweetpay-php)
[![Latest Unstable Version](https://poser.pugx.org/sweetpay/sweetpay-php/v/unstable)](https://packagist.org/packages/sweetpay/sweetpay-php)
[![License](https://poser.pugx.org/sweetpay/sweetpay-php/license)](https://packagist.org/packages/sweetpay/sweetpay-php)
## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require sweetpay/sweetpay-php dev-master
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('pathto/vendor/autoload.php');
```


## Requirements

PHP 5.4 and later.

## Getting Started

Simple usage looks like:


```php
$setup = [  "apiKey" => (string) "NNq7Rcnb8y8jGTsU",
            "stage" => (boolean) true,
           "DEFAULT_TIMEOUT" => (int ) 30 ];
$transactionData = array(   'transactions' => array(
                                array('amount' => 100, 'currency' => 'SEK')
                    ),
                'country' => 'SE',
                'merchantId' => 'paylevo');

try {
        Sweetpay\CheckoutCond::setCondition($setup);
        ## Check that options are in
        var_dump(Sweetpay\CheckoutCond::getApiKey());

    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), PHP_EOL;
}

```

