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
    private $fastAlertParser;

    public function __construct(EntryQueue $inputQueue, OutputQueue $outputQueue, $outputType){
        $this->inputQueue = $inputQueue;
        $this->outputQueue = $outputQueue;
        $this->outputType = $outputType;

        $this->fastAlertParser = new FastAlertParser();
    }

    public function run(){
        Logger::debug($this->getThreadId() ." - Starting Thread\n");

        $line = pop($this->inputQueue);
        if($line != null) {
            $this->fastAlertParser->parseAlertLine($line);
        } else {
            $this->wait(1);
        }
    }
}