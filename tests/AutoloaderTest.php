<?php

namespace Carica\Xsl\Runner;

include_once(__DIR__.'/../src/Autoloader.php');

class AutoloaderTest extends \PHPUnit_Framework_TestCase {

  /**
  * @covers \Carica\Xsl\Runner\Autoloader::load
  */
  public function testLoadExpectingTrue() {
    $this->assertTrue(Autoloader_TestProxy::load(''));
  }

  /**
  * @covers \Carica\Xsl\Runner\Autoloader::load
  */
  public function testLoadExpectingFalse() {
    $this->assertFalse(Autoloader::load('DOMDocument'));
  }

  /**
  * @covers \Carica\Xsl\Runner\Autoloader::getFile
  */
  public function testGetFileExpectingFile() {
    $this->assertStringEndsWith(
      'Engine.php',
      Autoloader::getFile(__NAMESPACE__.'\\Engine')
    );
  }

  /**
  * @covers \Carica\Xsl\Runner\Autoloader::getFile
  */
  public function testGetFileExpectingNull() {
    $this->assertNull(
      Autoloader::getFile('\\stdClass')
    );
  }
}

class Autoloader_TestProxy extends Autoloader {

  public static function getFile($class) {
    return __DIR__.'/TestData/class.php';
  }
}