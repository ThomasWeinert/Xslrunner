<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:exsl="http://exslt.org/common"
  xmlns:func="http://exslt.org/functions"
  xmlns:pdox="http://xml.phpdox.de/src#"                
  extension-element-prefixes="exsl func">
  
<xsl:template name="html-head">
  <xsl:param name="title"></xsl:param>
  <head>
    <title><xsl:value-of select="$title"/></title>
    <link rel="stylesheet" type="text/css" href="static/basic.css"/>
  </head>
</xsl:template>  

<xsl:template name="page-footer">
  <div class="pageFooter">
    FOOTER
  </div>
</xsl:template>
  
</xsl:stylesheet>