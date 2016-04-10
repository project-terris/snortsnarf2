<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 30/03/16
 * Time: 5:33 PM
 */

/**
 * Class AlertFileFactory generates an IAlertFile based on the passed in fileDir. AlertFileFactory determines
 * what snort mode was used to generate the alert file and then returns the appropriate IAlertFile for that type
 */
class AlertFileFactory
{

    /**
     * getFile gets the passed in file and determines whether it is a FastAlertFile or a FullAlertFile and creates
     * the appropriate object before returning it for the designated file
     * @param $fileDir String - the directory to the alert file
     */
    public static function getFile($fileDir){

        return self::toIAlertFile(null);
    }

    private static function toIAlertFile(IAlertFile $object){
        return $object;
    }
}