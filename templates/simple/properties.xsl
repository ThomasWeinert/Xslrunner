<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
  version="1.0"
  xmlns="http://www.w3.org/1999/xhtml/"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:exsl="http://exslt.org/common"
  xmlns:pdox="http://xml.phpdox.de/src#"
  xmlns:cxr="http://thomas.weinert.info/carica/xr"
  extension-element-prefixes="exsl"
  exclude-result-prefixes="#default pdox cxr">

<xsl:template name="file-properties">
  <xsl:param name="properties"/>
  <xsl:param name="fileName"/>
  <xsl:param name="path"></xsl:param>
  <xsl:param name="namespace"></xsl:param>
  <xsl:if test="count($properties) &gt; 0">
    <h3>Properties</h3>
    <xsl:for-each select="$properties">
      <xsl:sort select="@name"/>
      <div class="method">
        <h4>$<xsl:value-of select="@name"/></h4>
        <xsl:call-template name="prototype-property">
          <xsl:with-param name="property" select="."/>
          <xsl:with-param name="path" select="$path"/>
          <xsl:with-param name="namespace" select="$namespace"/>
        </xsl:call-template>
        <xsl:if test="pdox:docblock/pdox:description/@compact != ''">
          <p class="descriptionShort"><xsl:value-of select="pdox:docblock/pdox:description/@compact"/></p>
        </xsl:if>
      </div>
    </xsl:for-each>
  </xsl:if>
</xsl:template>

<xsl:template name="prototype-property">
  <xsl:param name="property"/>
  <xsl:param name="path"></xsl:param>
  <xsl:param name="namespace"></xsl:param>
  <xsl:variable name="name">
    <xsl:text>$</xsl:text>
    <xsl:value-of select="@name"/>
  </xsl:variable>
  <xsl:variable name="type">
    <xsl:choose>
      <xsl:when test="$property/pdox:docblock/pdox:var/@type != ''">
        <xsl:value-of select="$property/pdox:docblock/pdox:var/@type"/>
      </xsl:when>
    </xsl:choose>
  </xsl:variable>
  <xsl:variable name="isStatic" select="$property/@static = 'true'"/>
  <xsl:variable name="visibility" select="$property/@visibility"/>
  <div class="prototype property">
    <xsl:if test="$visibility or $isStatic">
      <ul class="properties">
        <li class="keyword"><xsl:value-of select="$visibility" /></li>
        <xsl:if test="$isStatic">
          <li class="keyword">static</li>
        </xsl:if>
      </ul>
    </xsl:if>
    <xsl:call-template name="variable">
      <xsl:with-param name="name" select="$name"/>
      <xsl:with-param name="type" select="$type"/>
      <xsl:with-param name="path" select="$path"/>
      <xsl:with-param name="namespace" select="$namespace"/>
    </xsl:call-template>
  </div>
</xsl:template>

</xsl:stylesheet>