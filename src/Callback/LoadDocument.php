<?php

namespace Carica\Xsl\Runner\Callback;

use \Carica\Xsl\Runner as Runner;

class LoadDocument implements Runner\Callback  {

  public function execute($arguments) {
    $dom = new \DOMDocument();
    $dom->load($arguments[0]);
    return $dom;
  }
}