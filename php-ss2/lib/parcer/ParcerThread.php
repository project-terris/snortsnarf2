<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 22/02/16
 * Time: 4:42 PM
 *
 * Sources:
 * http://php.net/manual/en/class.thread.php
 */


class ParcerThread extends Thread
{

    private $inputQueue;
    private $outputQueue;
    private $outputType;

    private $loggerFlags;

    public function __construct(EntryQueue $inputQueue, OutputQueue $outputQueue, $outputType, FLAGS $flags){
        $this->inputQueue = $inputQueue;
        $this->outputQueue = $outputQueue;
        $this->outputType = $outputType;

        $this->loggerFlags = $flags;
    }

    public function run(){
        Logger::setLogger($this->loggerFlags);
        Logger::debug($this->getThreadId() ." - Starting Parser Thread\n");


    }
}