<?php

namespace Thw\Xsl\Runner;

include_once(__DIR__.'/../src/Engine.php');

class EngineTest extends \PHPUnit_Framework_TestCase {

  /**
  * @covers \Thw\Xsl\Runner\Engine::processor
  */
  public function testProcessorGetAfterSet() {
    $processor = $this->getProcessorFixture();
    $engine = new Engine();
    $this->assertSame($processor, $engine->processor($processor));
  }

  /**
  * @covers \Thw\Xsl\Runner\Engine::processor
  */
  public function testProcessorGetImplicitCreate() {
    $engine = new Engine();
    $this->assertInstanceOf(
      '\XsltProcessor', $engine->processor()
    );
  }

  /**
  * @covers \Thw\Xsl\Runner\Engine::run
  * @covers \Thw\Xsl\Runner\Engine::registerCallbacks
  */
  public function testRun() {
    $processor = $this->getProcessorFixture();
    $processor
      ->expects($this->once())
      ->method('registerPhpFunctions')
      ->with($this->isType('array'));
    $processor
      ->expects($this->once())
      ->method('importStylesheet')
      ->with($this->isInstanceOf('\DOMDocument'));
    $processor
      ->expects($this->once())
      ->method('transformToDoc')
      ->with($this->isInstanceOf('\DOMDocument'))
      ->will($this->returnValue(new \DOMDocument()));
    $engine = new Engine();
    $engine->processor($processor);
    $this->assertInstanceOf(
      '\DOMDocument', $engine->run(new \DOMDocument(), new \DOMDocument())
    );
  }

  /****************
  * Fixtures
  ****************/

  public function getProcessorFixture() {
    $processor = $this->getMock(
      '\XsltProcessor',
      array('importStylesheet', 'transformToDoc', 'registerPhpFunctions')
    );
    return $processor;
  }
}