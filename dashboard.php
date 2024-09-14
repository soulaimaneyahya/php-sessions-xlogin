<?php include __DIR__ . '/partials/head.php'; ?>

<?php
// Check if user is logged in
if (!isset($authUser)) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}
?>

<hr />

<h2>#<?= $authUser['id']; ?></h2>

<p>Your name is: <b><?= $authUser['name']; ?></b></p>
<p>Your username is: <b><?= $authUser['username']; ?></b></p>
<p>Your phone is: <b><?= $authUser['phone']; ?></b</p>
<p>Your email is: <b><?= $authUser['email']; ?></b</p>

<hr />

<?php include __DIR__ . '/partials/footer.php'; ?>
