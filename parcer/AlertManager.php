<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 22/02/16
 * Time: 4:41 PM
 */

/**
 * Class AlertManager is a shared resource that stores the alert values that have been parced out of the alert file.
 * From here threads will query for a segment of an alert to parce apart into an appropriate object and give back to
 * the alert object in their formatted state
 */
class AlertManager
{

    private $unsortedAlerts;
    private $sortedAlerts;
    private $mutex;

    public function __construct(){
        $this->unsortedAlerts = Array();
        $this->sortedAlerts = Array();
        $this->mutex = Mutex::create();
    }

    /**
     * getUnsortedAlert gets an unsorted alert from the unsortedAlert array. The method uses a mutex to encofrce mutual
     * exclusion
     * @return mixed - An alert needing to be sorted
     */
    public function getUnsortedAlert(){
        Mutex::lock($this->mutex);

        $alert =  array_pop($this->unsortedAlerts);
        Mutex::unlock($this->mutex);
        return $alert;

    }

    /**
     * setSortedAlert sets the alert into the sortedAlerts array. It uses mutexes to enforces mutualy exclusive actions
     * @param $alert - the alert object being added to the sorted arrays
     */
    public function setSortedAlert($alert){ //TODO: Specifiy type hinting for the object being sent
        Mutex::lock($this->mutex);

        array_push($this->sortedAlerts, $alert);
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