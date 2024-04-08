<?php include __DIR__ . '/../config/app.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lorem ipsum dolor sit amet.</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <nav>
        <div>
            <a href="<?= BASE_URL; ?>/">Lorem ipsum dolor sit amet.</a>
            <ul>
                <li>
                    <a href="<?= BASE_URL; ?>/">Home</a>
                </li>
                <?php if (isset($_SESSION["user"])): ?>
                <li>
                    <a href="<?= BASE_URL; ?>/dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="<?= BASE_URL; ?>/auth/logout.php">Logout</a>
                </li>
                <?php elseif (!isset($_SESSION["user"])): ?>
                <li>
                    <a href="<?= BASE_URL; ?>/auth/register.php">Register</a>
                </li>
                <li>
                    <a href="<?= BASE_URL; ?>/auth/login.php">Login</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div>
