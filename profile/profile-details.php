<?php include __DIR__ . '/../partials/head.php'; ?>

<?php
// Check if user is logged in
if (!isset($authUser)) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors['csrf'] = "Invalid CSRF token.";
    }

    $name = trim($_POST["name"]);

    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (!count($errors)) {
        $name = strip_tags($_POST["name"]);

        if (updateUserName($pdo, $authUser['id'], $name)) {
            // Update session user name
            $_SESSION["user"]['name'] = $name;

            // Regenerate CSRF token after successful update
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            // Set a flash message
            $_SESSION['flash_message'] = "Name successfully updated.";

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

<h2>Profile details</h2>

<?php include __DIR__ . '/partials/flash-message.php'; ?>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">
    <input type="text" name="name" placeholder="name" value="<?= htmlspecialchars($authUser['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"/>
    <br>

    <button type="submit">Update</button>
</form>

<?php if (count($errors) > 0): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li class="invalid-error-message"><?= htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
