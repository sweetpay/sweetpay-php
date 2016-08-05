<?php
/**
 * Created by .
 * User: Sweetpay
 * Date: 03/08/16
 * Time: 11:20
 */

namespace Sweetpay;


class Helper
{

    /**
     * @param $arr {Array} Going to be transfered for output into cURL
     * @param null $prefix {string} [json]
     * @return string
     * @exempal Helper::encode()
     */
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


    } // end of encode()


    private static $isMbstring= null;

    /**
     * @param string|mixed $value A string to UTF8-encode.
     *
     * @return string|mixed The UTF8-encoded string, or the object passed in if
     *    it wasn't a string.
     */
    public static function setToUtf8($value)
    {
        if (function_exists('mb_detect_encoding')) {
            self::$isMbstring = (boolean) true;

        } else{

            trigger_error("mbstring extension dont exist . " .
                "UTF-8 strings will not properly be encoded. Chekc with system " .
                "administrator to enable the mbstring extension " , E_USER_WARNING);
        }
        if (is_string($value) && self::$isMbstring && mb_detect_encoding($value, "UTF-8", true) != "UTF-8") {
            return utf8_encode($value);
        } else {
            return $value;
        }
    } // end of setToUtf8

    /**
     * @param create dir and
     *
     */
    public static function mkdirExt($arg)
    {

        if (!file_exists($arg)) {
            mkdir($arg, 0777, true);
        }
    }

    /**
     * @param $arg the Exception $e variable
     * @return echo:s the error message
     * @internal MyLoggers.php
     *
     */
    public static function errorMessage($arg, array $input)
    {
        $filepath       = $arg->getFile();
        $filename       = basename($filepath);
        $errorLine      = isset($input['line']) ? $input['line'] : '';
        $errorFile      = isset($input['path']) ? basename($input['path']) : '';
        $message = "\nCaught error: ($errorFile, line $errorLine): " . $arg->getMessage() ;
        $message .= " in file [" . $filename . "] on line (" .  $arg->getLine() . ")";
        $output     = array('message' => $message, 'output' => $input);
        $log        = new MyLoggers();
        $log->setLog($arg = $output, $func = __FUNCTION__, $name = $filename );
        echo $message;
    }

    public static function getClassName( $arg)
    {
        return preg_replace("/.*\\\(.*)/i", "$1", $arg);
    }

    /**
     * @param array $arg the multidimensional array
     * @param string $arg1 [transactions|subscriptions]
     * @return array of change types
     */
    public static function setConditionArray(array $arg, $arg1)
    {

        $isTransaction = preg_match('/transactions/', $arg1) ? true : false;
        $isTransaction = (boolean) $isTransaction;
        $checkToNumeric = array('amount');
        $checkDate      = !$isTransaction ? array('startsAt') : null;
        $checkString    = !$isTransaction ? array('interval') : null;
        foreach ($arg["$arg1"] AS $key => &$array)
        {
            if (!$isTransaction)
            {
                foreach ($checkDate AS $value)
                {
                    if(is_null($value)) next;
                    if ( self::validDate( $array["$value"] ) )
                    {
                        $array["$value"] = date("Y-m-d", strtotime($array["$value"]));
                    }
                } // end of foreach

                foreach ($checkString AS $value)
                {
                    if(is_null($value)) next;
                    if ( !is_string( $array["$value"] ) )
                    {
                        $array["$value"] = (string ) $array["$value"] ;
                    }
                } // end of foreach
            } // end of $isTransaction

            foreach ($checkToNumeric AS $value)
            {    ## Check all numeric mandatory

                if (!is_float($array["$value"]))
                {
                    $array["$value"] = floatval($array["$value"]);
                } // end of is_float
            }

        } // end of foreach.$transactionData

        return $arg;
    }// end of function


    public static function setResponsArray($arg)
    {
        if(is_array($arg))
        {
            $step1  = json_decode( $arg['respons'], $assoc = (bool) true) ;
            $date   = date("Y-m-d H:i:s", strtotime( $step1['createdAt'])) ;
            foreach ($step1 AS $key => &$value)
            {
                if(preg_match('/createdat/i', $key))
                { // update the date
                    $value  = $date;
                }
            } // end of foreach

        } else {
            $message    = "Input into ". __FUNCTION__ . " is not a array";
            $message    .= " please view the input again";
            throw Exception($message);
        }
        return array('respons' => $step1, 'options' => $arg['inputOpts']);
    }





    public static function validDate($arg)
    {
        // is valid data, gives numeric values
        $timestamp         = strtotime($arg);
        return $timestamp ? (boolean) true : (boolean) false;
    } // end of function









} // end of class