<?php
/**
 * Created by .
 * User: AkinoOsx
 * Date: 04/08/16
 * Time: 11:56
 */

namespace Sweetpay;


use Sweetpay\httpClient\CurlClient AS Curl;

class CheckOut
{

    private $dataset        = array();
    protected $respons      ;
    private $what ;

    public function __construct(array $data)
    {

        if( count($data) > 0 & ! empty($data))
        {
            $this->what     = $this->getKeys($data);

            $this->dataset  = \Sweetpay\Helper::setConditionArray($data, $this->what);
        }
        $curl                   =  new Curl($this->dataset);

        $this->respons          = $curl->request();
    }

    public function __destruct()
    {
        unset($this->dataset);
        unset($respons) ;
    }

    /**
     * @return array|null
     */
    public function getRespons()
    {

        if(is_null( $this->respons ) )
        {
            $message = "Error using function " .  __FUNCTION__ . "() ";
            $message .= "respons is null, please check input again";
            throw new Exception ($message);
        }

        return $this->respons;
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