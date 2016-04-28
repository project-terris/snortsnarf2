<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 9:07 PM
 */

/**
 * Class FileValidator contains a number fo static methods that allow users to determine validity of files, whether that
 * be their readability or whether they are valid. FileValidator also includes functionality for determining directories
 * from files and whether directories are aswell valid
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

    public static function isValidDirectory($dir){
        //TODO: Implement validation for directories
    }


}