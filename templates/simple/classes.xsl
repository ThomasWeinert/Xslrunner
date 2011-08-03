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

<xsl:template name="class-index">
  <xsl:param name="classIndex" />
  <xsl:variable name="consoleOutput" select="cxr:console-echo('&#10;Generating class index&#10;')"/>
  <exsl:document
    href="target://classes.html"
    method="xml"
    encoding="utf-8"
    standalone="yes"
    doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
    doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
    indent="yes"
    omit-xml-declaration="yes">
    <html>
      <xsl:call-template name="html-head">
        <xsl:with-param name="title">Class Index</xsl:with-param>
      </xsl:call-template>
      <body>
        <xsl:call-template name="page-header"/>
        <div class="content">
          <xsl:call-template name="class-list">
            <xsl:with-param name="classes" select="$classIndex/pdox:class"/>
          </xsl:call-template>
          <xsl:for-each select="$classIndex/pdox:namespace">
            <xsl:sort select="@name"/>
            <xsl:call-template name="class-list">
              <xsl:with-param name="classes" select="pdox:class"/>
              <xsl:with-param name="namespace" select="@name"/>
            </xsl:call-template>
          </xsl:for-each>
        </div>
        <xsl:call-template name="page-footer"/>
      </body>
    </html>
  </exsl:document>
</xsl:template>

<xsl:template name="class-list">
  <xsl:param name="classes"/>
  <xsl:param name="namespace"></xsl:param>
  <xsl:if test="$namespace != ''">
    <h2 id="ns/{translate($namespace, '\', '/')}"><xsl:value-of select="$namespace" /></h2>
  </xsl:if>
  <xsl:if test="count($classes) &gt; 0">
    <ul>
      <xsl:for-each select="$classes">
        <xsl:sort select="@name"/>
        <li><a href="{cxr:filename-of-class(./@full)}"><xsl:value-of select="@name" /></a></li>
      </xsl:for-each>
    </ul>
  </xsl:if>
</xsl:template>

</xsl:stylesheet>
