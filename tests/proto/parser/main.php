<?php
require_once "fast_parser.php";
/**
 * Created by PhpStorm.
 * User: sean
 *
 * main entry point for testing parsers
 */

$data = file_get_contents("./../../../docs/snortsamples/snort-fast-alert.txt");
$fast_parser = new fast_parser("./../../../docs/snortsamples/snort-fast-alert.txt");
$fast_parser->start();