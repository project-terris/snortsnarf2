<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 24/02/16
 * Time: 12:34 PM
 */

/**
 * Class HTMLWriter writes the specified entry to file using the snortsnarf folder structure of organizing its entries
 */
class HTMLWriter extends Thread implements IWriter
{
    private $rootDirectory;
    private $outputQueue;

    public function __construct(OutputQueue $queue, $rootDirectory = (__ROOTDIR__ . "/www")){
        $this->outputQueue = $queue;
        $this->rootDirectory = $rootDirectory;
    }

    public function run(){
        //Logger::debug(" " . $this->getThreadId() ." - Starting " . strval(self::class) . " Thread\n");
        Logger::debug("HELLOO");


    }




}