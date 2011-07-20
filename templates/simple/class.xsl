<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:exsl="http://exslt.org/common"
  xmlns:func="http://exslt.org/functions"
  xmlns:pdox="http://xml.phpdox.de/src#"                
  extension-element-prefixes="exsl func">
  
<xsl:template name="file-class">
  <xsl:param name="fileName" />
  <xsl:variable name="file" select="func:load-document($fileName)/pdox:file"/>
  <xsl:variable name="target" select="concat('target://class.', $file/pdox:class/@full, '.xhtml')"/>
  <document source="{$fileName}" />
  <exsl:document
    href="{$target}"
    method="xml" 
    encoding="utf-8" 
    standalone="yes" 
    doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" 
    doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" 
    indent="yes" 
    omit-xml-declaration="yes">
    <html>
      <xsl:call-template name="html-head">
        <xsl:with-param name="title" select="$file/pdox:class/@full"/>
      </xsl:call-template>
      <body>
         <div class="navigation">
           <xsl:call-template name="navigation-classes">
             <xsl:with-param name="selectedClass" select="$file/pdox:class/@full"/>
           </xsl:call-template>
         </div>
         <div class="content">
           <h1 class="className"><xsl:value-of select="$file/pdox:class/@full"/></h1>
           <p>
             <xsl:value-of select="$file/pdox:class/pdox:docblock/pdox:description/@compact"/>
           </p>
           <xsl:call-template name="file-class-methods">
             <xsl:with-param name="methods" select="$file/pdox:class/pdox:method"/>
           </xsl:call-template>
         </div>
         <xsl:call-template name="page-footer"/>
      </body>
    </html>
  </exsl:document>
</xsl:template>

<xsl:template name="file-class-methods">
  <xsl:param name="methods"/>
  <xsl:for-each select="$methods">
    <xsl:sort select="@name"/>
    <div class="method">
      <h3><xsl:value-of select="@name"/></h3>
      <p><xsl:value-of select="pdox:docblock/pdox:description/@compact"/></p>
    </div>
  </xsl:for-each>
</xsl:template>
  
</xsl:stylesheet>