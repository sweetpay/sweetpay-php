<?php

namespace Sweetpay\httpClient;


use Sweetpay\Helper ;

use \Exception;

class CurlClient extends CurlBase
{

    public static $namespaces   = __NAMESPACE__;
    public static $classes      = __CLASS__;

    //@array data of the transaction
    private $dataset        = array();
    //@array get the conditions from parent
    private $condArray      = array( );


    private $absurl         ;

    public function __construct(array $data)
    {
        parent::__construct( );
        if( count($data) > 0 & ! empty($data))
        {
            $this->dataset     = $data;
        }

        $this->condArray    = parent::getCondition();
        $this->absurl       = $this->condArray['apiBase'];
        if(empty( $this->absurl) ||  $this->absurl === "")
        {
            $message    = sprintf("The url dont exist (%s) please enter valid url", $this->absurl );
            throw Exception($message);
        }
    }
    
    
    
////////////////////////////////////////////////////////////////////////////
// Get functions 
////////////////////////////////////////////////////////////////////////////
    public function request($method = null)
    {
        $outputArray       = array( );
        $curl   = curl_init();
        $method = strtolower($method);
        $opts   = array();

        // conditions from Checkout and CurlBase


        $opts[CURLOPT_TIMEOUT]          = (int)  $this->condArray ["DEFAULT_TIMEOUT"];
        $opts[CURLOPT_CONNECTTIMEOUT]   = (int)  $this->condArray ['DEFAULT_CONNECT_TIMEOUT'];
        $opts[CURLOPT_URL]              = (string) Helper::setToUtf8($this->absurl) ;
        $opts[CURLOPT_RETURNTRANSFER]   = (boolean) true;
        $opts[CURLOPT_POST]             = (boolean) true;
        $opts[CURLOPT_SSL_VERIFYPEER]   = false;
        $opts[CURLOPT_HTTPHEADER]       = array(
                                            'Content-Type: application/json',
                                            'Authorization: ' .   $this->condArray ["apiKey"]
        );


        $opts[CURLOPT_POSTFIELDS] = Helper::encode($this->dataset, $prefix = 'json');

        curl_setopt_array($curl, $opts)  ;

        $respones          = curl_exec($curl);

        if( $respones === false )
        {
            $errno      = curl_errno($curl);
            $message    = curl_error($curl);
            curl_close($curl);
            $this->handleCurlError($this->absurl, $errno, $message);
        }

        $status         = curl_getinfo($curl,CURLINFO_HTTP_CODE);


        curl_close($curl);
        $outputArray    =  array('respons' => $respones, 'status' => $status, 'inputOpts' =>$opts);
        return count($outputArray) > 0  ? $outputArray : null;
    }




    public function getTimeOut( )
    {
        return $this;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////
    // functions used only in CurlClient
    ////////////////////////////////////////////////////////////////////////////////////////////////
    private function handleCurlError($url, $errno, $message)
    {
        switch ($errno) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $msg = "Could not connect to Sweetpay ($url).  Please check your "
                    . "internet connection and try again.  If this problem persists, "
                    . "you should check Sweetpay's support status at "
                    . "xy, or";
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                $msg = "Could not verifySSL certificate.  Please make sure "
                    . "that your network is not intercepting certificates.  "
                    . "(Try going to $url in your browser.)  "
                    . "If this problem persists,";
                break;
            default:
                $msg = "Unexpected error communicating with Sweetpay.  "
                    . "If this problem persists,";
        }
        $msg .= " let us know at support@sweetpay.com.";

        $msg .= "\n\n(Network error [errno $errno]: $message)";

        throw new Exception($msg);

    }


} // end of class




