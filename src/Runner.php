<?php
/**
* Render a project of xml files using a xsl template.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Carica\Xsl\Runner;

include_once(__DIR__.'/Autoloader.php');
spl_autoload_register('\\'.__NAMESPACE__.'\\Autoloader::load');

/**
* Render a project of xml files using a xsl template.
*
* @package XslRunner
*/
class Runner {

  /**
  * console options
  * @var \ezcConsoleInput
  */
  private $_options = NULL;

  /**
  * Start runner
  */
  public function execute() {
    $this->options()->process();
    Streamwrapper\Pathmapper::register(
      'source',
      $this->options()->getOption('xml')->value
    );
    Streamwrapper\Pathmapper::register(
      'target',
      $this->options()->getOption('output')->value,
      Streamwrapper\Pathmapper::CREATE_DIRECTORIES | Streamwrapper\Pathmapper::WRITE_FILES
    );
    $project = new \Carica\Xsl\Runner\Project();
    $project->render($this->options()->getOption('template')->value);
  }

  /**
  * Getter/Setter for command line options object
  *
  * @param \ezcConsoleInput $options
  * @return \ezcConsoleInput
  */
  public function options(\ezcConsoleInput $options = NULL) {
    if (isset($options)) {
      $this->_options = $options;
    } elseif (is_null($this->_options)) {
      $options = new \ezcConsoleInput();
      $options->registerOption($option = new \ezcConsoleOption('h', 'help'));
      $option->isHelpOption = TRUE;
      $options->registerOption(
        new \ezcConsoleOption(
          'x',
          'xml',
          \ezcConsoleInput::TYPE_STRING,
          './xml/',
          FALSE,
          'source directory'
        )
      );
      $options->registerOption(
        new \ezcConsoleOption(
          'o',
          'output',
          \ezcConsoleInput::TYPE_STRING,
          './xhtml/',
          FALSE,
          'output directory'
        )
      );
      $options->registerOption(
        new \ezcConsoleOption(
          't',
          'template',
          \ezcConsoleInput::TYPE_STRING,
          './templates/simple/start.xsl',
          FALSE,
          'template file'
        )
      );
      $this->_options = $options;
    }
    return $this->_options;
  }
}