<?php
namespace Carica\Xsl\Runner\Callback;

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