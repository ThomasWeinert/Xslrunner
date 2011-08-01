<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
  version="1.0" 
  xmlns="http://www.w3.org/1999/xhtml/"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:func="http://exslt.org/functions"
  xmlns:pdox="http://xml.phpdox.de/src#"
  xmlns:cxr="http://thomas.weinert.info/carica/xr"
  extension-element-prefixes="func"
  exclude-result-prefixes="#default pdox cxr">
  
<func:function name="cxr:filename-of-class">
  <xsl:param name="class"/>
  <xsl:param name="path"></xsl:param>
  <xsl:variable name="href">
    <xsl:value-of select="$path"/>
    <xsl:text>classes/</xsl:text>
    <xsl:value-of select="$class/@full"/>
    <xsl:text>.xhtml</xsl:text>
  </xsl:variable>
  <func:result select="$href"/>
</func:function>
  
</xsl:stylesheet>