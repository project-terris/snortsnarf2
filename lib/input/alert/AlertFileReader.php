<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 30/03/16
 * Time: 5:31 PM
 */

/**
 * Class AlertFileReader specifies functions for applying actions on an IAlertFile
 */
class AlertFileReader implements IReader
{

    private $alertFile;

    public function __construct(IAlertFile $alertFile){
        $this->alertFile = $alertFile;
    }

    /**
     * getEntry fetches the next alert entry from the alertFile
     */
    public function getNextEntry(){
        return $this->alertFile->getNextEntry();
    }
}