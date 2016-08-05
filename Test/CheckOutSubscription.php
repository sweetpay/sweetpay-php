<?php



	date_default_timezone_set('Europe/Stockholm');
    set_error_handler( function($nNumber, $strMessage, $strFilePath, $nLineNumber)
    {
        error_log(PHP_EOL.date("Y-m-d H:m:s", time())." ".$strFilePath."#".$nLineNumber.": ".$strMessage.PHP_EOL);
        throw new ErrorException($strMessage, 0, $nNumber, $strFilePath, $nLineNumber);
    });

    // Top directory
	$SweetPay	= realpath(__DIR__ . 'Index.php/');

    // loads the vendor classes
	require '../src/vendor/autoload.php';

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






	$setup = [  "apiKey"            => (string) "NNq7Rcnb8y8jGTsU",
        "stage"             => (boolean) true,
        "DEFAULT_TIMEOUT"   => (int ) 30 ];

    $transactionData = array(
        'subscriptions' => array(
            array('amount' => '100', 'currency' => 'SEK','startsAt' => '2016-01-01', 'interval' =>' MONTHLY')  ,
            array('amount' => '200', 'currency' => 'SEK','startsAt' => '2016-01-01', 'interval' =>' MONTHLY')
        ),
        'country' => 'SE',
        'merchantId' => 'paylevo');






	try {
        \Sweetpay\CheckoutCond::setCondition($setup);

    } catch (Exception $e) {
        $input  = array('line' => __LINE__,
            'path' => __FILE__);
        \Sweetpay\Helper::errorMessage($e, $input);
        var_dump(\Sweetpay\CheckoutCond::getApiKey());

    }

    try {
        $Check = new \Sweetpay\CheckOut($transactionData);
        var_dump($Check->getOutput())                  ;

    } catch (Exception $e) {
        $input  = array('line' => __LINE__,
            'path' => __FILE__);
        \Sweetpay\Helper::errorMessage($e, $input);

    }
