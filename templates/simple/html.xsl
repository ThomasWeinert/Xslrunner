<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  
<xsl:template name="html-head">
  <xsl:param name="title"></xsl:param>
  <head>
    <title><xsl:value-of select="$title"/></title>
    <link rel="stylesheet" type="text/css" href="files/style.css"/>
  </head>
</xsl:template>  

<xsl:template name="page-header">
  <div class="pageHeader">
    <h1>
      <xsl:choose>
        <xsl:when test="/project/title and protect/title != ''">
          <xsl:copy-of select="/project/title/node()"/>
        </xsl:when>
        <xsl:otherwise>
          Documentation
        </xsl:otherwise>
      </xsl:choose>
    </h1>
  </div>
</xsl:template>

<xsl:template name="page-footer">
  <div class="pageFooter">
    <xsl:text> </xsl:text>
  </div>
</xsl:template>
  
</xsl:stylesheet>