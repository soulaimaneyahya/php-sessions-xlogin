<?php include __DIR__ . '/../partials/head.php'; ?>

<?php
// Check if user is logged in
if (!isset($authUser)) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = trim($_POST["password"]);

    if (empty($password)) {
        $errors['password'] = "password is required.";
    }

    if (!count($errors)) {
        if (updateUserPassword($pdo, $authUser['id'], hashPassword($password))) {
            // Set a flash message
            $_SESSION['flash_message'] = "Password successfully updated.";

            // Reload the page
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit;
        } else {
            $errors['db'] = "Failed to update profile. Please try again later.";
        }
    }
}
?>

<hr />

<h2>Change password</h2>

<?php include __DIR__ . '/partials/flash-message.php'; ?>

<form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
    <input type="password" name="password" placeholder="password" />
    <br>

    <button type="submit">Update</button>
</form>

<?php if (count($errors) > 0): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li class="invalid-error-message"><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
