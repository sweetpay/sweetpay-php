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
Also recommended it to use the spl autoloader.

```
   /*Needed for loading the classes inside src*/
	function autoload($className)
	{
		$className = ltrim($className, '\\');
		$fileName  = '';
		$namespace = '';
		if ($lastNsPos = strrpos($className, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

		require $fileName;
	}
	spl_autoload_register('autoload');

```
## Requirements

PHP 5.4 and later.

## Getting started
Set permission for src/logs directory as 777 or
```bash
    sudo chmod 777 logs
```

## Set up conditions 
```php
    $setup = [  "apiKey"            => (string) "NNq7Rcnb8y8jGTsU",
                "stage"             => (boolean) true,
                "DEFAULT_TIMEOUT"   => (int ) 30 ];

	try {
		\Sweetpay\CheckoutCond::setCondition($setup);

	} catch (Exception $e) {
	    $input  = array('line'  => __LINE__,
                        'path'  => __FILE__,
                        'input' => $setup);
        \Sweetpay\Helper::errorMessage($e, $input);
        var_dump(\Sweetpay\CheckoutCond::getApiKey());

    }
```




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

