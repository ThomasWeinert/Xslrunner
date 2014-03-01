<?php

namespace Carica\Xsl\Runner {

  include_once(__DIR__.'/bootstrap.php');

  class ProjectTest extends \PHPUnit_Framework_TestCase {

    /**
    * @covers \Carica\Xsl\Runner\Project::engine
    */
    public function testEngineGetAfterSet() {
      $engine = $this->getEngineFixture();
      $project = new Project();
      $this->assertSame($engine, $project->engine($engine));
    }

    /**
    * @covers \Carica\Xsl\Runner\Project::engine
    */
    public function testEngineGetImplicitCreate() {
      $project = new Project();
      $this->assertInstanceOf('\Carica\Xsl\Runner\Engine', $project->engine());
    }

    /**
    * @covers \Carica\Xsl\Runner\Project::render
    */
    public function testRender() {
      $engine = $this->getEngineFixture();
      $engine
        ->expects($this->once())
        ->method('run')
        ->with($this->isInstanceOf('\\DOMDocument'), $this->isInstanceOf('\\DOMDocument'))
        ->will($this->returnValue($this->getResultDocumentFixture()));
      $project = new Project();
      $project->engine($engine);
      $result = $project->render(__DIR__.'/TestData/simple.xsl');
      $this->assertEquals(
        '<success/>', $result->saveXml($result->documentElement)
      );
    }

    /**
    * @covers \Carica\Xsl\Runner\Project::createDocument
    */
    public function testCreateDocument() {
      $project = new Project();
      $result = $project->createDocument();
      $this->assertEquals(
        '<project/>',
        $result->saveXml($result->documentElement)
      );
    }

    /****************
    * Fixtures
    ****************/

    private function getEngineFixture() {
      $engine = $this->getMock(
        '\\Carica\\Xsl\\Runner\\Engine',
        array('run')
      );
      return $engine;
    }

    private function getResultDocumentFixture() {
      $result = new \DOMDocument();
      $result->appendChild($result->createElement('success'));
      return $result;
    }
  }
}