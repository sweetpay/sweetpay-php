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




    private $checkOption                     = array('apiKey' => 'string',
                                                    'stage' => 'boolean',
                                                    'apiBase' => 'string');


    // when new is called then run this
    public function __construct()
    {
        $this->setConditions( );

    }

    /** @abstract set the cond from the <merchant script>
     * @param {string|character} the key
     * @throws  \Controllers\CheckoutCond::setCheckOut(<ARRAY OF CONDITIONS>)
     */
    public static function setCondition($arg)
    {
        $args = func_get_args();
        if( is_string($arg) & empty($arg) ) {
            $message = sprintf("input into directory (%s) and func: {%s()} is not array,
                                must be a array of keys (auth,stage[true|false]), please retry",
                self::$namespaces, __FUNCTION__);
            $log = new MyLoggers();
            $log->setLog($message = $message, $func = __FUNCTION__, $path = self::$classes);
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
    protected function setConditions( )
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

        }


    } // end of setConditions()



} // class end here
