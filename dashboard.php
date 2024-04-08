<?php include __DIR__ . '/partials/head.php'; ?>

<?php
// Check if user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

// Get logged in user
$user = $_SESSION["user"];
?>

<h2>Welcome, <?= $user['name']; ?>!</h2>
<p>Your username is: <?= $user['username']; ?></p>
<p>Your email is: <?= $user['email']; ?></p>

<?php include __DIR__ . '/partials/footer.php'; ?>