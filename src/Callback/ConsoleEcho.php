<?php
/**
* Xslt Callback object. Just output the given string. This is used to show progress from xslt.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Carica\Xsl\Runner\Callback;

use \Carica\Xsl\Runner as Runner;

/**
* Xslt Callback object. Just output the given string. This is used to show progress from xslt.
*
* @package XslRunner
*/
class ConsoleEcho implements Runner\Callback  {

  /**
  * Output given arguments
  *
  * @param array $arguments
  */
  public function execute(array $arguments) {
    echo implode('', $arguments);
  }
}