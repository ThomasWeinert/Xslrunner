<?xml version="1.0"?>
<xsl:stylesheet
  version="1.0" 
  xmlns="http://www.w3.org/1999/xhtml/"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:pdox="http://xml.phpdox.de/src#"
  xmlns:cxr="http://thomas.weinert.info/carica/xr"
  exclude-result-prefixes="#default pdox cxr">

<xsl:template name="navigation">
  <xsl:param name="path"></xsl:param>
  <ul>
    <li>
      <a href="{$path}classes{$OUTPUT_EXTENSION}">Classes</a>
    </li>
  </ul>
</xsl:template>
  
</xsl:stylesheet>