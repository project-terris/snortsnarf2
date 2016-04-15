<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 30/03/16
 * Time: 5:35 PM
 */

/**
 * Class ReaderFactory generates an IReader implementing object that appropriatly maps to the passed in parameters. This
 * class determines whether the passed in arguments is belonging to for example an Alert file or an SQL connection source.
 */
class ReaderFactory
{

    /**
     * determineSource is a static function that determines whether the passed in arguments are for an Alert file or
     * and SQL connection and returns the appropritate IReader object
     * @param ArgParcer $arguments - The parameter passed arguments containing results as to whether configuration
     * involves an alert file or an sql connection or anything else that is an IReader
     * @return IReader - A generic object pointing to the source
     * @throws ReaderException - Thrown when a source can not be determined from the passed parameters
     */
    public static function determineSource(ArgParcer $arguments){

        /* Notes:
        - You are creating either an AlertFileReader class or an SQLDatabaseReader class.
        - Each class has its own requirements in what is expected to be given. Meaning additional searches in arguments may be needed
        - Eg. For an AlertFile, you will need to use the AlertFileFactory to generate the IAlertFile class that you need to create
        an AlertFileReader
        */

        $alertFile = $arguments->getValue(PARAMETERKEYS::ALERTSRCDIR);
        if($alertFile != null){

            $alertFile = AlertFileFactory::getFile($alertFile);
            $alertFileReader = new AlertFileReader($alertFile);
            return self::toIReader($alertFileReader);

        }

        throw new ReaderException("ReaderFactory - Unable To Determine Source From Passed Arguments");
    }

    private static function toIReader(IReader $object){
        return $object;
    }
}