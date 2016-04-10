<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 10/04/16
 * Time: 1:48 PM
 */
class WriterFactory
{

    public static function determineOutput(ArgParcer $argument){

        return self::toIWriter(null);
    }

    private static function toIWriter(IWriter $object){
        return $object;
    }
}