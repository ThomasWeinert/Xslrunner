<?php
/**
* Represents a single project that should be rendered using xsl.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Thw\Xsl\Runner;

/**
* Represents a single project that should be rendered using xsl.
*
* @package XslRunner
*/
class Project {

  /**
  * Render engine
  * @var \Thw\Xsl\Runner\Engine
  */
  private $_engine = NULL;

  /**
  * Render project using given xsl template file.
  *
  * @param string $template
  */
  public function render($template) {
    $xsl = new \DOMDocument();
    $xsl->load($template);
    $xml =  $this->createDocument();
    $this->engine()->run($xml, $xsl);
  }

  /**
  * Getter/Setter for the renderer engine
  *
  * @param \Thw\Xsl\Runner\Engine $engine
  */
  public function engine(Engine $engine = NULL) {
    if (isset($engine)) {
      $this->_engine = $engine;
    } elseif (is_null($this->_engine)) {
      $this->_engine = new Engine;
    }
    return $this->_engine;
  }

  /**
  * Create dom document representing the project.
  *
  * @return DOMDocument $dom
  */
  private function createDocument() {
    $dom = new \DOMDocument();
    $dom->appendChild($dom->createElement('project'));
    return $dom;
  }
}