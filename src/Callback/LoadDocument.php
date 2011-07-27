<?php
/**
* Xslt Callback object. Create a new DOMDocument, load the given xml file and return the document.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Carica\Xsl\Runner\Callback;

use \Carica\Xsl\Runner as Runner;

/**
* Xslt Callback object. Create a new DOMDocument, load the given xml file and return the document.
*
* @package XslRunner
*/
class LoadDocument implements Runner\Callback  {

  /**
  * Create a new DOMDocument, load the given xml file and return the document.
  *
  * @param array $arguments
  * @return DOMDocument
  */
  public function execute(array $arguments) {
    $dom = new \DOMDocument();
    $dom->load($arguments[0]);
    return $dom;
  }
}