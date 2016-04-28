<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 30/03/16
 * Time: 5:35 PM
 */

/**
 * Class FastAlertFile represents a manager for a snort alert file that was generated on fast mode. It implements the
 * CommonAlertFile class to access shared functionality and implements an IAlertFile to give a public interface
 */
class FastAlertFile extends CommonAlertFile implements IAlertFile
{

    public function __construct($fileDir){
        parent::__construct($fileDir, self::class);
    }

    /**
     * getNextEntry fetches the next entry in the fast alert file so that it can be processes by the parser. This method
     * implements the IAlertFile as part of its public interface
     * @return string - The fast alert entry as a cleaned string
     */
    public function getNextEntry(){

        //initialize variables
        $fullString = "";
        $nextLine = "";

        //get the first line
        $nextLine = fgets($this->fp);
        $fullString .= $nextLine;

        if($nextLine !== false){
            //keep going until we have something that contains an entry
            while(!$this->containsACompleteEntry($fullString)){
                $nextLine = fgets($this->fp);

                if($nextLine === false){
                    Logger::debug(self::class . " - End Of Alert File Reached Or An Error Has Occurred Mid Parsing of An Entry\n");
                    break;
                }else{
                    $fullString .= $nextLine;
                }

            }
        }else{
            Logger::debug(self::class . " - End Of Alert File Reached Or An Error Has Occurred On First Read Attempt To Create Next Entry\n");
            return null;
        }

        //as long as the string is longer then 0, means there is something we should try and process
        if(strlen($fullString) > 0){

            //trim out the last entry because checker overshoots the entry into the next one
            $trimmedEntry = substr($fullString, 0, strpos($fullString, $nextLine));
            //clean the entry
            $trimmedEntry = $this->cleanAlertFileEntry($trimmedEntry);

            //make sure that the string we gathered wasn't just end of file spaces or return characters
            if(strlen($fullString) > 0){

                //now we need to rewind. move the fp back to before the last entry, since it will always go 1 too far
                fseek($this->fp, (-1 * strlen($nextLine)), SEEK_CUR);

                $dataEntry = new DataEntry();
                $dataEntry->dataString = $trimmedEntry;
                $dataEntry->fileType = self::class;

                return $dataEntry;
            }else{
                Logger::debug(self::class . " - End Of Alert File Reached Or An Error Has Occurred\n");
                return null;

            }

        }else{
            Logger::debug(self::class . " - Detected An Empty FullString. This Condition Should Not Occur. Error Has Potentialy Occurred\n");
            return null;
        }



    }
}