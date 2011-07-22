<?php
/**
* Encapsulates the xsl processor and provides callback functions useable from the xsl.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Thw\Xsl\Runner;

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
      $this->_processor->registerPHPFunctions(
        array(
          '\\Thw\\Xsl\Runner\\loadXmlDocument'
        )
      );
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
    $this->processor()->importStylesheet($xsl);
    return $this->processor()->transformToDoc($xml);
  }
}

/**
* Callback for xsl: load an xml document
*
* @param string $url
* @return \DOMDocument
*/
function loadXmlDocument($url) {
  $dom = new \DOMDocument();
  $dom->load($url);
  return $dom;
}