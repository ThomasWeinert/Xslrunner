<?php

namespace Carica\Xsl\Runner {

  include_once(__DIR__.'/bootstrap.php');

  class EngineTest extends \PHPUnit_Framework_TestCase {

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

    public function testXsltCallbackUsingInvoke() {
      $this->assertEquals(
        'success',  Engine::xsltCallback('CallbackSample', 'success')
      );
    }

    public function testXsltCallbackWithMethod() {
      $this->assertEquals(
        '"success"',  Engine::xsltCallback('CallbackSample::other', 'success')
      );
    }

    public function testXsltCallbackWithInvalidClassExpectingException() {
      $this->setExpectedException(
        'LogicException',
        'Class "\Carica\Xsl\Runner\Callback\CallbackInvalidSample"'.
        ' does not implement the callback interface.'
      );
      Engine::xsltCallback('CallbackInvalidSample::other');
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
}

namespace Carica\Xsl\Runner\Callback {

  use Carica\Xsl\Runner as Runner;

  class CallbackSample implements Runner\Callback {
    public function __invoke($text) {
      return $text;
    }

    public function other($text, $quotes = '"') {
      return $quotes.$text.$quotes;
    }
  }

  class CallbackInvalidSample {
  }
}