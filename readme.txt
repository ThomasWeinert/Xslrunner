-----------------------------------------------------------------------
|                                                                     |
| Carica XslRunner for phpDox                                         |
|                                                                     |
| Copyright 2011 Thomas Weinert <thomas@weinert.info>                 |
| Licence: MIT Licence                                                |
-----------------------------------------------------------------------

This is a php script wich allos to run an xslt template file.
The xslt can fetch xml files and generate files using php
streamwrappers. It is possible to call specific php functions from
the xslt.

The main purpose of this script is to generate html pages from the
phpDox xml output.

Usage:
$ php runner.php [-x "./xml/"] [-o "./xhtml/"] \
  [-t "./templates/simple/start.xsl"]

-h / --help      Show this output.
-x / --xml       Source directory containing the xml files.
-o / --output    Output directory for the generated files.
-t / --template  Xslt template file to use.