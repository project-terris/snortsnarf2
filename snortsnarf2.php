<?php
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
    ArgParcer::setupArgParcer($argv);
    $arguments = ArgParcer::getInstance();





    return 0;
}
exit(main($argc, $argv));