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
class Pathmapper {

  const CREATE_DIRECTORIES = 1;

  const WRITE_FILES = 2;

  /**
  * directory mapping
  *
  * @var array(string=>string)
  */
  private static $_paths = array();

  public static function register($protocol, $path, $options = 0) {
    self::$_paths[$protocol] = array(
      'path' => $path,
      'options' => $options
    );
    stream_wrapper_register($protocol, __CLASS__);
  }

  public function get($path) {
    $protocol = substr($path, 0, strpos($path, '://'));
    return self::$_paths[$protocol];
  }

  public function clear() {
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