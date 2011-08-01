<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns="http://www.w3.org/1999/xhtml/"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:pdox="http://xml.phpdox.de/src#"
  xmlns:cxr="http://thomas.weinert.info/carica/xr"
  exclude-result-prefixes="#default pdox cxr">

<!-- callback definitions -->
<xsl:import href="library/library.xsl"/>

<!-- default templates to use and maybe overload -->
<xsl:import href="html.xsl"/>

<xsl:import href="class.xsl"/>
<xsl:import href="classes.xsl"/>
<xsl:import href="links.xsl"/>
<xsl:import href="navigation.xsl"/>

<xsl:output 
  method="xml" 
  encoding="utf-8" 
  standalone="yes" 
  indent="yes" 
  omit-xml-declaration="no" />

<!-- define data variables -->
<xsl:variable name="CLASSES" select="document('source://classes.xml')/pdox:classes"/>

<xsl:template match="/">	
  <result>
    <xsl:call-template name="class-index">
      <xsl:with-param name="classIndex" select="$CLASSES"/>
    </xsl:call-template>
    <xsl:call-template name="classes">
      <xsl:with-param name="classIndex" select="$CLASSES"/>
    </xsl:call-template>
  </result>
</xsl:template>

<xsl:template name="classes">
  <xsl:param name="classIndex" />
  <xsl:for-each select="$classIndex//pdox:class">
    <xsl:variable name="fileName" select="concat('source://', @xml)"/>
    <file src="{$fileName}"><xsl:value-of select="@full"/></file>
    <xsl:call-template name="file-class">
      <xsl:with-param name="fileName" select="$fileName"/>
      <xsl:with-param name="className" select="@full"/>
    </xsl:call-template>
  </xsl:for-each>
</xsl:template>

</xsl:stylesheet>