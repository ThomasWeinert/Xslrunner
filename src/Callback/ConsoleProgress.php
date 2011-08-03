<?php
/**
* Xslt Callback object. This output a dot, the dots are counted and a number and a linebreak are
* added regulary.
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
class ConsoleProgress implements Runner\Callback  {

  private static $_dotCounter = 0;

  private static $_lineCounter = 0;

  private static $_lineLength = '72';

  private static $_endPattern = " [%s]\n";

  private static $_maximum = 0;

  /**
  * Output given arguments
  *
  * @param array $arguments
  */
  public function execute(array $arguments) {
    $reset = isset($arguments[0]) ? (boolean)$arguments[0] : FALSE;
    if ($reset) {
      self::$_maximum = isset($arguments[1]) ? (int)$arguments[1] : 0;
      self::$_dotCounter = 0;
      self::$_lineCounter = 0;
      echo "\n";
    }
    $numberLength = strlen(self::$_maximum);
    $lineLength = self::$_lineLength - 4;
    if (self::$_maximum > 0) {
      $lineLength -= $numberLength * 2;
    }
    echo '.';
    self::$_dotCounter++;
    if (self::$_dotCounter >= $lineLength) {
      $position = self::$_lineCounter * self::$_dotCounter + self::$_dotCounter;
      self::$_lineCounter++;
      self::$_dotCounter = 0;

      $positionString = str_pad($position, $numberLength, ' ', STR_PAD_LEFT);
      if (self::$_maximum > 0) {
        $positionString .= '/'.(int)self::$_maximum;
      }
      printf(self::$_endPattern, $positionString);
    }
  }
}