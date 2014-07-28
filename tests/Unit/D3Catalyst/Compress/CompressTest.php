<?php 

/**
*  Corresponding Class to test Compress class.
*
*
*  @author Ricardo Madrigal <dev@d3catalyst.com>
*/
class CompressTest extends PHPUnit_Framework_TestCase{
	
  /**
  * Just check if the YourClass has no syntax error. 
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
  public function testIsThereAnySyntaxError(){
  	$var = new D3Catalyst\Compress\Compress;
  	$this->assertTrue(is_object($var));
  	unset($var);
  }
  
  
  /**
  * JPG Optimization test
  */
  public function testJpgSingleCompress(){
  	$var = new D3Catalyst\Compress\Compress;
    $var->unit_test(true);
  	$this->assertTrue($var->jpg("jpgs/jpg1.jpg") !== false);
  	unset($var);
  }

  /**
  * PNG Optimization test
  */
  public function testPngSingleCompress(){
    $var = new D3Catalyst\Compress\Compress;
    $var->unit_test(true);
    $this->assertTrue($var->png("pngs/png1.png") !== false);
    unset($var);
  }

  /**
  * Css Optimization test
  */
  public function testCssSingleCompress(){
    $var = new D3Catalyst\Compress\Compress;
    $var->unit_test(true);
    $this->assertTrue($var->css("csstest1.css") !== false);
    unset($var);
  }

  /**
  * Js Optimization test
  */
  public function testJsSingleCompress(){
    $var = new D3Catalyst\Compress\Compress;
    $var->unit_test(true);
    $this->assertTrue($var->js("jstest1.js") !== false);
    unset($var);
  }
  
}