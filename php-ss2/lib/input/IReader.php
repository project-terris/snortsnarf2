<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 30/03/16
 * Time: 5:31 PM
 */

/**
 * Interface IReader represents the public interface for any object with readable capabilities by the snortsnarf2
 * application
 */
interface IReader
{

    /**
     * getNextEntry implementation should contain functionality to read a single entry and return that entry as a cleaned
     * string. Calling this function again will fetch the next entry after the previous one, thus the implementor will have
     * to keep track of status and location from the previous call of this function
     * @return String - a cleaned entry read from the implementors source
     */
    public function getNextEntry();
}