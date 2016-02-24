<?php
require_once('./lib/AutoLoader.php');
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 22/02/16
 * Time: 4:06 PM
 */

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

    //setup logger
    Logger::setLogger($arguments->getFlags());
    Logger::varDump(new FLAGS(), $formattedArguments);


    return 0;
}
exit(main($argc, $argv));