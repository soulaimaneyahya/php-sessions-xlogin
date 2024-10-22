<?php

/**
 * Author: Soulaimane Yahya
 * Date: 2023-03-14
 */

define('ROOT_DIR', '/php/xsessions/php-sessions-xlogin');

/**
 * Auth based Sessions
 */

// replaces the default PHPSESSID
session_name('xlogin_session');
session_start();

setcookie('xlogin_session', $sessionId, [
    // 1h expiration
    'expires' => time() + 3600 * 24 * 7,
]);

// Regenerate session ID after login
session_regenerate_id(true);

function setSecurityLevel(string $level): void {
    setcookie('security_level', $level, [
        'expires' => time() + 3600,
    ]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (!isset($_COOKIE['security_level'])) {
    setSecurityLevel('low');
}

/**
 * Generate CSRF Token
 */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf_token'];

// Display flash message if available
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    // Remove flash message after displaying it
    unset($_SESSION['flash_message']);
}

/**
 * Auth user
 */
if (!empty($_SESSION["user"])) {
    $authUser = $_SESSION["user"];
}

/**
 * DB connection
 */
require_once __DIR__ . '/database.php';

require_once __DIR__ . '/../services/authService.php';
require_once __DIR__ . '/../services/userService.php';

/*
* Time Zone Setting
*/
date_default_timezone_set('Europe/London');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url = 'http://'. $_SERVER['SERVER_ADDR'] . ROOT_DIR;
define('BASE_URL', $url);
