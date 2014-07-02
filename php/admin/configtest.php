<?php
    /*
     * $Id: configtest.php 1581 2012-03-07 02:19:19Z dmorton $
     *
     * MAIA MAILGUARD LICENSE v.1.0
     *
     * Copyright 2005 by Robert LeBlanc <rjl@renaissoft.com>
     *                   David Morton   <mortonda@dgrmm.net>
     * All rights reserved.
     *
     * PREAMBLE
     *
     * This License is designed for users of Maia Mailguard
     * ("the Software") who wish to support the Maia Mailguard project by
     * leaving "Maia Mailguard" branding information in the HTML output
     * of the pages generated by the Software, and providing links back
     * to the Maia Mailguard home page.  Users who wish to remove this
     * branding information should contact the copyright owner to obtain
     * a Rebranding License.
     *
     * DEFINITION OF TERMS
     *
     * The "Software" refers to Maia Mailguard, including all of the
     * associated PHP, Perl, and SQL scripts, documentation files, graphic
     * icons and logo images.
     *
     * GRANT OF LICENSE
     *
     * Redistribution and use in source and binary forms, with or without
     * modification, are permitted provided that the following conditions
     * are met:
     *
     * 1. Redistributions of source code must retain the above copyright
     *    notice, this list of conditions and the following disclaimer.
     *
     * 2. Redistributions in binary form must reproduce the above copyright
     *    notice, this list of conditions and the following disclaimer in the
     *    documentation and/or other materials provided with the distribution.
     *
     * 3. The end-user documentation included with the redistribution, if
     *    any, must include the following acknowledgment:
     *
     *    "This product includes software developed by Robert LeBlanc
     *    <rjl@renaissoft.com>."
     *
     *    Alternately, this acknowledgment may appear in the software itself,
     *    if and wherever such third-party acknowledgments normally appear.
     *
     * 4. At least one of the following branding conventions must be used:
     *
     *    a. The Maia Mailguard logo appears in the page-top banner of
     *       all HTML output pages in an unmodified form, and links
     *       directly to the Maia Mailguard home page; or
     *
     *    b. The "Powered by Maia Mailguard" graphic appears in the HTML
     *       output of all gateway pages that lead to this software,
     *       linking directly to the Maia Mailguard home page; or
     *
     *    c. A separate Rebranding License is obtained from the copyright
     *       owner, exempting the Licensee from 4(a) and 4(b), subject to
     *       the additional conditions laid out in that license document.
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDER AND CONTRIBUTORS
     * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
     * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
     * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
     * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
     * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
     * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS
     * OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
     * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
     * TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE
     * USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     *
     */

    require_once ("../config.php");



    function find_path($path_list, $file)
    {
    	$match = "";

    	foreach ($path_list as $path)
    	{
    	    $test_file = $path . "/" . $file;
    	    if (file_exists($test_file)) {
    	        $match = $test_file;
    	        break;
    	    }
        }

    	return $match;
    }


    define('OK', "ok");
    define('WARN', "warn");
    define('ERROR', "error");
    define('UPDATE', "update");

    function print_row($left, $right, $err = OK) {
        switch ($err) {
            case OK:
                $color = "#00DD00";
                $status = "<b>OK</b>";
                break;
            case WARN:
                $status = "<b>SKIPPED</b>";
            case UPDATE:
                $color = "#DDDD00";
                break;
            case ERROR:
                $color = "#FE899B";
                $status = "<b>FAILED</b>";
                break;
        }
        if ($right != "") {
            $status .= ":";
        }
        print("<tr><td bgcolor=\"#CCCCCC\">$left</td>\n");
        print("<td bgcolor=\"$color\" width=\"75%\">$status $right </td>");
        print("</tr>\n");
    }

?>
<div align="center">
<table border="0" cellspacing="2" cellpadding="2" width="100%">
<tr><td bgcolor="#CCCCCC" align="center" colspan="2">
<h1>Maia Mailguard Configuration Tester</h1><br>
<h4>(Note: some distros do not update pear's registry correctly and these tests may appear inaccurate.<br>
	Please contribute to <a href="http://www.maiamailguard.com/maia/ticket/306">this ticket</a> if you have any insight!)</h4>
</td></tr>
<?php
    $status = OK;

    //smarty compile dirs file permissions.
    $smarty_base = "../themes"; // this assumes configtest.php is located in webroot/admin/
    $result = "";
    if (is_readable($smarty_base)){
      $dir = opendir($smarty_base); #open directory
      while ($f = readdir($dir)) { #read one file name
        if (!eregi("^\..*$",$f) && $f!=='.' && $f!=='..'){
          if (is_writable($smarty_base . "/" . $f . "/compiled")) {
            continue;
          } else {
            $status = ERROR;
            $result .= "Cannot write to: " . $smarty_base . "/" . $f . "/compiled <br>\n";
          }
        }
      }
    } else {
      $status = ERROR;
      $result = "Cannot read $smarty_base\n";
    }
    if ($status == ERROR) {
      $result .= "Please <a href=\"http://www.maiamailguard.com/maia/wiki/BlankPage\">" .
                 "set your file permissions</a> so that the web server " .
                 "user can write to the above directories. ";
    }
    print_row("File Permissions", $result, $status);

    // PHP
    $php_version = phpversion();
    $include_path = ini_get("include_path");
    $path_list = explode(":", $include_path);
    $path_list[] = "../libs/";

    if ($php_version >= "4.0.2") {
        if ($php_version == "5.0.3") {
           $status = WARN;
           $result = "PHP 5.0.3 has a bug that causes errors with PEAR::DB.  It is fixed in the current snapshots.";
        } else {

          $result = $php_version;
          $status = OK;
        }
    } else {
    	$result = "PHP version 4.0.2 or later is required.  See " .
    	          "<a href=\"http://pear.php.net/\">this page</a> for " .
    	          "information about downloading a more current version of PHP.";
        $status = ERROR;
    }
    print_row("PHP", $result, $status);


    // PHP Modules
    ob_start();
    phpinfo(INFO_MODULES);
    $php_info = ob_get_contents();
    ob_end_clean();

    // register_globals
    if (ini_get('register_globals')) {
      $result = "The register_globals ini settings appears to be on, please set it to " .
                "off in either your php.ini file, or in a .htaccess file.  See " .
                "<a href=\"http://us2.php.net/register_globals\">http://us2.php.net/register_globals</a> " .
                "for more details.";
      $status = ERROR;
    } else {
      $result = "";
      $status = OK;
    }
    print_row("register_globals", $result, $status);


    // SMARTY
    if (isset($smarty_path)) {
        if (!($smarty_dir = find_path(array($smarty_path), "Smarty.class.php"))) {
            $result = "Can't find Smarty.class.php in location specified in config.php: ( \$smarty_path = \"$smarty_path\";.  )" .
                      "The Smarty templating engine is required. " .
                      "See <a href=\"http://www.smarty.net/\">this page</a> " .
                      "for more information about downloading and installing Smarty.";
            $status = ERROR;
        } else {
            $status = OK;
            $result = "Found Smarty in $smarty_dir";
        }
        
    } else {
        if (!($smarty_dir = find_path($path_list, "Smarty/Smarty.class.php"))) {
            $result = "Not installed.  The Smarty templating engine is required. " .
                      "See <a href=\"http://www.smarty.net/\">this page</a> " .
                      "for more information about downloading and installing Smarty.";
           $status = ERROR;
        } else {
            $status = OK;
            $result = "Found Smarty in $smarty_dir";
        }
    }
    print_row("Smarty Template Engine", $result, $status);

    // wddx support
    $have_wddx = false;
    if(function_exists( 'wddx_serialize_value')) {
        $have_wddx = true;
        $result = "WDDX support available";
        $status = OK;
     } else {
        $result = "WDDX support not available.  WDDX is needed for error reporting and debugging";
        $status = ERROR;
     }
     print_row("WDDX Support", $result, $status);

     // multibyte support
     $have_mb = false;
     if(function_exists( 'mb_substr')) {
         $have_mb = true;
         $result = "Multibyte String support available";
         $status = OK;
      } else {
         $result = "Multibyte String support not available. <a href=\"http://us2.php.net/manual/en/book.mbstring.php\">Multibyte functions</a> are needed to display messages correctly.";
         $status = ERROR;
      }
      print_row("Multibyte String Support", $result, $status);

      // iconv support
      $have_iconv = false;
      if(function_exists( 'iconv')) {
        $have_iconv = true;
        $result = "iconv support available";
        $status = OK;
      } else {
        $result = "iconv support not available. <a href=\"http://php.net/manual/en/book.iconv.php\">iconv</a> is needed to display messages correctly.";
        $status = ERROR;
      }
      print_row("iconv function", $result, $status);


    // mysql support
    $have_mysql = false;
    if(function_exists( 'mysql_connect' ) || function_exists( 'mysqli_connect')) {
      $have_mysql = true;
      $result = "MySQL support available";
      $status= OK;
    } else {
      $result = "MySQL support not available";
      $status = WARN;
    }
    print_row("MySQL Support", $result, $status);

    // PostgreSQL  support
    $have_psql = false;
    if(function_exists( 'pg_connect' )) {
      $have_psql = true;
      $result = "PostgreSQL support available";
      $status= OK;
    } else {
      $result = "PostgreSQL support not available";
      $status = WARN;
    }
    print_row("PostgreSQL Support", $result, $status);

    // Database support
    if(!($have_mysql || $have_psql)) {
      $result = "No supported databases are available!";
      $status = ERROR;
    } else {
      $result = "Database support is ok";
      $status = OK;
    }
    print_row("Database Support", $result, $status);

    // PEAR
    $have_pear = false;
    if (!($pear_dir = find_path($path_list, "PEAR"))) {
    	$result = "Not installed.  The PEAR extension is required by several other " .
    	          "PHP extensions that Maia needs.  See <a href=\"http://pear.php.net/\">this page</a> " .
    	          "for more information about downloading and installing PEAR.";
       $status = ERROR;
    } else {
       // include_once ("PEAR/Remote.php");      // PEAR::Remote
        include_once ("PEAR/Registry.php");    // PEAR::Registry

    	$have_pear = true;
    	$pear = new PEAR_Config();
        $pear_reg = new PEAR_Registry($pear->get('php_dir'));
        $pear_info = $pear_reg->packageInfo("PEAR");
        $pear_list = $pear_reg->listPackages();
        $pear_version = is_array($pear_info["version"])?$pear_info["version"]["release"]:$pear_info["version"];
        $result = $pear_version;
        $status = OK;
    }
    print_row("PEAR", $result, $status);


    // PEAR::Mail_Mime
    if ($have_pear) {
      if (!in_array("mail_mime", $pear_list)) {
        $result = "Not installed.  This PHP extension is required to decode " .
                  "MIME-structured e-mail.  Use <b>pear install Mail_Mime</b> to " .
                  "install this.";
        $status = ERROR;
      } else {
        $info = $pear_reg->packageInfo("Mail_Mime");
        $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
        if (version_compare($result,"1.3.0") < 0) {
          $version = $result;
          $result = "Version $version installed.  Versions of Mail_Mime below 1.3.0  " .
                    "are known to be buggy.  Use <b>pear upgrade Mail_Mime</b> to " .
                    "upgrade to the latest version.";
          $status = ERROR;
        } elseif (version_compare($result,"1.5.0") < 0) {
          $status = OK;
          $check_mime_decode = false;
        } else {
          $check_mime_decode = true;
          $status = OK;
        }
      }
    } else {
        $result = "Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Mail_Mime", $result, $status);

    // PEAR::Mail_Mime
    if ($check_mime_decode) {
      if (!in_array("mail_mimedecode", $pear_list)) {
        $result = "Not installed.  This PHP extension is required to decode " .
                  "MIME-structured e-mail.  Use <b>pear install Mail_mimeDecode</b> to " .
                  "install this.  (Mail_mimeDecode was split from Mail_Mime at version 1.5.0)";
        $status = ERROR;
      } else {
        $info = $pear_reg->packageInfo("Mail_mimeDecode");
        $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
        if (version_compare($result,"1.5.0") < 0) {
          $version = $result;
          $result = "Version $version installed.  Versions of Mail_Mime below 1.3.0  " .
                    "are known to be buggy.  Use <b>pear upgrade Mail_Mime</b> to " .
                    "upgrade to the latest version.";
          $status = ERROR;
        } else {
          $status = OK;
        }
      }
      print_row("PEAR::Mail_mimeDecode", $result, $status);
    }

  function strip_tailing_slash($path) {
    return rtrim($path, '/');
  }


    // PEAR::DB
    if ($have_pear) {
        if (!in_array("db", $pear_list)) {
            $result = "Not installed.  This PHP extension is required in order to provide " .
                      "database abstraction.  Use <b>pear install DB</b> to install this.";
            $status = ERROR;
        } else {
          $db_info = $pear_reg->packageInfo("DB");
          $pathArray = explode( PATH_SEPARATOR, get_include_path() );
          $pathArray = array_map('strip_tailing_slash', $pathArray);
          $db_path = dirname($db_info['filelist']['DB.php']['installed_as']);
          if (in_array($db_path, $pathArray)) {
            include_once ("DB.php");               // PEAR::DB
            $test_dbh = DB::connect($maia_sql_dsn);
            if (DB::isError($test_dbh)) {
                $result = "Could not connect to database.  Check the \$maia_sql_dsn setting in config.php.";
                  $status = ERROR;
            } else {
                $result = $db_version = is_array($db_info["version"])?$db_info["version"]["release"]:$db_info["version"];
                $result .= " DB.php installed as: " . $db_info['filelist']['DB.php']['installed_as'];
                $db_type = $test_dbh->phptype;
                
            }
          } else {
            $result = "DB.php installed in: " . $db_path . " but not in include path: " . get_include_path();
            $status = ERROR;
          }
        }
    } else {
        $result = "Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::DB", $result, $status);

//Database Version
    if (isset($maia_sql_dsn)) {
      if (preg_match('/^mysqli/', $maia_sql_dsn)) {
          $db_version = mysqli_get_server_info($test_dbh->connection);
          $status = OK;
          $result = "No minimum specified yet... Installed: " . $db_version;
      } elseif (preg_match('/^mysql/', $maia_sql_dsn)) {
          $db_version = mysql_get_server_info($test_dbh->connection);
          $status = OK;
          $result = "No minimum specified yet... Installed: " . $db_version;
      } elseif (preg_match('/^pgsql/', $maia_sql_dsn)) {
        if (function_exists("pg_version")) {
          $pg_version_result = pg_version($test_dbh->connection);
          $db_version = $pg_version_result['server'] ;
          if ($db_version >= "8.0" ) {
            $status = OK;
            $result = "Database version: " . $db_version;
          } else {
            $status = ERROR;
            $result = "Postgresql >= 8.0 required.";
          }
        } else {
          $status = WARN;
          $result = "Cannot determine database version.  We recommend Postgresql > 8.0; Please verify this before continuing.";
        }
      } else {
          $status = ERROR;
          $result = "Unsupported database";
      }
    } else {
      $status = ERROR;
      $result = "Cannot determine database version. Please check the maia_sql_dsn setting in the config file.";
    }
    print_row("Database Version", $result, $status);


    // PEAR::Pager
    if ($have_pear) {
        if (!in_array("pager", $pear_list)) {
            $result = "Not installed.  This PHP extension is required in order to paginate " .
                      "the list of mail items in the quarantines and the ham cache.  Use " .
                      "<b>pear install Pager</b> to install this.";
            $status = ERROR;
        } else {
            $pager_info = $pear_reg->packageInfo("Pager");
    	    $result = is_array($pager_info["version"])?$pager_info["version"]["release"]:$pager_info["version"];
            $status = OK;
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Pager", $result, $status);


	  // PEAR::Net_Socket
    if ($have_pear) {
        if (!in_array("net_socket", $pear_list)) {
            $result = "Not installed.  This PHP extension is required for Net_SMTP to send mail when rescuing email";
            $status = ERROR;
        } else {
    	    $info = $pear_reg->packageInfo("Net_Socket");
    	    $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
            $status = OK;
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Net_Socket", $result, $status);


    // PEAR::Net_SMTP
    if ($have_pear) {
      if (!in_array("net_smtp", $pear_list)) {
        $result = "Not installed.  This PHP extension is required to send mail when rescuing email";
        $status = ERROR;
      } else {
        $info = $pear_reg->packageInfo("Net_SMTP");
        $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
        if (version_compare($result,"1.2.5") < 0) {
          $version = $result;
          $result = "Version $version installed.  Need at least 1.2.5";
          $status = ERROR;
        } else {
          $status = OK;
        }
      }
    } else {
      $result ="Requires PEAR";
      $status = WARN;
    }
    print_row("PEAR::Net_SMTP", $result, $status);

    // PEAR::Auth_SASL
    if ($have_pear) {
        if (!in_array("auth_sasl", $pear_list)) {
            $result = "Not installed.  This module is required by PEAR::Net_SMTP in " .
                      "order to support the DIGEST-MD5 and CRAM-MD5 SMTP authentication methods.";
            $status = ERROR;
        } else {
            $info = $pear_reg->packageInfo("Auth_SASL");
            $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
            $status = OK;
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Auth_SASL", $result, $status);

    // PEAR::Net_IMAP
    if ($have_pear) {
        if (!in_array("net_imap", $pear_list)) {
            $result = "Not installed.  This PHP extension is required to authenticate maia against IMAP.";
            $status = WARN;
        } else {
            $info = $pear_reg->packageInfo("Net_IMAP");
            $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
          if ($result == "1.0.3" && $php_version >= "5.0.0") {
             $result = "A bug exists in Net_IMAP 1.0.3 when run under PHP 5, see <a href=\"http://www.maiamailguard.com/maia/ticket/266\">http://www.maiamailguard.com/maia/ticket/266</a> for more details.";
             $status = WARN;      
          } elseif ($result == "1.1.1")  {
             $result = "A regression bug exists in Net_IMAP 1.1.1, possibly restricted to ssl on alternate ports; see <a href=\"http://www.maiamailguard.com/maia/ticket/569\">http://www.maiamailguard.com/maia/ticket/569</a> for more details.  Reverting to 1.1.0 helps.";
            $status = WARN;
          } else {
            $status = OK;
          }
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Net_IMAP", $result, $status);

    // PEAR::Net_POP3
    if ($have_pear) {
        if (!in_array("net_pop3", $pear_list)) {
            $result = "Not installed.  This PHP extension is required to authenticate maia against POP3.";
            $status = WARN;
        } else {
            $info = $pear_reg->packageInfo("Net_POP3");
            $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
            $status = OK;
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Net_POP3", $result, $status);

    // PEAR::Log
    if ($have_pear) {
        if (!in_array("log", $pear_list)) {
            $result = "Needed for debugging and logging. Use <b>pear install Log</b> to install " .
                      "this PHP extension.";
            $status = ERROR;
        } else {
    	    $log_info = $pear_reg->packageInfo("Log");
    	    $result = is_array($log_info["version"])?$log_info["version"]["release"]:$log_info["version"];
            $status = OK;
        }
    } else {
        $result = "Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Log", $result, $status);

    // PEAR::Image_Color
    if ($have_pear) {
        if (!in_array("image_color", $pear_list)) {
            $result = "Not installed.  Optional package, required only if you wish " .
                      "to enable the graphical chart features.";
            $status = WARN;
        } else {
            $info = $pear_reg->packageInfo("Image_Color");
            $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
            $status = OK;
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Image_Color", $result, $status);

    // PEAR::Image_Canvas
    if ($have_pear) {
        if (!in_array("image_canvas", $pear_list)) {
            $result = "Not installed.  Optional package, required only if you wish " .
                      "to enable the graphical chart features.";
            $status = WARN;
        } else {
            $info = $pear_reg->packageInfo("Image_Canvas");
            $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
            $status = OK;
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Image_Canvas", $result, $status);

    // PEAR::Image_Graph
    if ($have_pear) {
        if (!in_array("image_graph", $pear_list)) {
            $result = "Not installed.  Optional package, required only if you wish " .
                      "to enable the graphical chart features.";
            $status = WARN;
        } else {
            $info = $pear_reg->packageInfo("Image_Graph");
            $version = is_array($info["version"])?$info["version"]["release"]:$info["version"];
			if ( $version <= "0.7.2") {
				$status = WARN;
				$result = "Found version: ${version} - Image_Graph >= 0.7.2 recommended, but there is a bug in 0.7.2 that requires a small patch.  See <a href=\"http://www.maiamailguard.org/maia/ticket/326\">http://www.maiamailguard.org/maia/ticket/326</a> for more details and the patch.";
			} else {  // $version > "0.7.2") 
				$status = OK;
				$result = $version;
			}
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Image_Graph", $result, $status);

    // PEAR::Numbers_Roman
    if ($have_pear) {
        if (!in_array("numbers_roman", $pear_list)) {
            $result = "Not installed.  Optional package, required only if you wish " .
                      "to enable the graphical chart features.";
            $status = WARN;
        } else {
            $info = $pear_reg->packageInfo("Numbers_Roman");
            $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
            $status = OK;
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Numbers_Roman", $result, $status);

    // PEAR::Numbers_Words
    if ($have_pear) {
        if (!in_array("numbers_words", $pear_list)) {
            $result = "Not installed.  Optional package, required only if you wish " .
                      "to enable the graphical chart features.";
            $status = WARN;
        } else {
            $info = $pear_reg->packageInfo("Numbers_Words");
            $result = is_array($info["version"])?$info["version"]["release"]:$info["version"];
            $status = OK;
        }
    } else {
        $result ="Requires PEAR";
        $status = WARN;
    }
    print_row("PEAR::Numbers_Words", $result, $status);

    // html purifier
    if ( @include_once('HTMLPurifier.auto.php')) {
        $version = HTMLPurifier::VERSION;
        if ($version < "4.0.0") {
            $status = ERROR;
            $result = "Minimum required version of HTMLPurifier is 4.0.0, found: $version";
        } else {
            $status = OK;
            $result = $version;
        }
    } else {
        $result = 'Not found in include path.  The easiest way to install is to use PEAR as ' .
                  '<a href="http://htmlpurifier.org/download.html#PEAR">described here</a>';
        $status = ERROR;
    }
    print_row("HTMLPurifier", $result, $status);

    // html_purifier cache permissions
    if ($purifier_cache) {
        if (is_writable($purifier_cache)) {
            $result = "HTML Purifier cache dir: $purifier_cache";
            $status = OK;
        } else {
            $result = 'purifier_cache directory not writable: ' . $purifier_cache;
            $status = ERROR;
        }
    } else {
        $result = "(OPTIONAL) purifer_cache is not set in maia_config.php.  Maia will work without it, but the " .
                  "message viewer might be a little faster if you set it to a directory that is " .
                  "writable by the web server.";
        $status = WARN;
    }
    print_row("HTMLPurifier cache", $result, $status);


    // IMAP
    if (!function_exists("imap_open")) {
    	$result = "Not installed, but only required if you want to be able to authenticate " .
    	          "with IMAP against using the exchange authenticator.  See <a href=\"http://www.php.net/imap/\">this page</a> for " .
    	          "more information about downloading the IMAP extensions to PHP, and " .
    	          "instructions for recompiling PHP with the --with-imap flag.";
        $status = WARN;
    } else {
    	if (preg_match("/IMAP c-Client Version.*?>([0-9]+)/si", $php_info, $match)) {
    	    $result = $match[1];
    	} else {
    	    $result = "Unknown";
    	}
        $status = OK;
    }
    print_row("IMAP library", $result, $status);

    // LDAP
    if (!function_exists("ldap_connect")) {
    	$result = "Not installed, but only required if you want to be able to authenticate " .
    	          "with LDAP.  See <a href=\"http://www.php.net/ldap/\">this page</a> for " .
    	          "more information about downloading the LDAP extensions to PHP, and " .
    	          "instructions for recompiling PHP with the --with-ldap flag.";
        $status = ERROR;
    } else {
        $result = "";
        $status = OK;
    }
    print_row("LDAP library", $result, $status);


    // mcrypt
    if (!function_exists("mcrypt_get_iv_size")) {
    	$result = "Not installed, but only required if you want to be able to encrypt the " .
    	          "mail stored in Maia's database (quarantine and ham cache).  See " .
    	          "<a href=\"http://www.php.net/mcrypt/\">this page</a> for more information " .
    	          "about downloading the MCrypt extensions to PHP, and instructions for " .
    	          "recompiling PHP with the --with-mcrypt flag.";
        $status = ERROR;
    } else {
    	if (preg_match("/mcrypt support.*?version.*?<td.*?>(.+?)</si", $php_info, $match)) {
    	    $mcrypt_version = $match[1];
    	} else {
    	    $mcrypt_version = "Unknown";
    	}
    	$have_blowfish = (preg_match("/mcrypt support.*?Supported ciphers.*?(blowfish)[^\-]/si", $php_info, $match));
    	$have_cbc = (preg_match("/mcrypt support.*?Supported modes.*?(cbc)/si", $php_info, $match));
    	if ($have_blowfish && $have_cbc) {
            $result = $mcrypt_version . " with Blowfish and CBC";
            $status = OK;
        } else {
            $result = "Support for ";
            if (!$have_blowfish) {
                $result .= "Blowfish ";
                if (!$have_cbc) {
                    $result .= "and CBC ";
                }
            } else {
                $result .= "CBC ";
            }
            $result .= "must be compiled into libmcrypt.";
           $status = ERROR;
        }
    }
    print_row("MCrypt library", $result, $status);


    // BC
    if (!function_exists("bcadd")) {
    	$result = "Not installed.  This PHP extension is required in order to decode certain " .
    	          "types of URLs.  See <a href=\"http://www.php.net/bc/\">this page</a> " .
    	          "for more information about recompiling PHP with the --enable-bcmath flag.";
        $status = ERROR;
    } else {
        $result = "";
        $status = OK;
    }
    print_row("BC math library", $result, $status);


    // gd
    if (!function_exists("gd_info")) {
    	$result = "Not installed, but only required if you want to be able to generate charts " .
    	          "based on Maia's statistics.  See <a href=\"http://www.php.net/gd/\">this page</a> " .
    	          "for more information about recompiling PHP with the --with-gd flag.";
        $status = ERROR;
    } else {
    	$info = gd_info();
        $result = $info["GD Version"];
        $status = OK;
    }
    print_row("gd graphics library", $result, $status);


    print("</table></div>\n");

?>