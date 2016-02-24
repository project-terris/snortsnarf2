<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 24/02/16
 * Time: 1:29 PM
 */

//TODO: Implement namespaces for more effective dynamic loading of classes

spl_autoload_register(function($class){
    if(file_exists("./lib/html/$class.php")){
        require_once("./lib/html/$class.php");
    }
    if(file_exists("../lib/html/$class.php")){
        require_once("../lib/html/$class.php");
    }

    if(file_exists("./lib/parcer/$class.php")){
        require_once("./lib/parcer/$class.php");
    }
    if(file_exists("../lib/parcer/$class.php")){
        require_once("../lib/parcer/$class.php");
    }

    if(file_exists("./lib/tools/$class.php")){
        require_once("./lib/tools/$class.php");
    }
    if(file_exists("../lib/tools/$class.php")){
        require_once("../lib/tools/$class.php");
    }
});