<?php
/**
* Render a project of xml files using a xsl template.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Thw\Xsl\Runner;

require(__DIR__.'/Engine.php');
require(__DIR__.'/Project.php');
require(__DIR__.'/Streamwrapper/Pathmapper.php');

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
    stream_wrapper_register('source', '\\Thw\\Xsl\Runner\\Streamwrapper\\Pathmapper');
    stream_wrapper_register('target', '\\Thw\\Xsl\Runner\\Streamwrapper\\Pathmapper');
    \Thw\Xsl\Runner\Streamwrapper\Pathmapper::$paths = array(
      'source' => $this->options()->getOption('xml')->value,
      'target' => $this->options()->getOption('output')->value
    );
    $project = new \Thw\Xsl\Runner\Project();
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