<?php

namespace Carica\Xsl\Runner\Callback;

use \Carica\Xsl\Runner as Runner;

include_once(__DIR__.'/../TestCase.php');

class ConsoleTest extends Runner\TestCase {

  /**
  * @covers \Carica\Xsl\Runner\Callback\Console
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