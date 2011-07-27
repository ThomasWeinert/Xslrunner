<?php
/**
* Autoloader for the Xsl\Runner
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Carica\Xsl\Runner;

/**
* Autoloader for the Xsl\Runner
*
* @package XslRunner
*/
class Autoloader {

  /**
  * Autoload function
  *
  * @param string $class
  */
  public static function load($class) {
    if ($file = static::getFile($class)) {
      include($file);
      return TRUE;
    }
    return FALSE;
  }

  /**
  * get filename if it is part of the current namespace (or a subnamespace)
  *
  * @param string|NULL $class
  */
  public static function getFile($class) {
    if (0 === strpos($class, __NAMESPACE__)) {
      return __DIR__.str_replace(
        '\\', DIRECTORY_SEPARATOR, substr($class, strlen(__NAMESPACE__))
      ).'.php';
    }
    return NULL;
  }
}