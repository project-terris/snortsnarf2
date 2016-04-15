<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 14/04/16
 * Time: 8:22 PM
 */
 abstract class CommonAlertFile
{
     protected $fileDir;
     protected $fp;

    protected function __construct($fileDir, $childClassName){

        if(file_exists($fileDir) && is_file($fileDir)){

            $this->fileDir = $fileDir;

            if(is_readable($this->fileDir)){
                $this->fp = fopen($fileDir, 'r');
            }else{
                throw new ReaderException("CommonAlertFile ($childClassName) - File Passed In Constructor Is Not Readable ($fileDir)");
            }

        }else{
            throw new ReaderException("CommonAlertFile ($childClassName) - File Passed In Constructor Not Found ($fileDir)");
        }
    }

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

     protected function cleanAlertFileEntry($string){

         $trimmedEntry = str_replace("  "," ", $string);
         $trimmedEntry = str_replace("\n","", $trimmedEntry);

         return $trimmedEntry;
     }

}