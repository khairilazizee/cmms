<?php

# Check "docs/configuration.txt" for a more complete description of how you
# set the different settings and what they will do.

# PHPFM's home directory
# Use forward slashes instead of backslashes and remember a trailing slash!
$home_directory         = "c:/umportal/doc/";

# Language of PHPFM.
$language       = "malay";

# Session save_path information
# *NIX systems      - set this to "/tmp/";
# WINDOWS systems   - set this to "c:/winnt/temp/";
# NB! replace "c:/winnt/" with the path to your windows folder
#
# Uncomment _only_ if you are experiencing errors!
# $session_save_path    = "/tmp/";

# Login configuration
$phpfm_auth     = FALSE;
//$username       = "rais";
//$password       = "123";

# Access configuration
# Each variable can be set to either TRUE or FALSE.
$AllowCreateFile        = TRUE;
$AllowCreateFolder      = TRUE;
$AllowDownload          = TRUE;
$AllowRename            = TRUE;
$AllowUpload            = TRUE;
$AllowDelete            = TRUE;
$AllowView              = TRUE;
$AllowEdit              = TRUE;

$test = "TEST";
# Icons for files
$IconArray = array(
     "ai.gif"        => "ai",
     "css.gif"        => "css",
     "pdf.gif"        => "pdf",
     "psd.gif"        => "psd",
     "doc.gif"        => "doc rtf",
	 "xls.gif"        => "xls xlt",
     "text.gif"       => "txt ini xml xsl ini inf cfg log nfo sql",
     "layout.gif"     => "html htm shtml cfm php php3 php4 asp aspx mspx",
     "script.gif"     => "php php4 php3 phtml phps conf sh shar csh ksh tcl cgi pl js",
     "image.gif"     => "jpeg jpe jpg gif png bmp",
     "c.gif"          => "c cpp",
     "compressed.gif" => "zip tar gz tgz z ace rar arj cab bz2",
     "sound.gif"     => "wav mp1 mp2 mp3 mid",
     "movie.gif"      => "mpeg mpg mov avi rm wmv",
     "binary.gif"     => "exe com dll bin dat rpm deb",
     "flash.gif"      => "swf fla swi",
);

# Files that can be edited in PHPFM's text editor
$EditableFiles = "php php4 php3 phtml phps cfm conf sh shar csh ksh tcl cgi pl js txt ini html htm css xml xsl ini inf cfg log nfo bat";

# Files that can be viewed in PHPFM's image viewer.
$ViewableFiles = "bmp jpeg jpe jpg gif png";

# Format of last modification date
$ModifiedFormat = "d-m-Y";

# Zoom levels for PHPFM's image viewer.
$ZoomArray = array(
     5,
     7,
     10,
     15,
     20,
     30,
     50,
     70,
     100,       # Base zoom level (do not change)
     150,
     200,
     300,
     500,
     700,
     1000,
);

# Hidden files and directories
$hide_file_extension       = array(
                                    "foo",
                             );

$hide_file_string          = array(
                                    ".htaccess",
									"index.php",
                             );

$hide_directory_string     = array(
                                    "conf",
									"docs",
									"icon",
									"incl",
									"lang",
                             );

$MIMEtypes = array(
     "application/andrew-inset"       => "ez",
     "application/mac-binhex40"       => "hqx",
     "application/mac-compactpro"     => "cpt",
     "application/msword"             => "doc",
     "application/octet-stream"       => "bin dms lha lzh exe class so dll",
     "application/oda"                => "oda",
     "application/pdf"                => "pdf",
     "application/postscript"         => "ai eps ps",
     "application/smil"               => "smi smil",
     "application/vnd.ms-excel"       => "xls xlt",
     "application/vnd.ms-powerpoint"  => "ppt",
     "application/vnd.wap.wbxml"      => "wbxml",
     "application/vnd.wap.wmlc"       => "wmlc",
     "application/vnd.wap.wmlscriptc" => "wmlsc",
     "application/x-bcpio"            => "bcpio",
     "application/x-cdlink"           => "vcd",
     "application/x-chess-pgn"        => "pgn",
     "application/x-cpio"             => "cpio",
     "application/x-csh"              => "csh",
     "application/x-director"         => "dcr dir dxr",
     "application/x-dvi"              => "dvi",
     "application/x-futuresplash"     => "spl",
     "application/x-gtar"             => "gtar",
     "application/x-hdf"              => "hdf",
     "application/x-javascript"       => "js",
     "application/x-koan"             => "skp skd skt skm",
     "application/x-latex"            => "latex",
     "application/x-netcdf"           => "nc cdf",
     "application/x-sh"               => "sh",
     "application/x-shar"             => "shar",
     "application/x-shockwave-flash"  => "swf",
     "application/x-stuffit"          => "sit",
     "application/x-sv4cpio"          => "sv4cpio",
     "application/x-sv4crc"           => "sv4crc",
     "application/x-tar"              => "tar",
     "application/x-tcl"              => "tcl",
     "application/x-tex"              => "tex",
     "application/x-texinfo"          => "texinfo texi",
     "application/x-troff"            => "t tr roff",
     "application/x-troff-man"        => "man",
     "application/x-troff-me"         => "me",
     "application/x-troff-ms"         => "ms",
     "application/x-ustar"            => "ustar",
     "application/x-wais-source"      => "src",
     "application/zip"                => "zip",
     "audio/basic"                    => "au snd",
     "audio/midi"                     => "mid midi kar",
     "audio/mpeg"                     => "mpga mp2 mp3",
     "audio/x-aiff"                   => "aif aiff aifc",
     "audio/x-mpegurl"                => "m3u",
     "audio/x-pn-realaudio"           => "ram rm",
     "audio/x-pn-realaudio-plugin"    => "rpm",
     "audio/x-realaudio"              => "ra",
     "audio/x-wav"                    => "wav",
     "chemical/x-pdb"                 => "pdb",
     "chemical/x-xyz"                 => "xyz",
     "image/bmp"                      => "bmp",
     "image/gif"                      => "gif",
     "image/ief"                      => "ief",
     "image/jpeg"                     => "jpeg jpg jpe",
     "image/png"                      => "png",
     "image/tiff"                     => "tiff tif",
     "image/vnd.wap.wbmp"             => "wbmp",
     "image/x-cmu-raster"             => "ras",
     "image/x-portable-anymap"        => "pnm",
     "image/x-portable-bitmap"        => "pbm",
     "image/x-portable-graymap"       => "pgm",
     "image/x-portable-pixmap"        => "ppm",
     "image/x-rgb"                    => "rgb",
     "image/x-xbitmap"                => "xbm",
     "image/x-xpixmap"                => "xpm",
     "image/x-xwindowdump"            => "xwd",
     "model/iges"                     => "igs iges",
     "model/mesh"                     => "msh mesh silo",
     "model/vrml"                     => "wrl vrml",
     "text/css"                       => "css",
     "text/html"                      => "html htm",
     "text/plain"                     => "asc txt",
     "text/richtext"                  => "rtx",
     "text/rtf"                       => "rtf",
     "text/sgml"                      => "sgml sgm",
     "text/tab-separated-values"      => "tsv",
     "text/vnd.wap.wml"               => "wml",
     "text/vnd.wap.wmlscript"         => "wmls",
     "text/x-setext"                  => "etx",
     "text/xml"                       => "xml xsl",
     "video/mpeg"                     => "mpeg mpg mpe",
     "video/quicktime"                => "qt mov",
     "video/vnd.mpegurl"              => "mxu",
     "video/x-msvideo"                => "avi",
     "video/x-sgi-movie"              => "movie",
     "x-conference/x-cooltalk"        => "ice",
);

?>
