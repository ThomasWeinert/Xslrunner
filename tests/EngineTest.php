<?php

namespace Carica\Xsl\Runner;

include_once(__DIR__.'/TestCase.php');
include_once(__DIR__.'/TestData/callback.php');


class EngineTest extends TestCase {

  /**
  * @covers \Carica\Xsl\Runner\Engine::processor
  */
  public function testProcessorGetAfterSet() {
    $processor = $this->getProcessorFixture();
    $engine = new Engine();
    $this->assertSame($processor, $engine->processor($processor));
  }

  /**
  * @covers \Carica\Xsl\Runner\Engine::processor
  */
  public function testProcessorGetImplicitCreate() {
    $engine = new Engine();
    $this->assertInstanceOf(
      '\XsltProcessor', $engine->processor()
    );
  }

  /**
  * @covers \Carica\Xsl\Runner\Engine::run
  * @covers \Carica\Xsl\Runner\Engine::registerCallbacks
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

  public function testXsltCallback() {
    $this->assertEquals(
      'success',  XsltCallback('CallbackSample', 'success')
    );
  }

  /****************
  * Fixtures
  ****************/

  private function getProcessorFixture() {
    $processor = $this->getMock(
      '\\XsltProcessor',
      array('importStylesheet', 'transformToDoc', 'registerPhpFunctions')
    );
    return $processor;
  }
}