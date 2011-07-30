<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:exsl="http://exslt.org/common"
  xmlns:func="http://exslt.org/functions"
  xmlns:pdox="http://xml.phpdox.de/src#"                
  extension-element-prefixes="exsl func">

<!-- callback definitions -->
<xsl:import href="callbacks.xsl"/>

<!-- default templates to use and maybe overload -->
<xsl:import href="html.xsl"/>

<xsl:import href="class.xsl"/>
<xsl:import href="navigation.xsl"/>

<xsl:output 
  method="xml" 
  encoding="utf-8" 
  standalone="yes" 
  indent="yes" 
  omit-xml-declaration="no" />

<!-- define data variables -->
<xsl:variable name="CLASSES" select="document('source://classes.xml')/pdox:classes/pdox:class"/>
<xsl:variable name="INTERFACES" select="document('source://interfaces.xml')/pdox:interfaces/pdox:interface"/>

<xsl:template match="/">	
  <result>
    <xsl:call-template name="classes" />
    <classes count="{count($CLASSES)}"/>
    <interfaces count="{count($INTERFACES)}"/>
  </result>
</xsl:template>

<xsl:template name="classes">
  <xsl:for-each select="$CLASSES">
    <xsl:variable name="fileName" select="concat('source://', @xml)"/>
    <file src="{$fileName}"><xsl:value-of select="@full"/></file>
    <xsl:call-template name="file-class">
      <xsl:with-param name="fileName" select="$fileName"/>
    </xsl:call-template>
  </xsl:for-each>
</xsl:template>

</xsl:stylesheet>