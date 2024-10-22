<?php include __DIR__ . '/../partials/head.php'; ?>

<?php
// Check if user is logged in
if (!isset($authUser)) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);

    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (!count($errors)) {
        $userId = $authUser['id'];

        // WARNING
        $query = "UPDATE users SET name = '$name' WHERE id = $userId";

        $result = $pdo->query($query);

        if ($result->rowCount() > 0) {
            $name = $result->fetch(PDO::FETCH_ASSOC)['name'];

            // Update session user name
            $_SESSION["user"]['name'] = $name;

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

<form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
    <input type="text" name="name" placeholder="name" value="<?= $authUser['name']; ?>" />
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
