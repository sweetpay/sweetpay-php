<?php
/**
 * Created by .
 * User: AkinoOsx
 * Date: 04/08/16
 * Time: 11:56
 */

namespace Sweetpay;

use Sweetpay\Helper;
use Sweetpay\httpClient\CurlClient AS Curl;

class CheckOut
{

    private $dataset        = array();
    protected $output       = array( );
    protected $respons      ;
    private $what ;

    public function __construct(array $data)
    {

        if( count($data) > 0 & ! empty($data))
        {
            $this->what         = $this->getKeys($data);

            $this->dataset      = Helper::setConditionArray($data, $this->what);
        }
        $curl                   =  new Curl($this->dataset);
        // get the response
        $this->respons          = $curl->request( );
        $this->output           = Helper::setResponsArray($this->respons);


    }

    public function __destruct()
    {
        unset($this->dataset);
        unset($respons) ;
    }

    /**
     * @return array|null
     */
    public function getOutput()
    {

        if(is_null( $this->output ) & empty($this->output) )
        {
            $message = "Error using function " .  __FUNCTION__ . "() ";
            $message .= "respons is null, please check input again";
            throw new Exception ($message);
        }

        return $this->output;
    }

    /**
     * @param array $arg
     * @return string
     */
    private function getKeys(array $arg)
    {
        $keys   = array_keys($arg);
        if(in_array('subscriptions', $keys))
        {
            return 'subscriptions';
        } else {
            return 'transactions';
        }
    }

}