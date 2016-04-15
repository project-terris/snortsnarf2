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
     * @return IAlertFile - An alert file parser upcasted to the parent type
     * @throws ReaderException - thrown when getFile fails to determine what the source file type is
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

    /**
     * isFastAlertFile determines if the passed in string representing a cleaned entry meets criteria to be a fast alert
     * file
     * @param $string String - a cleaned snort log file entry
     * @return bool - status as to whether the string belongs to a fast alert file. TRUE if it is, FALSE if not
     */
    private static function isFastAlertFile($string){

        $classification = strpos($string, "Classification:");
        $priority = strpos($string, "Priority:");
        $protocol = preg_match("/\\{\\w+\\}/", $string);
        $iptransfer = preg_match("/\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}(\\s?\\-\\>\\s?|\\s?\\<\\-\\s?)\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}/", $string);

        return ($classification && $priority && $protocol & $iptransfer);
    }

    /**
     * isFullAlertFile determines if the passed in string representing a cleaned entry meets the criteria to be a fast alert
     * file log entry
     * @param $string String - a cleaned snort log file entry
     * @return bool - status as to whether the string belongs to a full alert file. TRUE if it is, FALSE if not
     */
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

    /**
     * containsACompleteEntry determines from the passed in string whether it contains all content to be equivalent to 1
     * entry in any generated alert file from snort. Note if there is more then one entry, this function will also return
     * true. containsACompleteEntry only ensures the minimum of one entry is present in the passed in string
     * @param $string String - contents of a snort alert file that may contain a single entry
     * @return bool - status as to whether the passed in string does contain a snort alert file entry. TRUE if it does,
     * FALSE if it does not
     */
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

    /**
     * toIAlertFile converts the passed in object to the generic parent type so that the client has an
     * abstract interface to interact with the alert file regardless of what type it is
     * @param IAlertFile $object - the object being upcasted
     * @return IAlertFile - the passed in object, upcasted as an IAlertFile
     */
    private static function toIAlertFile(IAlertFile $object){
        return $object;
    }
}