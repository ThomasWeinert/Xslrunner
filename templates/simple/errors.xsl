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
  
<xsl:template name="file-errors">
  <xsl:param name="index" />
  <xsl:param name="fileName" />
  <xsl:param name="className" />
  <xsl:variable name="target" select="'target://errors.html'"/>
  <xsl:variable name="errors" select="cxr:errors()/cxr:errors/cxr:error"/>
  <xsl:variable name="errorsCount" select="count($errors)"/>
  <xsl:choose>
    <xsl:when test="$errorsCount &gt; 0">
      <exsl:document
        href="{$target}"
        method="xml"
        encoding="utf-8"
        standalone="yes"
        doctype-public="HTML"
        indent="no"
        omit-xml-declaration="yes">
        <html>
          <xsl:call-template name="html-head">
            <xsl:with-param name="title">Errors</xsl:with-param>
          </xsl:call-template>
          <body>
            <xsl:call-template name="page-header">
              <xsl:with-param name="title">Errors</xsl:with-param>
            </xsl:call-template>
            <div class="navigation">
              <xsl:call-template name="navigation"/>
            </div>
            <div class="pageBody">
              <div class="pageNavigation">
                <xsl:text> </xsl:text>
              </div>
              <div class="content">
                <xsl:for-each select="$errors">
                  <xsl:variable
                    name="consoleProgress" 
                    select="cxr:console-progress(position() = 1, $errorsCount)"/>
                  <div>
                    <xsl:attribute name="class">
                      <xsl:choose>
                        <xsl:when test="@severity = 'error'">messageError</xsl:when>
                        <xsl:when test="@severity = 'warning'">messageWarning</xsl:when>
                        <xsl:otherwise>messageInformation</xsl:otherwise>
                      </xsl:choose>
                    </xsl:attribute>
                    <h3><xsl:value-of select="@class"/></h3>
                    <p><xsl:value-of select="."/></p>
                  </div>
                </xsl:for-each>
                <xsl:text> </xsl:text>
              </div>
            </div>
            <xsl:call-template name="page-footer"/>
          </body>
        </html>
      </exsl:document>
      <xsl:variable name="consoleOutputDone" select="cxr:console-write('&#10;')"/>
    </xsl:when>
    <xsl:otherwise>
      <xsl:variable name="consoleOutput" select="cxr:console-write('No errors.')"/>
    </xsl:otherwise>
  </xsl:choose>
</xsl:template>

</xsl:stylesheet>