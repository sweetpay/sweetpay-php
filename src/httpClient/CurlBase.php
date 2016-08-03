<?php

namespace Sweetpay\httpClient;
// call the condtions
use Sweetpay\CheckoutCond;

abstract class CurlBase 
{
    protected  $condition;
    /*Default value used to run curl, can be change in the setup array */
    public static $DEFAULT_TIMEOUT           = 80;
    public static $DEFAULT_CONNECT_TIMEOUT   = 30;
    /*Will run the loop to see weather a change has occured in the variables*/
    private $checkOption                     = array( );
    public function __construct( )
    {
        $Check              = new CheckoutCond( );
        $this->condition    = $Check->getCond();
        /*Only those that can be change by the user*/
        $this->checkOption   = array("DEFAULT_TIMEOUT",
                                    "DEFAULT_CONNECT_TIMEOUT");   
        
        foreach($this->checkOption AS $check)
        { // go throught the checkOption array
            if(! array_key_exists($check, $this->condition))
            { // if the variable dont exist then take the default
                $this->condition["$check"] =   self::${$check}  ;
            }
        
        }
      
    }



    ////////////////////////////////////////////////////////////
    // Get function
    ////////////////////////////////////////////////////////////
    protected function getCondition()
    {
        return $this->condition;
    }
} // end of class


