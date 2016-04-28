<?php
/**
 * User: Sean
 * Date: 16/04/16
 *
 * This is a prototype script that will parse fast snort alert files into a alert object
 */

require_once "Alert.php";

//These are the separator stings that separate the alert file fields
const DATE_TIME_SEPARATOR = "-";
const TIME_RULE_SIG_SEPARATOR = "  [**] [";
const RULE_SIG_RULE_STRING_SEPARATOR = "] ";
const RULE_STRING_CLASSIFICATION_SEPARATOR = " [**] [Classification: ";
const CLASSIFICATION_PRIORITY_SEPARATOR = "] [Priority: ";
const PRIORITY_PROTOCOL_SEPARATOR = "] {";
const PROTOCOL_SRC_IP_SEPARATOR = "} ";
const SRC_IP_DST_IP_SEPARATOR = " -> ";
const DST_IP_END_LINE_SEPARATOR = "\n";

class fast_parser
{
    private $alertFilePath;
    private $alertFilePointer;

    function __construct($alertFilePath)
    {
        $this->alertFilePath = $alertFilePath;
        $this->alertFilePointer = fopen($alertFilePath, "r");
    }

    function start()
    {
        $line = null;
        $alerts = null;

        for($i = 0; !feof($this->alertFilePointer); $i++) //Read the entire alert file line by line
        {
            $line = fgets($this->alertFilePointer); //Get a single line from the alert file
            if(strlen($line) == 0) //If the line has no contents skip it
                continue;

            $alerts[$i] = $this->parseAlertLine($line); //Parse the line
        }

        var_dump($alerts); //Dump contents of all the read alerts
    }

    /**
     * This will take a fast alert file line and parse out the components of it
     * @param $line
     * @return Alert
     */
    private function parseAlertLine($line)
    {
        $dateStamp = "";
        $timeStamp = "";
        $ruleSignature = "";
        $ruleString = "";
        $classification = "";
        $priority = "";
        $protocol = "";
        $srcIP = "";
        $dstIP = "";

        $parseSegment = 0; //This is the segment of the line that is currently being parsed out
        for($i = 0; $i < strlen($line); $i++) //Go through the line char by char
        {
            $char = $line[$i];
            switch ($parseSegment) { //Each case of the switch is a part of the line that is being parsed out
                case 0: //Case for getting the date stamp segment
                    $separator = DATE_TIME_SEPARATOR; //Set the separator for the current component
                    if ($char == $separator[0]) { //Checks the character is the same as the first of the separator
                        if (substr($line, $i, strlen($separator)) == $separator) { //Checks to see if the rest of the separator is the same
                            $i += (strlen($separator) - 1); //Moves $i past the separator
                            $parseSegment++; //Moves to parsing the next segment
                            continue;
                        }
                    }
                    $dateStamp .= $char; //Concatenates the char onto the segment string it is building
                    break;
                case 1: //Case for getting the time stamp segment
                    $separator = TIME_RULE_SIG_SEPARATOR;
                    if ($char == $separator[0]) {
                        if (substr($line, $i, strlen($separator)) == $separator) {
                            $i += (strlen($separator) - 1);
                            $parseSegment++;
                            continue;
                        }
                    }
                    $timeStamp .= $char;
                    break;
                case 2: //Case for getting the rule signature segment
                    $separator = RULE_SIG_RULE_STRING_SEPARATOR;
                    if ($char == $separator[0]) {
                        if (substr($line, $i, strlen($separator)) == $separator) {
                            $i += (strlen($separator) - 1);
                            $parseSegment++;
                            continue;
                        }
                    }
                    $ruleSignature .= $char;
                    break;
                case 3: //Case for getting the rule string segment
                    $separator = RULE_STRING_CLASSIFICATION_SEPARATOR;
                    if ($char == $separator[0]) {
                        if (substr($line, $i, strlen($separator)) == $separator) {
                            $i += (strlen($separator) - 1);
                            $parseSegment++;
                            continue;
                        }
                    }
                    $ruleString .= $char;
                    break;
                case 4: //Case for getting the classification segment
                    $separator = CLASSIFICATION_PRIORITY_SEPARATOR;
                    if ($char == $separator[0]) {
                        if (substr($line, $i, strlen($separator)) == $separator) {
                            $i += (strlen($separator) - 1);
                            $parseSegment++;
                            continue;
                        }
                    }
                    $classification .= $char;
                    break;
                case 5: //Case for getting the priority segment
                    $separator = PRIORITY_PROTOCOL_SEPARATOR;
                    if ($char == $separator[0]) {
                        if (substr($line, $i, strlen($separator)) == $separator) {
                            $i += (strlen($separator) - 1);
                            $parseSegment++;
                            continue;
                        }
                    }
                    $priority .= $char;
                    break;
                case 6: //Case for getting the protocol segment
                    $separator = PROTOCOL_SRC_IP_SEPARATOR;
                    if ($char == $separator[0]) {
                        if (substr($line, $i, strlen($separator)) == $separator) {
                            $i += (strlen($separator) - 1);
                            $parseSegment++;
                            continue;
                        }
                    }
                    $protocol .= $char;
                    break;
                case 7: //Case for getting the SRC IP segment
                    $separator = SRC_IP_DST_IP_SEPARATOR;
                    if ($char == $separator[0]) {
                        if (substr($line, $i, strlen($separator)) == $separator) {
                            $i += (strlen($separator) - 1);
                            $parseSegment++;
                            continue;
                        }
                    }
                    $srcIP .= $char;
                    break;
                case 8: //Case for getting the DST IP segment
                    $separator = DST_IP_END_LINE_SEPARATOR;
                    if ($char == $separator[0]) {
                        if (substr($line, $i, strlen($separator)) == $separator) {
                            $i += (strlen($separator) - 1);
                            $parseSegment++;
                            continue;
                        }
                    }
                    $dstIP .= $char;
                    break;
            }
        }

        return $alertObj = new Alert($dateStamp, $timeStamp, $ruleSignature, $ruleString, $classification, $priority, $protocol, $srcIP, $dstIP); //Creates the alert object
    }

    /**
     * Debugging function to nicely print a variable then kill the program
     * @param $var
     */
    private function ddie($var)
    {
        echo("<pre>");
        var_dump($var);
        echo("</pre>");
        die;
    }
}