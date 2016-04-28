<?php
require_once('EntryQueue.php');

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

    public function __construct(EntryQueue $manager){
        print(Thread::getCurrentThreadId());
    }

    public function run(){

    }
}