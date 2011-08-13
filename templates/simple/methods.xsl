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

<xsl:template name="file-methods">
  <xsl:param name="methods"/>
  <xsl:param name="fileName"/>
  <xsl:param name="path"></xsl:param>
  <xsl:param name="namespace"></xsl:param>
  <xsl:if test="count($methods) &gt; 0">
    <h3>Methods</h3>
    <xsl:for-each select="$methods">
      <xsl:sort select="@name"/>
      <div class="method">
        <h4><xsl:value-of select="@name"/></h4>
        <xsl:call-template name="function-prototype">
          <xsl:with-param name="function" select="."/>
          <xsl:with-param name="file" select="$fileName"/>
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

</xsl:stylesheet>