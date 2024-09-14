<?php

/**
 * Author: Soulaimane Yahya
 * Date: 2023-03-14
 */

session_name('xlogin_session');
session_start();

/*
* Time Zone Setting
*/
date_default_timezone_set('Europe/London');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_URL', 'http://localhost/php/xsessions/php-sessions-xlogin');
