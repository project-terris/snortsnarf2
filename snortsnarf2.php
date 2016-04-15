<?php
require_once('./lib/AutoLoader.php');
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 22/02/16
 * Time: 4:06 PM
 */

/**
 * displayVersion displays version information for snortsnarf2
 */
function displayVersion(){
    $ini = parse_ini_file(__DIR__ . "/app.ini");
    print($ini['app_name'] . " Version: " . $ini['app_version'] . "\n");
}

/**
 * displayHelp displays basic help information for snortsnarf2
 */
function displayHelp(){
    print("Please see Github Wiki Page for Help: https://github.com/project-terris/snortsnarf2/wiki\n");
}


/**
 * main entrance point to the snortsnarf2 program
 * @param $argc Int - the number of parameters passed
 * @param $argv Array - the parameters passed
 * @return int - the status of the program. 0 means successful, 1 means error
 */
function main($argc, $argv){

    //parse out arguments passed
    $formattedArguments = ArgParcer::formatArguments($argv);
    $arguments = ArgParcer::getInstance($formattedArguments);

    if($arguments->getValue(PARAMETERKEYS::VERSION)){
        displayVersion();
        return 0;
    }

    if($arguments->getValue(PARAMETERKEYS::HELP)){
        displayHelp();
        return 0;
    }

    //setup logger
    Logger::setLogger($arguments->getFlags());
    Logger::varDump(new FLAGS(), $formattedArguments);

    //get whatever we are reading data from -> The returned type is an IReader
    $dataSource = ReaderFactory::determineSource($arguments);

    //now start creating threads

    //tell threads to begin executing

    //now start getting each entry and putting them into the AlertManager
    //$dataSource->getNextEntry();



    return 0;
}
exit(main($argc, $argv));