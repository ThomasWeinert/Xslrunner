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
  * wrapper class name including namespace
  *
  * @var string
  */
  protected static $_class = __CLASS__;

  /**
  * directory mapping and options
  *
  * @var array(string=>array())
  */
  private static $_paths = array();

  /**
  * openend file resource
  *
  * @var resource|NULL
  */
  private $_handle = NULL;

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
    stream_wrapper_register($protocol, static::$_class);
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
  public static function getFileName($path) {
    $mapping = self::get($path);
    $fileName = $mapping['path'].substr($path, strpos($path, '://') + 3);
    return str_replace('%5C', '/', $fileName);
  }

  protected function handle($handle = NULL) {
    if (isset($handle)) {
      $this->_handle = $handle;
    }
    return $this->_handle;
  }

  public function stream_open($path, $mode, $options, &$openedPath) {
    $handle = $this->handle(
      fopen(
        self::getFileName($path), $mode, $options
      )
    );
    return is_resource($handle);
  }

  public function stream_close() {
    return fclose($this->handle());
  }

  public function stream_read($count) {
    return fread($this->handle(), $count);
  }

  public function stream_write($data) {
    return fwrite($this->handle(), $data);
  }

  public function stream_tell() {
    return ftell($this->handle());
  }

  public function stream_eof() {
    return feof($this->handle());
  }

  public function stream_seek($offset, $whence) {
    return fseek($this->handle(), $offset, $whence);
  }

  public function stream_stat() {
    return fstat($this->handle());
  }

  public function url_stat($path, $flags) {
    return stat(self::getFileName($path));
  }
}