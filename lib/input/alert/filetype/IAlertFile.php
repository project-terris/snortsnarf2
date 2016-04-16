<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 30/03/16
 * Time: 5:34 PM
 */
interface IAlertFile
{

    /**
     * getNextEntry defines functionality for fetching the next entry out of the alert file as a string and returning
     * it as this completed string
     * @return String - a string representation of the alert file entry
     */
    public function getNextEntry();
}