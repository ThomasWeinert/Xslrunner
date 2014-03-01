<?php

namespace Carica\Xsl\Runner\Callback {

  use \Carica\Xsl\Runner as Runner;

  include_once(__DIR__.'/../bootstrap.php');

  class TypeStringTest extends \PHPUnit_Framework_TestCase {

    /**
    * @covers \Carica\Xsl\Runner\Callback\LoadDocument
    * @dataProvider provideStringAndXml
    */
    public function testInvoke($typeString, $expectedXml) {
      $callback = new TypeString();
      /** @var \DOMDocument $doc */
      $doc = $callback($typeString);
      $this->assertEquals(
        $expectedXml,
        $doc->saveXml($doc->documentElement)
      );
    }

    public static function provideStringAndXml() {
      return array(
        array(
          'array',
          '<variable-type>'.
            '<type>array</type>'.
          '</variable-type>'
        ),
        array(
          'array|NULL',
          '<variable-type>'.
            '<type>array</type>'.
            '<text>|</text>'.
            '<type>NULL</type>'.
          '</variable-type>'
        ),
        array(
          'array(string=>integer,...)',
          '<variable-type>'.
            '<type>array</type>'.
            '<text>(</text>'.
            '<type>string</type>'.
            '<text>=&gt;</text>'.
            '<type>integer</type>'.
            '<text>,...)</text>'.
            '<type></type>'.
          '</variable-type>'
        )
      );
    }
  }
}