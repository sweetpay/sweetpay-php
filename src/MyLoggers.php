<?php
namespace Sweetpay;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Sweetpay\Helper;

class MyLoggers
{
     
    
    public function __construct( )
    {
        $this->path         = realpath(__DIR__. '/logs');
        $this->classes      = __CLASS__ ;
        $this->dirname      = dirname(__DIR__);
    } // construct end here
    
    
////////////////////////////////////////////////////////////////////////////////
// function
////////////////////////////////////////////////////////////////////////////////
    /*@abstract return a log file to log directory
     *@param $message {string} the message to display in the log file
     *@param $func {string} message info, default is the function where the
     *error happend
     *@param $path {string} the class where the error happened
     *@example $log = new MyLoggers( );
     *$log->setLog($message = $message, $func = __FUNCTION__, $name =  );
     */
    public function setLog($arg, $func, $name = null)
    {
        if( ! is_null($name) )
        { // if is defined
            $name1  =  Helper::getClassName($name);
        } else {
            $name1   = 'error';
        }

        $logger = new Logger($func);
        $logger->pushHandler(new StreamHandler($this->path . "/{$name1}.log", Logger::DEBUG));
        return $logger->addInfo(json_encode($arg));
    }
    
  
} // class loggers ends here 





