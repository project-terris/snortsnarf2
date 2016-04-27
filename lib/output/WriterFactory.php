<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 10/04/16
 * Time: 1:48 PM
 */
class WriterFactory
{

    public static function determineOutput(ArgParcer $argument, OutputQueue $queue){

        //figure out how it is going there. Is this HTML out or SQL out ?
        $dbOutConnString = $argument->getValue(PARAMETERKEYS::DBOUTSTRING);
        if($dbOutConnString == null){
            Logger::debug("WriterFactory - Detected HTML Output Is Desired Output. Creating...\n");
            //assume were doing html out then

            //figure out where the content is going
            $outputLocation = $argument->getValue(PARAMETERKEYS::HTMLDESTDIR);
            if($outputLocation == null){
                Logger::debug("WriterFactory - An Output Folder Was Not Defined. Creating Default Output Location\n");
                if(!is_dir(__ROOTDIR__ . "/www")){
                    mkdir(__ROOTDIR__ . "/www");
                }

                $htmlWriter = new HTMLWriter($queue, Logger::getFlags());
                return $htmlWriter;

            }else{
                Logger::debug("WriterFactory - An Output Folder Was Defined. Verifying $outputLocation Exists and Creating It If It Doesn't\n");
                if(!is_dir($outputLocation)){
                    mkdir($outputLocation);
                }

                $htmlWriter = new HTMLWriter($queue, $outputLocation);
                return $htmlWriter;
            }


        }else{
            //we are doing db connection out
            throw new WriterException("WriterFactory - SQL Output Is Currently Not Supported. Please Try A Different Configuration");
        }


    }

    private static function toIWriter(IWriter $object){
        return $object;
    }
}