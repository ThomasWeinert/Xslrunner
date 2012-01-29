-----------------------------------------------------------------------
|                                                                     |
| Carica XslRunner for phpDox                                         |
|                                                                     |
| Copyright 2011 Thomas Weinert <thomas@weinert.info>                 |
| Licence: MIT Licence                                                |
-----------------------------------------------------------------------

This is a PHP script wich allows to run an XSLT template file.
The XSLT can fetch XML files and generate files using XML
stream wrappers. It is possible to call specific PHP functions from
the xslt.

The main purpose of this script is to generate HTML pages from the
phpDox XML output.

Usage:
$ php runner.php [-x "./xml/"] [-o "./xhtml/"] \
  [-t "./templates/simple/start.xsl"]

-h / --help      Show this output.
-x / --xml       Source directory containing the xml files.
-o / --output    Output directory for the generated files.
-t / --template  Xslt template file to use.