<?php

	date_default_timezone_set('Europe/Stockholm');
    set_error_handler( function($nNumber, $strMessage, $strFilePath, $nLineNumber)
    {
		error_log(PHP_EOL.date("Y-m-d H:m:s", time())." ".$strFilePath."#".$nLineNumber.": ".$strMessage.PHP_EOL);
		throw new ErrorException($strMessage, 0, $nNumber, $strFilePath, $nLineNumber);
    });

    // Top directory
	$SweetPay	= realpath(__DIR__ . '/..');
	
	require 'src/vendor/autoload.php';
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





	$setup = ["apiKey" => (string) "NNq7Rcnb8y8jGTsU",
			  "stage" => (boolean) true];

    $data = array(
            'transactions' => array(
                    array('amount' => 100, 'currency' => 'SEK')
            ),
            'country' => 'SE',
        'merchantId' => 'paylevo');

	try {
		Sweetpay\CheckoutCond::setCondition($setup);
		var_dump(Sweetpay\CheckoutCond::getApiKey());

	} catch (Exception $e) {
	    echo 'Caught exception: ',  $e->getMessage(), PHP_EOL;
	}

try {
    $curl = new Sweetpay\httpClient\CurlClient($data);
    var_dump($curl->getTimeOut());
    var_dump($curl->request());
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), PHP_EOL;
}
	//$logger = new \Controllers\MyLoggers( );
	
	//$logger->setLog('its ready') ;