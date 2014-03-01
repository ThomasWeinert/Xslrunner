<?php

require(__DIR__.'/vendor/autoload.php');

try {
  $runner = new \Carica\Xsl\Runner\Runner();
  $runner->execute();
  exit(0);
} catch (ezcConsoleOptionException $e) {
  echo $e->getMessage();
  $runner->options()->process(array('-h'));
  exit(1);
}