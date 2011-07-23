<?php

namespace Carica\Xsl\Runner\Streamwrapper;

use \Carica\Xsl\Runner as Runner;

include_once(__DIR__.'/../TestCase.php');

class PathMapperTest extends Runner\TestCase {

  /**
  * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::register
  */
  public function testRegister() {
    PathMapper::register('sample', __DIR__.'/TestData');
    $this->assertContains('sample', stream_get_wrappers());
    stream_wrapper_unregister('sample');
  }

  /**
  * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::get
  */
  public function testGetWithPathAfterRegister() {
    PathMapper::register('sample', __DIR__.'/TestData');
    $this->assertEquals(
      array(
        'options' => 0,
        'path' => __DIR__.'/TestData'
      ),
      PathMapper::get('sample://')
    );
    stream_wrapper_unregister('sample');
  }

  /**
  * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::get
  */
  public function testGetWithProtocolAfterRegister() {
    PathMapper::register('sample', __DIR__.'/TestData');
    $this->assertEquals(
      array(
        'options' => 0,
        'path' => __DIR__.'/TestData'
      ),
      PathMapper::get('sample')
    );
    stream_wrapper_unregister('sample');
  }

  /**
  * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::get
  */
  public function testGetWithUnknownProtocol() {
    $this->assertNull(
      PathMapper::get('INVALID_PROTOCOL')
    );
  }

  /**
  * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::register
  */
  public function testClear() {
    PathMapper::register('sample', __DIR__.'/TestData');
    PathMapper::clear();
    $this->assertNotContains('sample', stream_get_wrappers());
  }
}