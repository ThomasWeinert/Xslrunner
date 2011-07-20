<?php

require('ezc/Base/base.php');
spl_autoload_register(array('ezcBase','autoload'));

require('src/Runner.php');

try {
  $runner = new \Thw\Xsl\Runner\Runner();
  $runner->execute();
  exit(0);
} catch (ezcConsoleOptionException $e) {
  echo $e->getMessage();
  $runner->options()->process(array('-h'));
  exit(1);
}