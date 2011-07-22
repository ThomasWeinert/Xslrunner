<?php

namespace Carica\Xsl\Runner;

include_once(__DIR__.'/../src/Autoloader.php');
spl_autoload_register('\\'.__NAMESPACE__.'\\Autoloader::load');

class TestCase extends \PHPUnit_Framework_TestCase {

}