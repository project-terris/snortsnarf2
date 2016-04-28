<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 03/04/16
 * Time: 4:17 PM
 */
class ParcerException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}