<?php
require('../lib/AutoLoader.php');
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 24/02/16
 * Time: 1:51 PM
 */
class ArgParcerTests extends PHPUnit_Framework_TestCase
{

    public function testFormatArgumentsAssertEmpty()
    {
        $response = ArgParcer::formatArguments(Array());

        $this->assertEmpty($response);
    }

    public function testFormatArgumentsAssertNotEmpty(){

        $parameters = Array("programNAme","-a","value", "-b", "value2");

        $response = ArgParcer::formatArguments($parameters);

        $this->assertNotEmpty($response);
    }

    public function testGetInstanceAssertInstanceOf(){

        $instance = ArgParcer::getInstance(Array());

        $this->assertInstanceOf("ArgParcer", $instance);
    }
}
