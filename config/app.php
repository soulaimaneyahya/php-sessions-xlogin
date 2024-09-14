<?php

/**
 * Author: Soulaimane Yahya
 * Date: 2023-03-14
 */

session_name('xlogin_session');
session_start();

setcookie('xlogin_session', $sessionId, [
    // 1h expiration
    'expires' => time() + 3600,
    // server root path
    // 'path' => '/',
    // If set, ensure it matches your domain
    // 'domain' => 'localhost',
    // Ensures the cookie is sent only over HTTPS
    // 'secure' => false,
    // Prevents JavaScript access
    // 'httponly' => false,
    // CSRF protection
    // 'samesite' => 'Strict',
]);

function setSecurityLevel(string $level): void {
    setcookie('security_level', $level, [
        'expires' => time() + 3600,
        'path' => '/',
        // 'domain' => 'localhost',
        // 'secure' => false,
        // 'httponly' => false,
        // 'samesite' => 'Strict',
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

$url = 'http://'. $_SERVER['SERVER_ADDR'] .'/php/xsessions/php-sessions-xlogin';
define('BASE_URL', $url);
