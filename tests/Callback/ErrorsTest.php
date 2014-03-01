<?php

namespace Carica\Xsl\Runner\Callback {

  use \Carica\Xsl\Runner as Runner;

  include_once(__DIR__.'/../bootstrap.php');

  class ErrorsTest extends \PHPUnit_Framework_TestCase {

    public function tearDown() {
      $errors = new Errors();
      $errors->clear();
    }

    /**
    * @covers Carica\Xsl\Runner\Callback\Errors
    */
    public function testStore() {
      $errors = new Errors();
      $errors->store('error', 'Error Message', 'ClassOne');
      $dom = $errors->get();
      $this->assertEquals(
        '<errors xmlns="http://thomas.weinert.info/carica/xr">'.
          '<error severity="error" group="ClassOne">Error Message</error>'.
        '</errors>',
        $dom->saveXml($dom->documentElement)
      );
    }

    /**
    * @covers Carica\Xsl\Runner\Callback\Errors
    */
    public function testStoreIsStatic() {
      $errors = new Errors();
      $errors->store('error', 'Error Message', 'ClassOne');
      $errors = new Errors();
      $errors->store('warning', 'Warning Message', 'ClassTwo');
      $dom = $errors->get();
      $this->assertEquals(
        '<errors xmlns="http://thomas.weinert.info/carica/xr">'.
          '<error severity="error" group="ClassOne">Error Message</error>'.
          '<error severity="warning" group="ClassTwo">Warning Message</error>'.
        '</errors>',
        $dom->saveXml($dom->documentElement)
      );
    }
  }
}