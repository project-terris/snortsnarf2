<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 30/03/16
 * Time: 5:33 PM
 */

/**
 * Class AlertFileFactory generates an IAlertFile based on the passed in fileDir. AlertFileFactory determines
 * what snort mode was used to generate the alert file and then returns the appropriate IAlertFile for that type
 */
class AlertFileFactory
{

    /**
     * getFile gets the passed in file and determines whether it is a FastAlertFile or a FullAlertFile and creates
     * the appropriate object before returning it for the designated file
     * @param $fileDir String - the directory to the alert file
     */
    public static function getFile($fileDir){

        //open the file
        $fp = fopen($fileDir, 'r');
        //initialize storage of complete entry
        $totalString = "";

        //get the first lines of the file
        $firstLine = fgets($fp);
        $totalString .= $firstLine;
        //search through until we have a string containing a complete log entry
        $nextLine = null;
        while(!self::containsACompleteEntry($totalString)){
            //doesn't contain a complete entry, so grab the next line and append it
            $nextLine = fgets($fp);
            $totalString .= $nextLine;
            //print("$totalString\n");
        }

        Logger::debug("AlertFileFactory - Completed Search. Found Complete Entry\n");
        Logger::debug(">$totalString<\n");

        //trim out the last entry because checker overshoots the entry into the next one
        $trimmedEntry = substr($totalString, 0, strpos($totalString, $nextLine));
        //clean the entry
        $trimmedEntry = str_replace("  "," ", $trimmedEntry);
        $trimmedEntry = str_replace("\n","", $trimmedEntry);

        Logger::debug("AlertFileFactory - Trimmed String:\n >$trimmedEntry<\n");

        //determine type and return cast to generic parent type
        if(self::isFastAlertFile($trimmedEntry)){
            Logger::debug("AlertFileFactory - Detected Entry Belongs To A Fast Alert File. Now Creating.\n");
            $fastAlertFile = new FastAlertFile();
            return self::toIAlertFile($fastAlertFile);
        }else if(self::isFullAlertFile($trimmedEntry)){
            Logger::debug("AlertFileFactory - Detected Entry Belongs To A Full Alert File. Now Creating.\n");
            $fullAlertFile = new FullAlertFile();
            return self::toIAlertFile($fullAlertFile);
        }

        throw new ReaderException("AlertFileFactory - Failed To Determine File Type From Parsed Content");
    }

    private static function isFastAlertFile($string){

        $classification = strpos($string, "Classification:");
        $priority = strpos($string, "Priority:");
        $protocol = preg_match("/\\{\\w+\\}/", $string);
        $iptransfer = preg_match("/\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}(\\s?\\-\\>\\s?|\\s?\\<\\-\\s?)\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}/", $string);

        return ($classification && $priority && $protocol & $iptransfer);
    }

    private static function isFullAlertFile($string){

        $classification = strpos($string, "Classification:");
        $priority = strpos($string, "Priority:");
        $ttl = strpos($string, "TTL:");
        $tos = strpos($string, "TOS:");
        $id = strpos($string, "ID:");
        $iplen = strpos($string, "IpLen:");
        $dgmlen = strpos($string, "DgmLen:");
        $len = strpos($string, "Len:");
        $iptransfer = preg_match("/\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\:\\d{1,5}(\\s?\\-\\>\\s?|\\s?\\<\\-\\s?)\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\:\\d{1,5}/", $string);

        return ($classification && $priority && $ttl && $tos && $id && $iplen && $dgmlen && $len && $iptransfer);

    }

    private static function containsACompleteEntry($string){

        $firstSeperator = strpos($string, "[**]");
        if($firstSeperator === false){

            return false;
        }else{
            $secondSeperator = strpos($string, "[**]", $firstSeperator + 4);
            if($secondSeperator === false){
                return false;
            }else{
                $thirdSeperator = strpos($string, "[**]", $secondSeperator + 4);
                if($thirdSeperator === false){
                    return false;
                }else{
                    return true;
                }
            }
        }


    }

    private static function toIAlertFile(IAlertFile $object){
        return $object;
    }
}