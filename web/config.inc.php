<?php
// $Id: config.inc.php 2799 2014-01-09 12:44:22Z cimorrison $

/**************************************************************************
 *   MRBS Configuration File
 *   Configure this file for your site.
 *   You shouldn't have to modify anything outside this file.
 *
 *   This file has already been populated with the minimum set of configuration
 *   variables that you will need to change to get your system up and running.
 *   If you want to change any of the other settings in systemdefaults.inc.php
 *   or areadefaults.inc.php, then copy the relevant lines into this file
 *   and edit them here.   This file will override the default settings and
 *   when you upgrade to a new version of MRBS the config file is preserved.
 **************************************************************************/

/******
 * LDAP
 ******/

$auth["type"] = "ldap";

// 'auth_ldap' configuration settings
// Where is the LDAP server
$ldap_host = "ldaps://imap.lnl.infn.it";
// If you have a non-standard LDAP port, you can define it here
$ldap_port = 636;
// If you want to use LDAP v3, change the following to true
$ldap_v3 = false;
// If you want to use TLS, change following to true
$ldap_tls = false;
// LDAP base distinguish name
// See AUTHENTICATION for details of how check against multiple base dn's
$ldap_base_dn = "dc=lnl,dc=infn,dc=it";
// Attribute within the base dn that contains the username
$ldap_user_attrib = "uid";


/*******
 * ROOMS
 *******/
$FORTUNA = 1;
$VILLI = 2;
$CEOLIN = 3;
$ROSTAGNI = 11;
$FORMAZIONE = 12;
$TANDEM = 13;
$BIBVANNUCCI = 14;
$LAE = 15;

/************
 * USER ROLES
 ************/

$auth['deny_public_access'] = TRUE;

$max_level = 3;
$min_booking_admin_level = 3;
$min_level_to_book = 2;

$auth["admin"][] = "mcamillo";
$auth["admin"][] = "dlupu";
$auth["admin"][] = "gulmini";
$auth["admin"][] = "biasotto";
$auth["admin"][] = "fantinel";
$auth["admin"][] = "toniolo";
$auth["admin"][] = "roetta";
$auth["admin"][] = "marcato";
$auth["user"][] = "carraret";
$auth[$FORTUNA][] = "carraret";
$auth["user"][] = "polato";
$auth["user"][] = "deste";
$auth["user"][] = "sartor";
$auth["user"][] = "zane";
$auth["user"][] = "martin";

/**********
 * Timezone
 **********/
 
// The timezone your meeting rooms run in. It is especially important
// to set this if you're using PHP 5 on Linux. In this configuration
// if you don't, meetings in a different DST than you are currently
// in are offset by the DST offset incorrectly.
//
// Note that timezones can be set on a per-area basis, so strictly speaking this
// setting should be in areadefaults.inc.php, but as it is so important to set
// the right timezone it is included here.
//
// When upgrading an existing installation, this should be set to the
// timezone the web server runs in.  See the INSTALL document for more information.
//
// A list of valid timezones can be found at http://php.net/manual/timezones.php
// The following line must be uncommented by removing the '//' at the beginning
$timezone = "Europe/Rome";


/*******************
 * Database settings
 ******************/
// Which database system: "pgsql"=PostgreSQL, "mysql"=MySQL,
// "mysqli"=MySQL via the mysqli PHP extension
$dbsys = "mysqli";
// Hostname of database server. For pgsql, can use "" instead of localhost
// to use Unix Domain Sockets instead of TCP/IP. For mysql/mysqli "localhost"
// tells the system to use Unix Domain Sockets, and $db_port will be ignored;
// if you want to force TCP connection you can use "127.0.0.1".
$db_host = "mrbs_db";
// If you need to use a non standard port for the database connection you
// can uncomment the following line and specify the port number
$db_port = 3306;
// Database name:
$db_database = "mrbs";
// Schema name.  This only applies to PostgreSQL and is only necessary if you have more
// than one schema in your database and also you are using the same MRBS table names in
// multiple schemas.
//$db_schema = "public";
// Database login user name:
$db_login = "mrbs";
// Database login password:
$db_password = 'mrbs';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "mrbs_";
// Uncomment this to NOT use PHP persistent (pooled) database connections:
// $db_nopersist = 1;
