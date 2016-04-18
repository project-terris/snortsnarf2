<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 18/04/16
 * Time: 12:09 PM
 */

/**
 * Class WritableEntry represents an entry that was created by the parser and is ready to be written to file
 */
class WritableEntry
{

    /**
     * @var completeString is the completely compiled together string. This could be the complete HTML string or for
     * SQL, the complete SQL INSERT query string
     */
    public $completeString;
    /**
     * @var parsedObject is an object containing the raw components parsed out in the parser. This is to be used to
     * store additional meta information or data that the writer may need in order to successfuly write the $completeString
     */
    public $parsedObject;
}