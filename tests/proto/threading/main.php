<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 15/04/16
 * Time: 5:51 PM
 */

require_once("./ParcerThread.php");
require_once("./EntryQueue.php");

$entryQueue = new EntryQueue();
$parserThread = new ParcerThread($entryQueue);


