<?php

namespace Carica\Xsl\Runner\Callback {

  use \Carica\Xsl\Runner as Runner;

  include_once(__DIR__.'/../bootstrap.php');

  class LoadDocumentTest extends \PHPUnit_Framework_TestCase {

    /**
    * @covers \Carica\Xsl\Runner\Callback\LoadDocument
    */
    public function testExecute() {
      $callback = new LoadDocument();
      /** @var \DOMDocument $doc */
      $doc = $callback(__DIR__.'/TestData/simple.xml');
      $this->assertEquals(
        '<success/>',
        $doc->saveXml($doc->documentElement)
      );
    }
  }
}