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

    public function __construct(EntryQueue $inputQueue, OutputQueue $outputQueue){
        $this->inputQueue = $inputQueue;
        $this->outputQueue = $outputQueue;
    }

    public function run(){
        Logger::debug($this->getThreadId() ." - Starting Thread\n");


    }
}