<?php include __DIR__ . '/../config/app.php'; ?>

<?php
// Check if user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

session_unset();
session_destroy();
header("Location: " . BASE_URL . "/auth/login.php");
exit;
?>
