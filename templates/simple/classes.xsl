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

<xsl:import href="prototype.xsl"/>

<xsl:template name="class-index">
  <xsl:param name="classIndex" />
  <xsl:variable name="consoleOutput" select="cxr:console-write('Generating class index')"/>
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

<xsl:template name="file-class">
  <xsl:param name="fileName" />
  <xsl:param name="className" />
  <xsl:variable name="file" select="cxr:load-document($fileName)/pdox:file"/>
  <xsl:variable name="class" select="$file//pdox:class[@full = $className]"/>
  <xsl:variable name="target" select="concat('target://', cxr:filename-of-class($class/@full))"/>
  <xsl:variable name="path" select="cxr:string-repeat('../', cxr:substring-count($class/@full, '\'))"/>
  <xsl:variable name="namespace" select="$class/parent::pdox:namespace/@name"/>
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
        <xsl:with-param name="title" select="$class/@full"/>
        <xsl:with-param name="path" select="$path"/>
      </xsl:call-template>
      <body>
        <xsl:call-template name="page-header"/>
        <div class="navigation">
          <xsl:call-template name="navigation">
            <xsl:with-param name="selected" select="$class/@full"/>
            <xsl:with-param name="path" select="$path"/>
          </xsl:call-template>
        </div>
        <div class="content">
          <h2 class="className">
            <xsl:call-template name="namespace-ariadne">
              <xsl:with-param name="namespace" select="$namespace"/>
              <xsl:with-param name="path" select="$path"/>
            </xsl:call-template>
            <xsl:if test="string($namespace) != ''">
              <xsl:text>\</xsl:text>
            </xsl:if>
            <xsl:value-of select="@name"/>
          </h2>
          <xsl:call-template name="class-prototype">
            <xsl:with-param name="class" select="$class"/>
            <xsl:with-param name="namespace" select="$class/@namespace"/>
            <xsl:with-param name="path" select="$path"/>
          </xsl:call-template>
          <p>
            <xsl:value-of select="$class/pdox:docblock/pdox:description/@compact"/>
          </p>
          <xsl:call-template name="file-class-methods">
            <xsl:with-param name="methods" select="$class/pdox:method"/>
            <xsl:with-param name="fileName" select="$fileName"/>
            <xsl:with-param name="namespace" select="$namespace"/>
            <xsl:with-param name="path" select="$path"/>
          </xsl:call-template>
        </div>
        <xsl:call-template name="page-footer"/>
      </body>
    </html>
  </exsl:document>
</xsl:template>

<xsl:template name="file-class-methods">
  <xsl:param name="methods"/>
  <xsl:param name="fileName"/>
  <xsl:param name="path"></xsl:param>
  <xsl:param name="namespace"></xsl:param>
  <xsl:for-each select="$methods">
    <xsl:sort select="@name"/>
    <div class="method">
      <h3><xsl:value-of select="@name"/></h3>
      <p><xsl:value-of select="pdox:docblock/pdox:description/@compact"/></p>
      <xsl:call-template name="function-prototype">
        <xsl:with-param name="function" select="."/>
        <xsl:with-param name="file" select="$fileName"/>
        <xsl:with-param name="path" select="$path"/>
        <xsl:with-param name="namespace" select="$namespace"/>
      </xsl:call-template>
    </div>
  </xsl:for-each>
</xsl:template>

</xsl:stylesheet>
