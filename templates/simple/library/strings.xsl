<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:func="http://exslt.org/functions"
  xmlns:cxr="http://thomas.weinert.info/carica/xr"
  extension-element-prefixes="func"
  exclude-result-prefixes="cxr">

<func:function name="cxr:string-substring-count">
  <xsl:param name="namespace"/>
  <xsl:param name="substring"/>
  <xsl:param name="counter" select="0"/>
  <func:result>
    <xsl:choose>
      <xsl:when test="contains($namespace, '\')">
        <xsl:value-of select="cxr:count-namespaces(substring-after($namepace, $substring), $counter + 1)" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="$counter" />
      </xsl:otherwise>
    </xsl:choose>
  </func:result>
</func:function>

<func:function name="cxr:string-repeat">
  <xsl:param name="namespace"/>
  <xsl:param name="counter" select="0"/>
  <func:result>
    <xsl:choose>
      <xsl:when test="contains($namespace, '\')">
        <xsl:value-of select="cxr:count-namespaces(substring-after($namepace, '\\'), $counter + 1)" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="cxr:count-namespaces(substring-after($namepace, '\\'), $counter)" />
      </xsl:otherwise>
    </xsl:choose>
  </func:result>
</func:function>
  
</xsl:stylesheet>