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
  public function execute(array $arguments = NULL) {
    $this->options()->process($arguments);
    if ($this->options()->helpOptionSet()) {
      $this->showUsage();
      return;
    }

    $directoryXml = Directory::cleanup($this->options()->getOption('xml')->value);
    $directoryOutput = Directory::cleanup($this->options()->getOption('output')->value);
    $templateFile = $this->options()->getOption('template')->value;

    Streamwrapper\PathMapper::register(
      'source',
      $directoryXml
    );
    Streamwrapper\PathMapper::register(
      'target',
      $directoryOutput,
      Streamwrapper\PathMapper::CREATE_DIRECTORIES | Streamwrapper\PathMapper::WRITE_FILES
    );
    $directory = new \Carica\Xsl\Runner\Directory();
    if (file_exists($directoryOutput.'index.html')) {
      $directory->remove($directoryOutput);
    }
    $directory->copy(dirname($templateFile).'/files/', $directoryOutput.'/files/');
    $project = new \Carica\Xsl\Runner\Project();
    $project->render($templateFile);
  }

  /**
  * Show console help
  */
  public function showUsage() {
    echo $this->options()->getHelpText(
      "\nCarica XslRunner for phpDox version 0.1 alpha", 72, TRUE
    );
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
      $options->registerOption($helpOption = new \ezcConsoleOption('h', 'help'));
      $helpOption->longhelp = 'Show this output.';
      $helpOption->isHelpOption = TRUE;
      $options->registerOption(
        new \ezcConsoleOption(
          'x',
          'xml',
          \ezcConsoleInput::TYPE_STRING,
          './xml/',
          FALSE,
          'source directory',
          'Source directory containing the xml files.'
        )
      );
      $options->registerOption(
        new \ezcConsoleOption(
          'o',
          'output',
          \ezcConsoleInput::TYPE_STRING,
          './xhtml/',
          FALSE,
          'output directory',
          'Output directory for the generated files.'
        )
      );
      $options->registerOption(
        new \ezcConsoleOption(
          't',
          'template',
          \ezcConsoleInput::TYPE_STRING,
          './templates/simple/start.xsl',
          FALSE,
          'xslt template',
          'Xslt template file to use.'
        )
      );
      $this->_options = $options;
    }
    return $this->_options;
  }
}