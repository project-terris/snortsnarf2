<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 24/02/16
 * Time: 12:35 PM
 */
class Logger
{

    private static $isSet = false;
    private static $flags;

    /**
     * setLogger is a ontime use function that sets the loggers flag settings. They can not be set again
     * @param FLAGS $settings - A FLAG object contain the settings of what locations are allowed to be logged to
     */
    public static function setLogger(FLAGS $settings){
        if(!self::$isSet){
            self::$flags = $settings;
            self::$isSet = true;
        }
    }


    /**
     * write is a standard print out function
     * @param $message String - the message being printed
     */
    public static function write($message){
        print($message);
    }

    /**
     * debug writes a standard print IF DEBUG has been enabled when the logger was configured
     * @param $message String - the message being printed
     */
    public static function debug($message){
        //var_dump(self::$flags);
        if(self::$flags->DEBUG){
            print($message);
        }
    }

    /**
     * benchmark writes a standard print IF BENCHMARK has been enabled when the logger was configured
     * @param $message String - the message being printed
     */
    public static function benchmark($message){
        if(self::$flags->BENCHMARK){
            print($message);
        }
    }

    /**
     * varDump is a logging helper function that will vardump an object to the passed in locations based on
     * whether those locations are available
     * @param FLAGS $locations - The locations you would like the varDump to be printed to. Note if it is not enabled
     * as a flag it will not be printed
     * @param $object - the object to be var_dumped
     */
    public static function varDump(FLAGS $locations, $object){
        if($locations->BENCHMARK){
            self::benchmark(var_dump($object));
        }

        if($locations->DEBUG){
            self::debug(var_dump($object));
        }

        if($locations->WRITE){
            self::write(var_dump($object));
        }
    }
}