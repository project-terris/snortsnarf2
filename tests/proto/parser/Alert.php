<?php
/**
 * Created by PhpStorm.
 * User: sean
 * Date: 16/04/16
 * Time: 10:42 AM
 */

class Alert
{
    //Field for fast and full alert file
    private $dateStamp;
    private $timeStamp;
    private $ruleSignature;
    private $ruleString;
    private $classification;
    private $priority;
    private $protocol;
    private $srcIP;
    private $dstIP;

    //Fields for full alert file
    private $ttl;
    private $tos;
    private $ID;
    private $ipLen;
    private $dgmLen;
    private $len;

    function __construct($dateStamp, $timeStamp, $ruleSignature, $ruleString, $classification, $priority, $protocol, $srcIP, $dstIP)
    {
        $this->dateStamp = $dateStamp;
        $this->timeStamp = $timeStamp;
        $this->ruleSignature = $ruleSignature;
        $this->ruleString = $ruleString;
        $this->classification = $classification;
        $this->priority = $priority;
        $this->protocol = $protocol;
        $this->srcIP = $srcIP;
        $this->dstIP = $dstIP;
    }

    function addFullAlertValues()
    {

    }
}