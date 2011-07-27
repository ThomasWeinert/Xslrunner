<?php
/**
* Interface definition for xsl callback classes. The callbacks can be executed from xslt
* using a generic registered php function.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Carica\Xsl\Runner;

/**
* Interface definition for xsl callback classes. The callbacks can be executed from xslt
* using a generic registered php function.
*
* @package XslRunner
*/
interface Callback {

  /**
  * Execute is called from the generic php callback function. The $arguments array contains all
  * parameters of the call.
  *
  * @param array $arguments
  * @return scalar|DOMNode
  */
  function execute(array $arguments);
}