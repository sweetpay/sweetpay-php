<?php
// This file will setup all the options for setting up the checkout

namespace Sweetpay;

use \Exception;
class CheckoutCond
{
    //@var array that is used inside the classes, contains the full array
    protected $condition;
    protected $tmpArray = array();
    //@var used as input from the outscide merchant script
    protected static $input;
    public static $namespaces   = __NAMESPACE__;
    public static $classes      = __CLASS__;

    ////////////////////////////////////////////////////////////////////////
    // Conditions needed for this script to run
    ////////////////////////////////////////////////////////////////////////

    public static $apiKey ; /* 'Authorization: NNq7Rcnb8y8jGTsU'*/
     
     // @var string The base URL for the Sweetpay API.
    public static $apiBase ;




    private $checkOption                     = array('apiKey'   => 'string',
                                                    'stage'     => 'boolean',
                                                    'apiBase'   => 'string');


    // when new is called then run this
    public function __construct()
    { // run the internal function when instantating and checking the option array
        $this->setCheckOutConditions( );
    }

    /**
     * @param $arg an array of setting that will be used to create the transaction/subscription
     * @throws Exception
     * @return a static array that will be used all around the sdk
     */
    public static function setCondition($arg)
    {
        $args       = func_get_args();
        if( is_string($arg) || empty($arg) || count($args) == 0) {
            $message = "Error using function " .  __FUNCTION__ . "() ";
            $message .= "must be an array, currently its empty or string, please retry";
            throw new Exception ($message);

        }
        /*set the apiBase*/
        foreach ($arg AS $key => $value)
        {
            if( preg_match("/stage/i", $key))
            {
                $extends = $value == true ? 'stage.' : '';
                $arg["apiBase"] = "https://checkout.{$extends}paylevo.com/v1/session/create";
            }
        }
        self::$input = $arg;
    }
    
    
    
////////////////////////////////////////////////////////////////////////////////////
// Public get function
////////////////////////////////////////////////////////////////////////////////////
    public static function getApiKey()
    {
        return self::$input;
    }

    public function getCond()
    {
        return $this->condition;
    }

    ////////////////////////////////////////////////////////////////////////////////////
    // set function
    ////////////////////////////////////////////////////////////////////////////////////


    /**@abstract Will update condition array and also update
     * with those that are not set by the user
     * @param none
     * @internal will update the $this->condition array
     * @throws
     *
     */
    protected function setCheckOutConditions( )
    {
        if(!empty(self::$input))
        {
            $this->tmpArray   = self::$input;

            // check the conditions
            foreach ($this->checkOption AS $key=>$value)
            { //key=auth, value = conditions
                if(! array_key_exists($key,  self::$input ))
                { // key not defined inside input then use default

                    $this->condition["$key"] = self::${$key};
                } else {
                    $this->condition["$key"] = self::$input["$key"];
                }

            }

        } else {
            $message = "Error using function " .  __FUNCTION__ . "() ";
            $message .= "the internal array set by setCondition() is empty";
            throw new Exception ($message);
        }


    } // end of setConditions()




} // class end here
