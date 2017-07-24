<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| App Constants
| -------------------------------------------------------------------------
| This file lets you define some constants to simplify your 
| application. You can define constants like: default time zone, datetime, 
| and app related constants.   
|
*/

//Set TimeZone and Dates
date_default_timezone_set('Africa/Accra');
define('DATETIME', date('Y-m-d H:i:s', time()));
define('DATE', date('Y-m-d'));
define('TIMESTAMP', strtotime(date('Y-m-d') . ' ' . date('H:i:s')));
define('TODAY', date('Y-m-d'));

//Define Folder Paths
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

//These definitions are for characters and symbols e.g.(s, a, c, ., @, #)
define('ADD_S', 's');
define('DOT', '.');
define('AT', '@');
define('HASH', '#');