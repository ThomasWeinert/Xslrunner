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

<xsl:template name="interface-index">
  <xsl:param name="interfaceIndex" />
  <xsl:variable name="consoleOutput" select="cxr:console-write('Generating interface index')"/>
  <exsl:document
    href="target://interfaces.html"
    method="xml"
    encoding="utf-8"
    standalone="yes"
    doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
    doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
    indent="yes"
    omit-xml-declaration="yes">
    <html>
      <xsl:call-template name="html-head">
        <xsl:with-param name="title">Interface Index</xsl:with-param>
      </xsl:call-template>
      <body>
        <xsl:call-template name="page-header"/>
        <div class="content">
          <xsl:call-template name="interface-list">
            <xsl:with-param name="interfaces" select="$interfaceIndex/pdox:interface"/>
          </xsl:call-template>
          <xsl:for-each select="$interfaceIndex/pdox:namespace">
            <xsl:sort select="@name"/>
            <xsl:call-template name="interface-list">
              <xsl:with-param name="interfaces" select="pdox:interface"/>
              <xsl:with-param name="namespace" select="@name"/>
            </xsl:call-template>
          </xsl:for-each>
        </div>
        <xsl:call-template name="page-footer"/>
      </body>
    </html>
  </exsl:document>
</xsl:template>

<xsl:template name="interface-list">
  <xsl:param name="interfaces"/>
  <xsl:param name="namespace"></xsl:param>
  <xsl:if test="$namespace != ''">
    <h2 id="ns/{translate($namespace, '\', '/')}"><xsl:value-of select="$namespace" /></h2>
  </xsl:if>
  <xsl:if test="count($interfaces) &gt; 0">
    <ul>
      <xsl:for-each select="$interfaces">
        <xsl:sort select="@name"/>
        <li><a href="{cxr:filename-of-interface(./@full)}"><xsl:value-of select="@name" /></a></li>
      </xsl:for-each>
    </ul>
  </xsl:if>
</xsl:template>

<xsl:template name="file-interface">
  <xsl:param name="fileName" />
  <xsl:param name="interfaceName" />
  <xsl:variable name="file" select="cxr:load-document($fileName)/pdox:file"/>
  <xsl:variable name="interface" select="$file//pdox:interface[@full = $interfaceName]"/>
  <xsl:variable name="target" select="concat('target://', cxr:filename-of-interface($interface/@full))"/>
  <xsl:variable name="path" select="cxr:string-repeat('../', cxr:substring-count($interface/@full, '\'))"/>
  <xsl:variable name="namespace" select="$interface/parent::pdox:namespace/@name"/>
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
        <xsl:with-param name="title" select="$interface/@full"/>
        <xsl:with-param name="path" select="$path"/>
      </xsl:call-template>
      <body>
        <xsl:call-template name="page-header"/>
        <div class="navigation">
          <xsl:call-template name="navigation">
            <xsl:with-param name="selected" select="$interface/@full"/>
            <xsl:with-param name="path" select="$path"/>
          </xsl:call-template>
        </div>
        <div class="content">
          <h2 class="interfaceName">
            <xsl:call-template name="namespace-ariadne">
              <xsl:with-param name="namespace" select="$interface/@namespace"/>
              <xsl:with-param name="path" select="$path"/>
            </xsl:call-template>
            <xsl:if test="string($interface/@namespace) != ''">
              <xsl:text>\</xsl:text>
            </xsl:if>
            <xsl:value-of select="@name"/>
          </h2>
          <xsl:call-template name="interface-prototype">
            <xsl:with-param name="interface" select="$interface"/>
            <xsl:with-param name="namespace" select="$interface/@namespace"/>
            <xsl:with-param name="path" select="$path"/>
          </xsl:call-template>
          <p>
            <xsl:value-of select="$interface/pdox:docblock/pdox:description/@compact"/>
          </p>
          <xsl:call-template name="file-interface-methods">
            <xsl:with-param name="methods" select="$interface/pdox:method"/>
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

<xsl:template name="file-interface-methods">
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
