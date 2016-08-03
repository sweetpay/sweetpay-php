<?php
namespace Sweetpay;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class MyLoggers
{
     
    
    public function __construct( )
    {
        $this->path         = realpath(__DIR__. '/../logs');
        $this->classes      = __CLASS__ ;
        
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
     *$log->setLog($message = $message, $func = __FUNCTION__, $path = self::$classes);
     */
    public function setLog($message, $func, $path)
    {
        isset($path) ? $path : $this->classes;
        $logger = new Logger($func);
        $logger->pushHandler(new StreamHandler($this->path . "/{$path}.log", Logger::DEBUG));
        return $logger->addInfo($message);
    }
    
  
} // class loggers ends here 





