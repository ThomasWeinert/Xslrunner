<?php

namespace Carica\Xsl\Runner\Callback {

  use \Carica\Xsl\Runner as Runner;

  include_once(__DIR__.'/../bootstrap.php');

  class ConsoleTest extends \PHPUnit_Framework_TestCase {

    /**
    * @covers \Carica\Xsl\Runner\Callback\Console\progress
    * @covers \Carica\Xsl\Runner\Callback\Console\setLineLength
    */
    public function testProgressWithTwoDotsInTwoLines() {
      $callback = new Console();
      $callback->setLineLength(7);
      ob_start();
      $callback->progress(TRUE, 2);
      $callback->progress(FALSE, 2);
      $this->assertEquals(
        "\n. [1/2]\n. [2/2]\n",
        ob_get_clean()
      );
    }

    /**
    * @covers \Carica\Xsl\Runner\Callback\Console\writeLine
    */
    public function testWriteLineWithLinebreak() {
      $callback = new Console();
      ob_start();
      $callback->writeLine('success');
      $this->assertEquals(
        "success\n",
        ob_get_clean()
      );
    }

    /**
    * @covers \Carica\Xsl\Runner\Callback\Console
    */
    public function testWriteLineWithoutLinebreak() {
      $callback = new Console();
      ob_start();
      $callback->writeLine('success', FALSE);
      $this->assertEquals(
        "success",
        ob_get_clean()
      );
    }
  }
}