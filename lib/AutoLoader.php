<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 24/02/16
 * Time: 1:29 PM
 */

//TODO: Implement namespaces for more effective dynamic loading of classes

$Directory = new RecursiveDirectoryIterator(__DIR__ . "/");
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

spl_autoload_register(function($class){

    foreach($GLOBALS['Regex'] as $file){

        if(strpos($file[0], "/$class.php")){
            //require_once($file[0]);
            //break;
            require_once($file[0]);
            return;
        }
    }

    throw new Exception("AutoLoader - Failed To Find Class $class.php recursively");
});
