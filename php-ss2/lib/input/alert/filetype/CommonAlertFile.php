<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 8:22 PM
 */

/**
 * Class CommonAlertFile is an abstract class that defines common helper functionality needed for reading an alert file.
 * It allows each alert file to share code between eachother who have near identical functionality
 */
 abstract class CommonAlertFile
{
     protected $fileDir;
     protected $fp;

    protected function __construct($fileDir, $childClassName){
        TypeValidator::isString($fileDir, false, true, new ReaderException("CommonAlertFile - Directory Passed Is Not A String"));

        if(FileValidator::isValidFile($fileDir)){

            $this->fileDir = $fileDir;

            if(FileValidator::isReadableFile($fileDir)){
                $this->fp = fopen($fileDir, 'r');
            }else{
                throw new ReaderException("CommonAlertFile ($childClassName) - File Passed In Constructor Is Not Readable ($fileDir)");
            }

        }else{
            throw new ReaderException("CommonAlertFile ($childClassName) - File Passed In Constructor Not Found Or Valid ($fileDir)");
        }
    }

     /* -- DEPRECATED -- */
     private final function findLastSlash($fileDir){

         $lastSlash = strrpos($fileDir, "/");
         if($lastSlash === false){
             $lastSlash = strrpos($fileDir, "\\");
             if($lastSlash === false){
                 throw new ReaderException("CommonAlertFile - Failed To Determine Position Of Last Slash ($fileDir)");
             }else{
                 return $lastSlash;
             }
         }else{
             return $lastSlash;
         }

     }

     /* -- DEPRECATED -- */
     private final function createEditableCopy(){

         $fileName = substr($this->fileDir, $this->findLastSlash($this->fileDir), strlen($this->fileDir));
         $directory = substr($this->fileDir, 0, $this->findLastSlash($this->fileDir)+1);
         $newCopyName = $directory . "_" . $fileName;

         copy($this->fileDir, $newCopyName);

         if(chmod($newCopyName, 777) == false){
             throw new ReaderException("CommonAlertFile - Failed To Set Alert File Copy To Editable Mode ($newCopyName)");
         }


         return $newCopyName;

     }

     /**
      * containsACompleteEntry determines from the passed in string whether it contains all content to be equivalent to 1
      * entry in any generated alert file from snort. Note if there is more then one entry, this function will also return
      * true. containsACompleteEntry only ensures the minimum of one entry is present in the passed in string
      * @param $string String - contents of a snort alert file that may contain a single entry
      * @return bool - status as to whether the passed in string does contain a snort alert file entry. TRUE if it does,
      * FALSE if it does not
      */
     protected function containsACompleteEntry($string){
         TypeValidator::isString($string, false, true, new ReaderException("CommonAlertFile - Alert File Entry Passed Is Not A String"));

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
      * cleanAlertFileEntry is a helper method that cleans the passed in alert file entry from \n and double spaces in
      * the alert entry
      * @param $string - the alert file entry
      * @return String - the cleaned alert file entry
      * @throws ReaderException - Thrown when the passed in parameter is not a string
      */
     protected function cleanAlertFileEntry($string){
         TypeValidator::isString($string, false, true, new ReaderException("CommonAlertFile - Alert File Entry Passed Is Not A String"));

         $trimmedEntry = str_replace("  "," ", $string);
         $trimmedEntry = str_replace("\n","", $trimmedEntry);

         return $trimmedEntry;
     }

}