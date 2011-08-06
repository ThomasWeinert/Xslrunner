<?php

namespace Carica\Xsl\Runner\Callback;

use \Carica\Xsl\Runner as Runner;

include_once(__DIR__.'/../TestCase.php');

class LoadDocumentTest extends Runner\TestCase {

  /**
  * @covers \Carica\Xsl\Runner\Callback\LoadDocument::execute
  */
  public function testExecute() {
    $callback = new LoadDocument();
    $doc = $callback(__DIR__.'/TestData/simple.xml');
    $this->assertEquals(
      '<success/>',
      $doc->saveXml($doc->documentElement)
    );
  }
}