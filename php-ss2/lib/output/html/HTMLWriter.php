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

    private $loggerFlags;

    public function __construct(OutputQueue $queue, FLAGS $flags, $rootDirectory = (__ROOTDIR__ . "/www")){
        $this->outputQueue = $queue;
        $this->rootDirectory = $rootDirectory;
        $this->loggerFlags = $flags;
    }

    public function run(){
        Logger::setLogger($this->loggerFlags);
        Logger::debug(" " . $this->getThreadId() ." - Starting " . strval(self::class) . " Thread\n");



    }




}