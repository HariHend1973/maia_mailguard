<?php
    /*
     * $Id$
     *
     * MAIA MAILGUARD LICENSE v.1.0
     *
     * Copyright 2004 by Robert LeBlanc <rjl@renaissoft.com>
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

    // Page subtitle
    $lang['banner_subtitle']            = "Domain E-Mail-Filter Standardeinstellungen";

    // Table headers
    $lang['header_domain']              = "Domain";
    $lang['header_admins']              = "Domain-Administratoren";
    $lang['header_revoke']              = "Rechte entziehen";
    $lang['header_admin_name']          = "Administrator";
    $lang['header_add_administrator']   = "Administrator hinzufügen";

    // Text labels
    $lang['text_yes']                   = "Ja";
    $lang['text_no']                    = "Nein";
    $lang['text_virus_scanning']        = "VirenScan";
    $lang['text_enabled']               = "Aktiviert";
    $lang['text_disabled']              = "Deaktiviert";
    $lang['text_quarantined']           = "Quarantäne";
    $lang['text_discarded']             = "Gelöscht";
    $lang['text_labeled']               = "Markiert";
    $lang['text_detected_viruses']      = "Gefundene Viren werden ...";
    $lang['text_spam_filtering']        = "Spam Filterung";
    $lang['text_detected_spam']         = "Gefundener Spam wird ...";
    $lang['text_prefix_subject']        = "Präfix im Betreff einer Spam-E-Mail";
    $lang['text_add_spam_header']       = "Füge 'X-Spam:' Kopfzeile ein, wenn Punkte";
    $lang['text_consider_mail_spam']    = "Betrachte E-Mail als 'Spam', wenn Punkte";
    $lang['text_quarantine_spam']       = "Verschiebe in Quarantäne, wenn Punkte";
    $lang['text_attachment_filtering']  = "Filter für verbotene Dateianhänge";
    $lang['text_mail_with_attachments'] = "E-Mails mit verbotene Dateianhängen werden ...";
    $lang['text_bad_header_filtering']  = "Filter für defekte Kopfzeilen";
    $lang['text_mail_with_bad_headers'] = "E-Mails mit defekten Kopfzeilen werden ...";
    $lang['text_settings_updated']      = "E-Mail Filtereinstellungen wurden geändert.";
    $lang['text_system_default']        = "Systemstandards";
    $lang['text_no_admins']             = "Es wurde kein Administrator für diese Domain ausgewählt.";
    $lang['text_no_available_admins']   = "Es sind keine Benutzer verfügbar für diese Domain.";
    $lang['text_administrators_added']  = "Die ausgewählten Administratoren wurden zur Domain hinzugefügt.";
    $lang['text_admins_revoked']        = "Den ausgewählten Administratoren wurden die Rechte entzogen.";
    $lang['text_cache_ham_question']    = "Sollen normale E-Mails zwischengespeichert werden?";
    $lang['text_enable_user_autocreation'] = "Sollen neue Benutzer automatisch angelegt werden?";
    $lang['text_domain_theme']          = "Standard Theme für diese Domain?";

    // Buttons
    $lang['button_reset']               = "Zurücksetzen";
    $lang['button_update_domain']       = "Aktualisiere Domain-Standards";
    $lang['button_revoke']              = "Entziehe den markierten Administratoren die Rechte";
    $lang['button_grant']               = "Administratorrechte vergeben";

    // Links
    $lang['link_domain_settings']       = "Zurück zu den Domain-Einstellungen";
    $lang['link_admin_domains']         = "Zurück zum Domain-Administrationsmenü";

    //tabs
    $lang['tab_domain_settings'] = "Schwellwerte";
    $lang['tab_misc_settings'] = "Sonstiges";
    $lang['tab_grant_admin'] = "Erlaube Admin";
    $lang['tab_revoke_admin'] = "Widerrufe Admin";
    $lang['tab_change_login'] = "Ändere Login";
    $lang['tab_addresses'] = "Adressen";
?>
