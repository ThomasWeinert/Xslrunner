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
        '\\'.__NAMESPACE__.'\\XsltCallback'
      )
    );
  }
}

/**
* Callback for xsl: load an xml document
*
* @param string $url
* @return \DOMDocument
*/
function XslTCallback($class) {
  $class = '\\'.__NAMESPACE__.'\\Callback\\'.$class;
  $callback = new $class();
  $arguments = func_get_args();
  array_shift($arguments);
  return $callback->execute($arguments);
}