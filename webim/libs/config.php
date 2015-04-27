<?php
/*
 * This file is part of Mibew Messenger project.
 * 
 * Copyright (c) 2005-2011 Mibew Messenger Community
 * All rights reserved. The contents of this file are subject to the terms of
 * the Eclipse Public License v1.0 which accompanies this distribution, and
 * is available at http://www.eclipse.org/legal/epl-v10.html
 * 
 * Alternatively, the contents of this file may be used under the terms of
 * the GNU General Public License Version 2 or later (the "GPL"), in which case
 * the provisions of the GPL are applicable instead of those above. If you wish
 * to allow use of your version of this file only under the terms of the GPL, and
 * not to allow others to use your version of this file under the terms of the
 * EPL, indicate your decision by deleting the provisions above and replace them
 * with the notice and other provisions required by the GPL.
 * 
 * Contributors:
 *    Evgeny Gryaznov - initial API and implementation
 */

/*
 *  Application path on server
 */

//die(str_replace('webim/libs','',__DIR__));
//require(str_replace('webim/libs','',__DIR__) . "includes/includes.php");
//require("/home/ecrs/public_html/new_site/includes/includes.php");
require("includes/includes.php");

$C = new Common;
$webimroot = "/webim";

/*
 *  Internal encoding
 */
$webim_encoding = "utf-8";

/*
 *  MySQL Database parameters
 */
$mysqlhost = DB_HOST;
$mysqldb = DB_NAME;
$mysqllogin = DB_USER;
$mysqlpass = DB_PASSWORD;
$mysqlprefix = "webim_";

$dbencoding = "utf8";
$force_charset_in_connection = true;

/*
 *  Mailbox
 */
$webim_mailbox = MAIL_CONTACTO;
$mail_encoding = "utf-8";

/*
 *  Locales
 */
$home_locale = "sp"; /* native name will be used in this locale */
$default_locale = "sp"; /* if user does not provide known lang */

?>
