<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 9:07 PM
 */
class FileValidator
{

    public static function isValidFile($fileDir){
        return (file_exists($fileDir) && is_file($fileDir));
    }

    public static function isReadableFile($fileDir){
        return (is_readable($fileDir));
    }

    public static function isReadableAndWriteable($fileDir){
        return (is_readable($fileDir) && is_writable($fileDir));
    }


}