<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns="http://www.w3.org/1999/xhtml/"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:pdox="http://xml.phpdox.de/src#"
  xmlns:cxr="http://thomas.weinert.info/carica/xr"
  exclude-result-prefixes="#default pdox cxr">

<xsl:template name="navigation-classes">
  <xsl:param name="selected"></xsl:param>
  <xsl:param name="path"></xsl:param>
  <ul>
    <xsl:for-each select="$CLASSES">
      <xsl:sort select="@full"/>
      <li>
        <xsl:if test="$selected = @full">
          <xsl:attribute name="class">selected</xsl:attribute>
        </xsl:if>
        <xsl:variable name="fileName" select="cxr:filename-of-class(., $path)"/>
        <a href="{$fileName}"><xsl:value-of select="@name"/></a>
      </li>
    </xsl:for-each>
  </ul>
</xsl:template>
  
</xsl:stylesheet>