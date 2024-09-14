<?php include __DIR__ . '/../config/app.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['security-level'])) {
    setSecurityLevel($_POST['security-level']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lorem ipsum dolor sit amet.</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <form method="POST">
        <label for="security-level">Security Level:</label>
        <select id="security-level" name="security-level" onchange="this.form.submit()">
            <option
                value="low"
                <?= (isset($_COOKIE['security_level']) && $_COOKIE['security_level'] === 'low') ? 'selected' : '' ?>
            >
                <span>Low</span>
            </option>
            <option
                value="high"
                <?= (isset($_COOKIE['security_level']) && $_COOKIE['security_level'] === 'high') ? 'selected' : '' ?>
            >
                <span>High</span>
            </option>
        </select>
    </form>

    <hr>

    <nav>
        <div>
            <?php if (isset($authUser)): ?>
                <?php if (isset($_COOKIE['security_level']) && $_COOKIE['security_level'] === 'low'): ?>
                    <a href="<?= BASE_URL; ?>/">
                        <b>Welcome back: <?= $authUser['name'] ?></b>
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL; ?>/">
                        <b>Welcome back: <?= htmlspecialchars($authUser['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></b>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
            <ul>
                <li>
                    <a href="<?= BASE_URL; ?>/">Home</a>
                </li>
                <?php if (isset($authUser)): ?>
                    <li>
                        <a href="<?= BASE_URL; ?>/dashboard.php">Dashboard</a>
                    </li>

                    <!-- x -->
                    <?php if (isset($_COOKIE['security_level']) && $_COOKIE['security_level'] === 'low'): ?>
                        <li>
                            <a href="<?= BASE_URL; ?>/profile/profile-details-vuln.php">Profile details vuln</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= BASE_URL; ?>/profile/profile-details.php">Profile details</a>
                        </li>
                    <?php endif; ?>

                    <!-- x -->
                    <?php if (isset($_COOKIE['security_level']) && $_COOKIE['security_level'] === 'low'): ?>
                        <li>
                            <a href="<?= BASE_URL; ?>/profile/change-password-vuln.php">Change password vuln</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= BASE_URL; ?>/profile/change-password.php">Change password</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?= BASE_URL; ?>/auth/logout.php">Logout</a>
                    </li>
                <?php elseif (!isset($authUser)): ?>
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
