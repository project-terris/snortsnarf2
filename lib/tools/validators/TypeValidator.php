<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 9:14 PM
 */

/**
 * Class TypeValidator contains functionality for determining primitive variable types. This class contains static
 * functionality on determining type and implementation on reacting to failure of valid type
 */
class TypeValidator
{

    /**
     * isString determines if the passed in variable is a string and contains additional functionality for handling a failure
     * @param $variable - the variable being tested as to whether it is a string
     * @param bool $convertToStringIfInvalid - set to TRUE will cause isString to convert the passed in variable to a string
     * @param bool $throwExceptionIfInvalid - set to TRUE will cause isString to throw an exception if the validation is false
     * @param Exception|null $exceptionThrown - if throwExeptionIfInvalid is set to true, the passed in exception will be thrown.
     * If one is not included, a generic TypeValidator exception will be thrown
     * @return bool|string - returns string if convertToStringIfInvalid is true, otherwise true or false as to whether the
     * variable is valid or not
     * @throws Exception - thrown when the variable is not a string and throwExceptionIfInvalid is set to true
     */
    public static function isString($variable, $convertToStringIfInvalid = false, $throwExceptionIfInvalid = false, Exception $exceptionThrown = null){
        if(is_string($variable)){
            return true;
        }else{

            //do we throw an exception ?
            if($throwExceptionIfInvalid){
                if($exceptionThrown != null){
                    throw $exceptionThrown;
                }else{
                    throw new Exception("TypeValidator - String Validated Is Not A String");
                }

            }

            //do we convert it and return it ?
            if($convertToStringIfInvalid){
                 return strval($variable);

            }

            return false;

        }
    }

    /**
     * isNumber determines if that passed in variable is a numeric value. This will return true if the variable is
     * an Integer, Float or Double.
     * @param $variable - the variable being validated whether it is a number
     * @param bool $throwExceptionIfInvalid - set to TRUE will cause isNumber to throw an exception if validation fails
     * @param Exception|null $exceptionThrown - if throwExceptionIfInvalid is set to true, if this variable is set, isNumber
     * will throw this passed in exception. Otherwise isNumber will throw a generic TypeValidator exception
     * @return bool - status as to whether the passed in varaible is a number or not
     * @throws Exception - thrown when the variable is not a number and the throwExceptionIfInvalid is set to true
     */
    public static function isNumber($variable, $throwExceptionIfInvalid = false, Exception $exceptionThrown = null){
        if(is_numeric($variable)){
            return true;
        }else{

            //do we throw an exception ?
            if($throwExceptionIfInvalid){
                if($exceptionThrown != null){
                    throw $exceptionThrown;
                }else{
                    throw new Exception("TypeValidator - Number Validated Is Not A Number");
                }
            }

            return false;

        }
    }

}