<?php

class  jsonValidate
{
    public static function Set($json)
    {
        if(!isset($json["ip"]) || !filter_var($json["ip"], FILTER_VALIDATE_IP)) {
            throw new Exception("IP is not set properly.Enter the IP in double quotes \"\"\n");    
        } 
        if (!isset($json["port"]) || !is_int($json["port"]) || $json["port"] < 1 ) {
            throw new Exception("Port is not set properly. Enter the PORT in INTEGER format \n");    
        } 
        if (!isset($json["weight"]) || !is_int($json["weight"]) || $json["weight"] < 1) {
            throw new Exception("Weight is not set properly.Enter the WEIGHT in INTEGER format \n");    
        } 
        if (!isset($json["name"]) || !is_string($json["name"]) || strlen($json["name"]) < 1) {
            throw new Exception("Service Name is not set properly .Enter the SERVICE NAME  in double quotes \n");    
        } 
        if (!isset($json["id"]) || !is_string($json["id"]) || strlen($json["id"]) < 1) {
            throw new Exception("Service ID is not set properly . Enter the SERVICE ID  in double quotes \n");    
        } 
    }
    
    public static function decode($json, $toAssoc = true)
    {
        $result = json_decode($json, $toAssoc);
        $error = '';
        switch(json_last_error())
        {
                case JSON_ERROR_NONE:
                    echo " Json is in correct Format \n";
                break;
                
                case JSON_ERROR_DEPTH:
                    $error = ' - Maximum stack depth exceeded';
                break;
               
                case JSON_ERROR_STATE_MISMATCH:
                    $error = ' - Underflow or the modes mismatch';
                break;
               
                case JSON_ERROR_CTRL_CHAR:
                    $error = ' - Unexpected control character found';
                break;
              
                case JSON_ERROR_SYNTAX:
                    $error = ' - Syntax error, malformed JSON';
                break;
               
                case JSON_ERROR_UTF8:
                    $error = ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
                
                case JSON_ERROR_RECURSION:  
                    $error = 'One or more recursive references in the value to be encoded';
                break;

                case JSON_ERROR_INF_OR_NAN:
                    $error = 'One or more NAN or INF values in the value to be encoded';
                break;

                case JSON_ERROR_UNSUPPORTED_TYPE:
                    $error = 'A value of a type that cannot be encoded was given';
                break;

                default:
                    $error = ' - Unknown error';           
        }   
        if (!empty($error ))
            throw new Exception('JSON Error: '.$error ."\n");        
        return $result;
    }
}

?>