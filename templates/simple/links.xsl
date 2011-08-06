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

<xsl:param name="OUTPUT_EXTENSION">.html</xsl:param>

<func:function name="cxr:filename-of-type">
  <xsl:param name="type"/>
  <xsl:param name="path"></xsl:param>
  <xsl:param name="namespace"></xsl:param>
  <func:result>
    <xsl:choose>
      <xsl:when test="$CLASSES//pdox:class[concat('\', @full) = $type]">
        <xsl:value-of select="cxr:filename-of-class(substring($type, 2), $path)"/>
      </xsl:when>
      <xsl:when test="$CLASSES//pdox:class[concat($namespace, '\', @name) = $type]">
        <xsl:value-of select="cxr:filename-of-class($type, $path)"/>
      </xsl:when>
      <xsl:when test="(string($namespace) = '') and $CLASSES/pdox:class[@full = $type]">
        <xsl:value-of select="cxr:filename-of-class($type, $path)"/>
      </xsl:when>
    </xsl:choose>
  </func:result>
</func:function>

<func:function name="cxr:filename-of-class">
  <xsl:param name="class"/>
  <xsl:param name="path"></xsl:param>
  <xsl:variable name="href">
    <xsl:value-of select="$path"/>
    <xsl:text>classes/</xsl:text>
    <xsl:value-of select="$class"/>
    <xsl:value-of select="$OUTPUT_EXTENSION"/>
  </xsl:variable>
  <func:result select="translate($href, '\', '/')"/>
</func:function>

<func:function name="cxr:filename-of-namespace">
  <xsl:param name="namespace"/>
  <xsl:param name="path"></xsl:param>
  <xsl:variable name="href">
    <xsl:value-of select="$path"/>
    <xsl:text>classes</xsl:text>
    <xsl:value-of select="$OUTPUT_EXTENSION"/>
    <xsl:text>#ns\</xsl:text>
    <xsl:value-of select="$namespace"/>
  </xsl:variable>
  <func:result select="translate($href, '\', '/')"/>
</func:function>

</xsl:stylesheet>