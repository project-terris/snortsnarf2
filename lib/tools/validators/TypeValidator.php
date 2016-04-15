<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 9:14 PM
 */
class TypeValidator
{

    public static function isString($variable, $convertToStringIfInvalid = false, $throwExceptionIfInvalid = false, Exception $exceptionThrown = null){
        if(is_string($variable)){
            return true;
        }else{

            if($throwExceptionIfInvalid){
                if($exceptionThrown != null){
                    throw $exceptionThrown;
                }else{
                    throw new Exception("TypeValidator - String Validated Is Not A String");
                }

            }

            if($convertToStringIfInvalid){
                 return strval($variable);

            }

        }
    }

}