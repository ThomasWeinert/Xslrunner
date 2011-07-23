<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:php="http://php.net/xsl"
  xmlns:exsl="http://exslt.org/common"
  xmlns:func="http://exslt.org/functions"
  xmlns:pdox="http://xml.phpdox.de/src#"                
  extension-element-prefixes="php exsl func">

<func:function name="func:load-document">
  <xsl:param name="url"/>
  <func:result select="php:function('\Carica\Xsl\Runner\XsltCallback', 'LoadDocument', $url)"/>
</func:function>

</xsl:stylesheet>