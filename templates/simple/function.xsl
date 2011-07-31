<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:pdox="http://xml.phpdox.de/src#"
  xmlns:cxr="http://thomas.weinert.info/carica/xr"
  extension-element-prefixes="pdox cxr">
  
<xsl:template name="function-prototype">
  <xsl:param name="function" />
  <xsl:param name="name" select="$function/@name"/>
  <!--  position -->
  <xsl:param name="file"></xsl:param>
  <xsl:param name="lineNumber" select="$function/@start"/>
  <!-- function properties -->
  <xsl:param name="visibility" select="$function/@visibility"/>
  <xsl:param name="isAbstract" select="$function/@abstract = 'true'"/>
  <xsl:param name="isFinal" select="$function/@final = 'true'"/>
  <xsl:param name="isStatic" select="$function/@static = 'true'"/>
  <!-- parameter data -->
  <xsl:param name="parameters" select="$function/pdox:parameter"/>
  <xsl:param name="parameterDocs" select="$function/pdox:docblock/pdox:param"/>
  <xsl:param name="return" select="$function/pdox:docblock/@return"/>
  
  <div class="functionPrototype">
    <ul class="properties">
      <li><xsl:value-of select="$visibility" /></li>
      <xsl:if test="$isAbstract">
        <li>abstract</li>
      </xsl:if>
      <xsl:if test="$isFinal">
        <li>final</li>
      </xsl:if>
      <xsl:if test="$isStatic">
        <li>static</li>
      </xsl:if>
      <xsl:if test="$return and $return != ''">
	      <xsl:call-template name="variable-type">
	        <xsl:with-param name="typeString" select="$return/@type"/>
	      </xsl:call-template>
      </xsl:if>
      <span class="name">
        <xsl:value-of select="@name" />
      </span>
      <xsl:call-template name="function-parameters">
        <xsl:with-param name="parameters" select="$parameters"/>
        <xsl:with-param name="documentation" select="$parameterDocs"/>
      </xsl:call-template>
    </ul>
  </div>
</xsl:template>

<xsl:template name="function-parameters">
  <xsl:param name="parameters"/>
  <xsl:param name="documentation"/>
  <span class="parameters">
    <xsl:text>(</xsl:text>
    <xsl:if test="$parameters and count($parameters) > 0">
      <ul class="parameters">
        <xsl:for-each select="$parameters">
          <xsl:variable name="name">
            <xsl:if test="@byreference = 'true'">
              <xsl:text>&amp;</xsl:text>
            </xsl:if>
            <xsl:text>$</xsl:text>
            <xsl:value-of select="@name"/>
          </xsl:variable>
          <xsl:call-template name="function-parameter">
            <xsl:with-param name="parameter" select="."/>
            <xsl:with-param name="parameterName" select="$name"/>
            <xsl:with-param name="documentation" select="$documentation[@variable = $name]"/>
          </xsl:call-template>
          <xsl:if test="position() = last()">
            <xsl:for-each select="$parameters[@optional = 'true']">
              <xsl:text>]</xsl:text>
            </xsl:for-each>
          </xsl:if>
        </xsl:for-each>
      </ul>
    </xsl:if>
    <xsl:text>)</xsl:text>
  </span>
</xsl:template>

<xsl:template name="function-parameter">
  <xsl:param name="parameter"/>
  <xsl:param name="documentation"/>
  <xsl:param name="parameterName">
    <xsl:if test="$parameter/@byreference = 'true'">
      <xsl:text>&amp;</xsl:text>
    </xsl:if>
    <xsl:text>$</xsl:text>
    <xsl:value-of select="$parameter/@name"/>
  </xsl:param>
  <li>
    <xsl:choose>
      <xsl:when test="$documentation and $documentation/@type != ''">
        <xsl:call-template name="variable-type">
          <xsl:with-param name="typeString" select="$documentation/@type"/>
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <xsl:call-template name="variable-type">
          <xsl:with-param name="typeString" select="$parameter/@type"/>
        </xsl:call-template>
      </xsl:otherwise>
    </xsl:choose>
    <xsl:if test="$parameter/@optional = 'true'">
      <xsl:text>[</xsl:text>
    </xsl:if>
    <span class="name"><xsl:value-of select="$parameterName"/></span>
  </li>
</xsl:template>

<xsl:template name="variable-type">
  <xsl:param name="typeString"/>
  <ul class="variableType">
    <li><xsl:value-of select="$typeString"/></li>
  </ul>
</xsl:template>
  
</xsl:stylesheet>