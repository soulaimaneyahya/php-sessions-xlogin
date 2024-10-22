<?php

/**
 * Author: Soulaimane Yahya
 * Date: 2023-03-14
 */

$dbHost = 'localhost';
$dbPort = '3306';
$dbName = 'php-sessions-xlogin';
$dbUsername = 'root';
$dbPassword = '';

try {
    $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName}";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
