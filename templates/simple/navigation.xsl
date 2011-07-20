<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:exsl="http://exslt.org/common"
  xmlns:pdox="http://xml.phpdox.de/src#"
  extension-element-prefixes="exsl">

<xsl:template name="navigation-classes">
  <xsl:param name="selectedClass"></xsl:param>
  <ul>
    <xsl:for-each select="$CLASSES">
      <xsl:sort select="@full"/>
      <li>
        <xsl:if test="$selectedClass = @full">
          <xsl:attribute name="class">selected</xsl:attribute>
        </xsl:if>
        <a href="class.{@full}.xhtml"><xsl:value-of select="@full"/></a>
      </li>
    </xsl:for-each>
  </ul>
</xsl:template>

<xsl:template name="navigation-interfaces">
  <ul>
    <xsl:for-each select="$INTERFACES">
      <li><a href="class.{@full}.xhtml"><xsl:value-of select="@full"/></a></li>
    </xsl:for-each>
  </ul>
</xsl:template>
  
</xsl:stylesheet>