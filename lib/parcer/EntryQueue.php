<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 22/02/16
 * Time: 4:41 PM
 */

/**
 * Class AlertManager is a shared resource that stores the alert values that have been parsed out of the alert file.
 * From here threads will query for a segment of an alert to parse apart into an appropriate object and give back to
 * the alert object in their formatted state
 */
class EntryQueue
{

    private $unsortedAlerts;
    private $sortedAlerts;

    //private $semaphore;
    //private $semkey = 5050;

    private $mutex;

    public function __construct(){
        $this->unsortedAlerts = Array();
        $this->sortedAlerts = Array();
        //$this->semaphore = sem_get($this->semkey);
        $this->mutex = Mutex::create();


    }

    /**
     * getUnsortedAlert gets an unsorted alert from the unsortedAlert array. The method uses a mutex to enforce mutual
     * exclusion
     * @return DataEntry|null - An alert needing to be sorted or NULL if the queue is empty
     */
    public function getUnsortedAlert(){
        //sem_acquire($this->semaphore);
        Mutex::lock($this->mutex);

        $alert = array_pop($this->unsortedAlerts);
        //sem_release($this->semaphore);

        Mutex::unlock($this->mutex);
        return $alert;
    }

    public function setUnsortedAlert(DataEntry $alert){
        //sem_acquire($this->semaphore);
        Mutex::lock($this->mutex);

        array_push($this->unsortedAlerts, $alert);
        //sem_release($this->semaphore);
        Mutex::unlock($this->mutex);
    }

    /**
     * setSortedAlert sets the alert into the sortedAlerts array. It uses mutexes to enforces mutualy exclusive actions
     * @param $alert - the alert object being added to the sorted arrays
     */
    public function setSortedAlert(DataEntry $alert){
        //sem_acquire($this->semaphore);
        Mutex::lock($this->mutex);

        array_push($this->sortedAlerts, $alert);
        //sem_release($this->semaphore);
        Mutex::unlock($this->mutex);
    }

    /**
     * getSortedAlerts returns the array of sorted alerts
     * @return array - the array of parced alerts
     */
    public function getSortedAlerts(){
        return $this->sortedAlerts;
    }


}