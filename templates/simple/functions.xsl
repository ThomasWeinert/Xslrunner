<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:php="http://php.net/xsl"
  xmlns:func="http://exslt.org/functions"
  xmlns:pdox="http://xml.phpdox.de/src#"
  xmlns:cxr="http://thomas.weinert.info/carica/xr"
  extension-element-prefixes="php func pdox cxr">

<!-- 
  The default xpath "document()" function seems not to be able to be used with dynamic values read
  from other xml documents. So here is a callback function that just loads a dom.
-->
<func:function name="cxr:load-document">
  <xsl:param name="url"/>
  <func:result select="php:function('\Carica\Xsl\Runner\XsltCallback', 'LoadDocument', $url)"/>
</func:function>

<!-- 
  If a problem (missing documentation, inconsisty) is found, a message is stored using php.
-->
<func:function name="cxr:errors-store">
  <xsl:param name="severity"/>
  <xsl:param name="message"/>
  <xsl:param name="class"></xsl:param>
  <func:result
    select="php:function('\Carica\Xsl\Runner\XsltCallback', 'ErrorsStore', $severity, $message, $class)"
  />
</func:function>

<!-- 
  Return the stored error messages.
-->
<func:function name="cxr:errors">
  <func:result
    select="php:function('\Carica\Xsl\Runner\XsltCallback', 'ErrorsGet')"
  />
</func:function>

</xsl:stylesheet>