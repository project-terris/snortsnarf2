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

    private $queue;

    public function __construct(EntryQueue $queue){
        $this->queue = $queue;
    }

    public function run(){
        Logger::debug($this->getThreadId() ." - Starting Thread\n");


    }
}