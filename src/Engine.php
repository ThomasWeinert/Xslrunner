<?php
/**
* Encapsulates the xsl processor and provides callback functions useable from the xsl.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Carica\Xsl\Runner;

/**
* Encapsulates the xsl processor and provides callback functions useable from the xsl.
*
* @package XslRunner
*/
class Engine {

  /**
  * Xsl processor object from ext/xsl
  *
  * @var \XsltProcessor
  */
  private $_processor = NULL;

  /**
  * Getter/Setter for the xslt processor. If it is created implicit, the callback functions are
  * defined.
  *
  * @param \XsltProcessor $processor
  */
  public function processor(\XsltProcessor $processor = NULL) {
    if (isset($processor)) {
      $this->_processor = $processor;
    } elseif (is_null($this->_processor)) {
      $this->_processor = new \XsltProcessor;
      if (method_exists($this->_processor, 'setSecurityPrefs')) {
        $this->_processor->setSecurityPrefs(
          XSL_SECPREF_READ_FILE &
          XSL_SECPREF_WRITE_FILE &
          XSL_SECPREF_CREATE_DIRECTORY
        );
      }
    }
    return $this->_processor;
  }

  /**
  * Run xsl on given xml using the xslt processor.
  *
  * @param \DOMDocument $xml
  * @param \DOMDocument $xsl
  * @param \DOMDocument
  */
  public function run($xml, $xsl) {
    $this->registerCallbacks();
    $this->processor()->importStylesheet($xsl);
    return $this->processor()->transformToDoc($xml);
  }

  /**
  * Register the php function callbacks.
  */
  private function registerCallbacks() {
    $this->processor()->registerPHPFunctions(
      array(
        '\\'.__NAMESPACE__.'\\Engine::xsltCallback'
      )
    );

  }

  /**
  * Callback called from xslt
  *
  * @param string $name
  * @return mixed
  */
  public static function xsltCallback($name) {
    $callback = self::getCallback($name);
    $arguments = func_get_args();
    array_shift($arguments);
    return call_user_func_array($callback, $arguments);
  }

  /**
  * Convert given callback name into a php callback variable.
  *
  * @param callback|null $name
  */
  private static function getCallback($name) {
    $class = '\\'.__NAMESPACE__.'\\Callback\\'.$name;
    if (FALSE !== ($offset = strpos($class, '::'))) {
      $method = substr($class, $offset + 2);
      $class = substr($class, 0, $offset);
    } else {
      $method = '__invoke';
    }
    if (!class_exists($class)) {
      throw new \LogicException(
        sprintf('Class "%s" does not exists.', $class)
      );
    }
    $instance = new $class;
    if (!($instance instanceOf Callback)) {
      throw new \LogicException(
        sprintf('Class "%s" does not implement the callback interface.', $class)
      );
    }
    if (!method_exists($instance, $method)) {
      throw new \LogicException(
        sprintf(
          'Callback class "%s" does not implement method "%s".', $class, $method
        )
      );
    }
    return array($instance, $method);
  }
}