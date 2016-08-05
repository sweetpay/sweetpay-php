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

go to to the sweetpay-php directory and run:

```bash
composer install
```
this will create a vendor directory inside the src directory.

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('pathto/vendor/autoload.php');
```
Also recommended it to use the spl autoloader.

```php
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
Set permission for src/logs directory as 777, using the terminal:
```bash
    sudo chmod 777 logs
```
in this file all the debug information will be added using monolog/monolog. 

## Set up conditions 
```php
    
    // The intital setup, some curl setup can be changed in this array
    $setup = array( "apiKey"            => (string) "NNq7Rcnb8y8jGTsU",
                    "stage"             => (boolean) true,
                    "DEFAULT_TIMEOUT"   => (int ) 30 );

	try {
	    // run the setup
		\Sweetpay\CheckoutCond::setCondition($setup);

	} catch (Exception $e) {
	    $input  = array('line'  => __LINE__,
                        'path'  => __FILE__,
                        'input' => $setup);
        \Sweetpay\Helper::errorMessage($e, $input);
        // if any error, check stdout for any error message and logs/*
        var_dump(\Sweetpay\CheckoutCond::getApiKey());

    } // end of try
    
```



## Run a transaction


```php
    $transactionData = array(
                'transactons' => array(
                    array('amount' => '100', 'currency' => 'SEK')  ,
                    array('amount' => '200', 'currency' => 'SEK')
                ),
                'country' => 'SE',
                'merchantId' => 'paylevo');
    
        try {
            $Check  = new \Sweetpay\CheckOut($transactionData);
            $vars   = $Check->getOutput()                ;
    
            // check the respons,
            var_dump($vars);
    
        } catch (Exception $e) {
            $input  = array('line'  => __LINE__,
                            'path'  => __FILE__,
                            'input' => $transactionData);
            \Sweetpay\Helper::errorMessage($e, $input);
    
        }

```
For a concreate and working exempel for both transactions and subscription 
see Test/* directory
