<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 30/03/16
 * Time: 5:36 PM
 */
class FullAlertFile extends CommonAlertFile implements IAlertFile
{

    public function __construct($fileDir){
        parent::__construct($fileDir, self::class);
    }

    public function getNextEntry(){

        //initialize variables
        $fullString = "";
        $nextLine = "";

        //get the first line
        $nextLine = fgets($this->fp);
        $fullString .= $nextLine;

        //keep going until we have something that contains an entry
        while(!$this->containsACompleteEntry($fullString)){
            $nextLine = fgets($this->fp);
            $fullString .= $nextLine;
        }

        //now we need to rewind. move the fp back to before the last entry, since it will always go 1 too far
        fseek($this->fp, strlen($nextLine), SEEK_CUR);

        //trim out the last entry because checker overshoots the entry into the next one
        $trimmedEntry = substr($fullString, 0, strpos($fullString, $nextLine));
        //clean the entry
        $trimmedEntry = $this->cleanAlertFileEntry($trimmedEntry);

        return $trimmedEntry;

    }



}