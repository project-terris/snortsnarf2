<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 24/02/16
 * Time: 12:38 PM
 */

/**
 * Class FLAGS - is a storage class storing state information about what flags have been set. These are different then
 * setting flags with only a single dash. double dash flags are enabled by being present in the runtime calls
 */
class FLAGS
{
    public $DEBUG = false;
    public $BENCHMARK = false;
    public $WRITE = true;

    /**
     * magic method for dynamicaly settings static variables
     * @param $name
     * @param $value
     */
    public function __set($name, $value){
        $this->$name = $value;
    }
}

