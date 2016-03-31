<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 24/02/16
 * Time: 1:29 PM
 */

//TODO: Implement namespaces for more effective dynamic loading of classes

spl_autoload_register(function($class){

    if(is_dir("../lib")){
        require_once(recursiveGetPhpFile("../lib/", $class));
    }else if(is_dir("./lib")){
        require_once(recursiveGetPhpFile("./lib/", $class));
    }else{
        throw new Exception("AutoLoader - Could Not Find lib folder for class $class.php");
    }



});

function recursiveGetPhpFile($directory, $class){

    $Directory = new RecursiveDirectoryIterator($directory);
    $Iterator = new RecursiveIteratorIterator($Directory);
    $Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

    foreach($Regex as $file){

        if(strpos($file[0], "/$class.php")){
            //require_once($file[0]);
            //break;
            return $file[0];
        }
    }

    throw new Exception("AutoLoader - Failed To Find Class $class.php recursively in the Directory $directory");

}



