<?php
require_once('./lib/AutoLoader.php');

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 22/02/16
 * Time: 4:06 PM
 */

/**
 * ROOTDIR is a constant that defines the root directory so that all classes in snortsnarf2 can create absolute directories
 */
define('__ROOTDIR__', __DIR__);

/**
 * displayVersion displays version information for snortsnarf2
 */
function displayVersion(){
    $ini = parse_ini_file(__DIR__ . "/app.ini");
    print($ini['app_name'] . " Version: " . $ini['app_version'] . "\n");
}

/**
 * displayHelp displays basic help information for snortsnarf2
 */
function displayHelp(){
    print("Please see Github Wiki Page for Help: https://github.com/project-terris/snortsnarf2/wiki\n");
}


/**
 * main entrance point to the snortsnarf2 program
 * @param $argc Int - the number of parameters passed
 * @param $argv Array - the parameters passed
 * @return int - the status of the program. 0 means successful, 1 means error
 */
function main($argc, $argv){

    $startTime = time();
    //parse out arguments passed
    $formattedArguments = ArgParcer::formatArguments($argv);
    $arguments = ArgParcer::getInstance($formattedArguments);

    if($arguments->getValue(PARAMETERKEYS::VERSION)){
        displayVersion();
        return 0;
    }

    if($arguments->getValue(PARAMETERKEYS::HELP)){
        displayHelp();
        return 0;
    }

    //setup logger
    Logger::setLogger($arguments->getFlags());
    //Logger::debug($formattedArguments);

    //determine writing location / output type
    $outputQueue = new OutputQueue();
    $outputDestination = WriterFactory::determineOutput($arguments, $outputQueue);

    //determine reading location / input type
    $entryToParseQueue = new EntryQueue();
    $dataSource = ReaderFactory::determineSource($arguments);

    //start the output thread
    $outputDestination->start();

    //determine how many parser threads were making
    $numberOfParserThreads = $arguments->getValue(PARAMETERKEYS::PARSERTHREADS);
    if($numberOfParserThreads == null){
        $numberOfParserThreads = 3;
    }

    print("HERE");

    $allThreads = array();
    //now start creating threads
    for($i = 0; $i < $numberOfParserThreads; $i++){
        //print("NOW HERE");
        $flags = Logger::getFlags();
        //var_dump($flags);
        $parcerThread = new ParcerThread($entryToParseQueue, $outputQueue, get_class($outputDestination), $flags);
        $allThreads[] = $parcerThread;
    }

    //tell threads to begin executing
    foreach($allThreads as $thread){
        $thread->start();
    }

    //now start getting each entry and putting them into the EntryQueue
    $count = 0;
    while(($entry = $dataSource->getNextEntry()) != null){
        $count++;
        Logger::debug(" " . Thread::getCurrentThreadId() . " - Adding Entry $count\n");
        $entryToParseQueue->setUnsortedAlert($entry);
    }

    $endTime = time();
    Logger::benchmark("Total Execution Time On Main Thread: " . ($endTime - $startTime) . " second(s)\n");

    return 0;
}
exit(main($argc, $argv));