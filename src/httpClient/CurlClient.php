<?php

namespace Sweetpay\httpClient;



use \Exception;

class CurlClient extends CurlBase
{

    private $dataset = array();

    public function __construct(array $data)
    {
        parent::__construct( );
        if( count($data) > 0 & ! empty($data))
        {
            $this->dataset     = $data;
        }

    }
    
    
    
////////////////////////////////////////////////////////////////////////////
// Get functions 
////////////////////////////////////////////////////////////////////////////
    public function request($method = null)
    {
        $curl   = curl_init();
        $method = strtolower($method);
        $opts   = array();

        // conditions from Checkout and CurlBase
        $condArray   = parent::getCondition();

        $opts[CURLOPT_TIMEOUT]          = (int) $condArray["DEFAULT_TIMEOUT"];
        $opts[CURLOPT_CONNECTTIMEOUT]   = (int) $condArray['DEFAULT_CONNECT_TIMEOUT'];
        $opts[CURLOPT_URL]              = (string) $condArray['apiBase'];
        $opts[CURLOPT_RETURNTRANSFER]   = (boolean) true;
        $opts[CURLOPT_POST]             = (boolean) true;
        $opts[CURLOPT_SSL_VERIFYPEER]   = false;
        $opts[CURLOPT_HTTPHEADER]       = array(
                                            'Content-Type: application/json',
                                            'Authorization: ' .  $condArray["apiKey"]
        );
        $opts[CURLOPT_POSTFIELDS] = self::encode($this->dataset, $prefix = 'json');
        curl_setopt_array($curl, $opts)  ;

        $rbody = curl_exec($curl);
        $status = curl_getinfo($curl,CURLINFO_HTTP_CODE);

        if (curl_errno($curl))
        {
            $message = json_encode(array( $status, curl_errno($curl)));
            throw new Exception( $message );
        }
        curl_close($curl);

        return array($rbody,$status,$opts);
    }




    public function getTimeOut( )
    {
        return $this;
    }

    public static function encode($arr, $prefix = null)
    {
        if (!is_array($arr)) {
            return $arr;
        }

        $r = array( );
        if( $prefix == 'json')
        {
            return json_encode($arr);
        } else {
            foreach ($arr as $k => $v) {
                if (is_null($v)) {
                    continue;
                }

                if ($prefix) {
                    if ($k !== null && (!is_int($k) || is_array($v))) {
                        $k = $prefix . "[" . $k . "]";
                    } else {
                        $k = $prefix . "[]";
                    }
                }

                if (is_array($v)) {
                    $enc = self::encode($v, $k);
                    if ($enc) {
                        $r[] = $enc;
                    }
                } else {
                    $r[] = urlencode($k) . "=" . urlencode($v);
                }
            }
            return implode("&", $r);
        }


    }


} // end of class




