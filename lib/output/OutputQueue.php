<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 18/04/16
 * Time: 12:04 PM
 */
class OutputQueue
{
    private $toBeWritten;
    private $mutex;

    public function __construct(){
        $this->toBeWritten = Array();
        $this->mutex = Mutex::create();
    }

    public function addToQueue(WritableEntry $entry){
        Mutex::lock($this->mutex);

        array_push($this->toBeWritten, $entry);
        Mutex::unlock($this->mutex);
    }

    public function getNextFromQueue(){
        Mutex::lock($this->mutex);

        $entry = array_pop($this->toBeWritten);
        Mutex::unlock($this->mutex);
        return $entry;
    }

}