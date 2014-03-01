<?php

namespace Carica\Xsl\Runner\Streamwrapper {

  use \Carica\Xsl\Runner as Runner;

  include_once(__DIR__.'/../bootstrap.php');

  class PathMapperTest extends \PHPUnit_Framework_TestCase {

    public function tearDown() {
      if (in_array('sample', stream_get_wrappers())) {
        stream_wrapper_unregister('sample');
      }
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::register
    */
    public function testRegister() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $this->assertContains('sample', stream_get_wrappers());
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::get
    */
    public function testGetWithPathAfterRegister() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $this->assertEquals(
        array(
          'options' => 0,
          'path' => __DIR__.'/TestData/'
        ),
        PathMapper::get('sample://')
      );
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::get
    */
    public function testGetWithProtocolAfterRegister() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $this->assertEquals(
        array(
          'options' => 0,
          'path' => __DIR__.'/TestData/'
        ),
        PathMapper::get('sample')
      );
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
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::clear
    */
    public function testClear() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      PathMapper::clear();
      $this->assertNotContains('sample', stream_get_wrappers());
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::stream_open
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::stream_close
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::handle
    */
    public function testStreamOpenAndClose() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $fh = fopen('sample://sample.txt', 'r');
      $this->assertInternalType('resource', $fh);
      fclose($fh);
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::stream_read
    */
    public function testStreamRead() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $this->assertEquals('SUCCESS', file_get_contents('sample://sample.txt'));
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::stream_write
    */
    public function testStreamWrite() {
      PathMapper_TestProxy::register('sample', __DIR__.'/TestData/');
      $fh = fopen('sample://sample-write.txt', 'w+');
      fwrite($fh, 'OK FAILED');
      fseek($fh, 0, SEEK_SET);
      $this->assertEquals('OK', fread($fh, 2));
      fclose($fh);
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::stream_tell
    */
    public function testStreamTell() {
      PathMapper_TestProxy::register('sample', __DIR__.'/TestData/');
      $fh = fopen('sample://sample-write.txt', 'w+');
      fwrite($fh, 'ok');
      $this->assertEquals(2, ftell($fh));
      fclose($fh);
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::stream_seek
    */
    public function testStreamSeek() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $fh = fopen('sample://sample.txt', 'r');
      fseek($fh, 3);
      $this->assertEquals('CESS', fread($fh, 255));
      fclose($fh);
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::stream_eof
    */
    public function testStreamEof() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $fh = fopen('sample://sample.txt', 'r');
      $this->assertFalse(feof($fh));
      fread($fh, 255);
      $this->assertTrue(feof($fh));
      fclose($fh);
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::stream_stat
    */
    public function testStreamStat() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $fh = fopen('sample://sample.txt', 'r');
      $this->assertInternalType('array', fstat($fh));
      fclose($fh);
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::url_stat
    */
    public function testUrlStat() {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $this->assertInternalType('array', stat('sample://sample.txt'));
    }

    /**
    * @covers \Carica\Xsl\Runner\Streamwrapper\PathMapper::getFileName
    * @dataProvider provideFileUris
    */
    public function testGetFileName($expected, $path) {
      PathMapper::register('sample', __DIR__.'/TestData/');
      $this->assertEquals(
        __DIR__.'/TestData/'.$expected, PathMapper::getFileName($path)
      );
    }

    /*******************
    * Data Provider
    *******************/

    public static function provideFileUris() {
      return array(
        array('file.xml', 'sample://file.xml'),
        array('directory/file.xml', 'sample://directory/file.xml')
      );
    }
  }

  class PathMapper_TestProxy extends PathMapper {

    protected static $_class = __CLASS__;

    public function stream_open($path, $mode, $options, &$openedPath) {
      return is_resource($this->handle(fopen('php://memory', $mode)));
    }
  }
}