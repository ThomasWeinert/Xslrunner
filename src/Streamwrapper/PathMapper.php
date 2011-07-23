<?php
/**
* A php streamwrapper that uses base directories based on a mapping with the registered
* wrapper name.
*
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
* @copyright Copyright (c) 2011 Thomas Weinert
*
* @package XslRunner
*/

namespace Carica\Xsl\Runner\Streamwrapper;

/**
* A php streamwrapper that uses base directories based on a mapping with the registered
* wrapper name.
*
* @package XslRunner
*/
class PathMapper {

  /**
  * Allow streamwrapper to create directories
  *
  * @var integer
  */
  const CREATE_DIRECTORIES = 1;

  /**
  * Allow streamwrapper to write files (not only read them)
  *
  * @var integer
  */
  const WRITE_FILES = 2;

  /**
  * directory mapping and options
  *
  * @var array(string=>array())
  */
  private static $_paths = array();

  /**
  * Register protocol with mapping for streamwrapper
  *
  * @param string $protocol
  * @param string $path
  * @param integer $options
  * @return array|NULL
  */
  public static function register($protocol, $path, $options = 0) {
    self::$_paths[$protocol] = array(
      'path' => $path,
      'options' => $options
    );
    stream_wrapper_register($protocol, __CLASS__);
  }

  /**
  * Get path mapping for path or protocol
  *
  * @param string $path
  * @return array|NULL
  */
  public static function get($path) {
    $offset = strpos($path, '://');
    $protocol = (FALSE !== $offset) ? substr($path, 0, $offset) : $path;
    return isset(self::$_paths[$protocol]) ? self::$_paths[$protocol] : NULL;
  }

  /**
  * Unregister stream protocols and remove mappings
  */
  public static function clear() {
    foreach (self::$_paths as $protocol => $data) {
      stream_wrapper_unregister($protocol);
      unset(self::$_paths[$protocol]);
    }
  }

  /**
  * file handler
  *
  * @var resource
  */
  private $_fh = NULL;

  public function stream_open($path, $mode, $options, &$openedPath) {
    $this->_fh = fopen(
      $this->getFileName($path), $mode
    );
    return is_resource($this->_fh);
  }

  public function stream_read($count) {
    return fread($this->_fh, $count);
  }

  public function stream_write($data) {
    return fwrite($this->_fh, $data);
  }

  function stream_tell() {
    return ftell($this->_fh);
  }

  function stream_eof() {
    return feof($this->_fh);
  }

  function stream_seek($offset, $whence) {
    return fseek($this->_fh, $offset, $whence);
  }

  function stream_stat() {
    return fstat($this->_fh);
  }

  function url_stat($path, $flags) {
    return stat($this->getFileName($path));
  }

  private function getFileName($path) {
    $mapping = self::get($path);
    $fileName = $mapping['path'].substr($path, strpos($path, '://') + 3);
    return str_replace('%5C', '/', $fileName);
  }
}