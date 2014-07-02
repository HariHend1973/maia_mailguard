<?php
    /*
     * $Id: virus.php 950 2006-02-12 20:49:19Z dmorton $
     *
     * MAIA MAILGUARD LICENSE v.1.0
     *
     * Copyright 2004 by Robert LeBlanc <rjl@renaissoft.com>
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

   require_once ("core.php");
   require_once ("maia_db.php");


   /*
    * rewrite_google_virus_name(): Rewrites a virus name to conform to the
    *                              format required by Google's search URLs.
    */
   function rewrite_google_virus_name($virus)
   {
      // Literal search, fine as is
      return ($virus);
   }


   /*
    * rewrite_sophos_virus_name(): Rewrites a virus name to conform to the
    *                              format required by Sophos' website URLs.
    */
   function rewrite_sophos_virus_name($virus)
   {
      // "W32/Sobig-D" needs to become "w32sobigd"
      $virus = str_replace("/", "", $virus);
      $virus = str_replace("-", "", $virus);
      return (strtolower($virus));
   }


   /*
    * rewrite_fprot_virus_name(): Rewrites a virus name to conform to the
    *                             format required by F-Prot's website URLs.
    */
   function rewrite_fprot_virus_name($virus)
   {
      // "W32/Sobig.D@mm" needs to become "sobig_d"
      $pos = strpos($virus, '@');
      if (!($pos === false)) {
         $virus = substr($virus, 0, $pos);
      }
      $pos = strpos($virus, '/');
      if (!($pos === false)) {
         $virus = substr($virus, $pos + 1);
      }
      $virus = str_replace(".", "_", $virus);
      return (strtolower($virus));
   }


   /*
    * rewrite_fsecure_virus_name(): Rewrites a virus name to conform to the
    *                               format required by F-Secure's website URLs.
    */
   function rewrite_fsecure_virus_name($virus)
   {
      // "Sobig.D" needs to become "sobig_d"
      $virus = str_replace(".", "_", $virus);
      return (strtolower($virus));
   }


   /*
    * rewrite_nod32_virus_name(): Rewrites a virus name to conform to the
    *                             format required by NOD32's website URLs.
    */
   function rewrite_nod32_virus_name($virus)
   {
      // "Win32/Sobig.D" needs to become "sobigd"
      $pos = strpos($virus, '/');
      if (!($pos === false)) {
         $virus = substr($virus, $pos + 1);
      }
      $virus = str_replace(".", "", $virus);
      return (strtolower($virus));
   }


   /*
    * rewrite_norman_virus_name(): Rewrites a virus name to conform to the
    *                              format required by Norman Virus Control's
    *                              website URLs.
    */
   function rewrite_norman_virus_name($virus)
   {
      // "W32/Sobig.D@mm" needs to become "w32_sobig_d_mm"
      $virus = str_replace("/", "_", $virus);
      $virus = str_replace(".", "_", $virus);
      $virus = str_replace("@", "_", $virus);
      return (strtolower($virus));
   }


   /*
    * rewrite_trend_virus_name(): Rewrites a virus name to conform to the
    *                             format required by Trend Micro's website URLs.
    */
   function rewrite_trend_virus_name($virus)
   {
      // "WORM_SOBIG.D" is fine as is
      return ($virus);
   }


   /*
    * rewrite_symantec_virus_name(): Rewrites a virus name to conform to the
    *                                format required by Symantec's website URLs.
    */
   function rewrite_symantec_virus_name($virus)
   {
      // "W32.Sobig.D@MM" needs to become "w32.sobig.d@mm"
      return (strtolower($virus));
   }


   /*
    * rewrite_mcafee_virus_name(): Rewrites a virus name to conform to the
    *                              format required by McAfee's website URLs.
    */
   function rewrite_mcafee_virus_name($virus)
   {
      // "W32/Sobig.d@MM" is fine as is
      return ($virus);
   }


   /*
    * rewrite_virus_name(): Returns a virus name modified according to the
    *                       ruleset specified by $virus_lookup, to match the
    *                       format required in a particular URL.
    */
   $virus_lookup = get_config_value("virus_lookup");
   $rewrite_virus_name = "rewrite_" . $virus_lookup . "_virus_name";


   /*
    * get_virus_info_url(): Returns a URL pointing to a website where information
    *                       about a specific virus can be found.
    */
   function get_virus_info_url($virus)
   {
      global $dbh;
      global $rewrite_virus_name;

      $select = "SELECT virus_lookup, virus_info_url FROM maia_config WHERE id = 0";
      $sth = $dbh->query($select);
      if ($row = $sth->fetchrow()) {
          $virus_lookup = $row["virus_lookup"];
          $virus_info_url = $row["virus_info_url"];
      }
      $sth->free();

      // Exit if we don't want any link at all.
      if (($virus_lookup == "") || ($virus_info_url == "")) {
         return "";
      }

      // Rewrite the virus name as necessary.
      $vname = $rewrite_virus_name($virus);

      // Insert the (fixed) virus name into the URL and return it.
      return (str_replace("%%VIRUSNAME%%", $vname, $virus_info_url));
   }
?>