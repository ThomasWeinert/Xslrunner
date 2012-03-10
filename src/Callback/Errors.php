<?php
/**
* Xslt Callback object. Collect and return errors.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Carica\Xsl\Runner\Callback;

use \Carica\Xsl\Runner as Runner;

/**
* Xslt Callback object. Collect and return errors.
*
* This is used to collect documentation errors like missing docblocks.
*
* @package XslRunner
*/
class Errors implements Runner\Callback {

  const CXR_NAMESPACE = 'http://thomas.weinert.info/carica/xr';

  private static $_errors = NULL;

  public function store($severity, $message, $class) {
    $this->initialize();
    self::$_errors->documentElement->appendChild(
      $error = self::$_errors->createElementNS(
        self::CXR_NAMESPACE, 'error'
      )
    );
    $error->setAttribute('severity', (string)$severity);
    $error->setAttribute('class', (string)$class);
    $error->appendChild(
      self::$_errors->createTextNode((string)$message)
    );
  }

  public function get() {
    $this->initialize();
    return self::$_errors;
  }

  public function clear() {
    self::$_errors = NULL;
  }

  private function initialize() {
    if (is_null(self::$_errors)) {
      self::$_errors = new \DOMDocument();
      self::$_errors->appendChild(
        self::$_errors->createElementNS(
          self::CXR_NAMESPACE,
          'errors'
        )
      );
    }
  }

}