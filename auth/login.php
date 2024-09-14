<?php include __DIR__ . '/../partials/head.php'; ?>

<?php
// Check if user is logged in
if (isset($authUser)) {
    header("Location: " . BASE_URL . "/dashboard.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    if (!count($errors)) {
        $user = findUserByUsername($pdo, $username);

        if ($user !== null && authAttempt($user, $password)) {
            $_SESSION["user"]['id'] = $user['id'];
            $_SESSION["user"]['name'] = $user['name'];
            $_SESSION["user"]['username'] = $user['username'];
            $_SESSION["user"]['email'] = $user['email'];
            $_SESSION["user"]['phone'] = $user['phone'];

            header("Location: " . BASE_URL . "/dashboard.php");
            exit;
        }

        $errors['credentials'] = "Invalid username or password";
    }
}
?>

<h2>Login</h2>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
    <br>

    <input type="password" name="password" placeholder="Password" />
    <br>

    <button type="submit">Login</button>
</form>

<?php if (count($errors) > 0): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li class="invalid-error-message"><?= htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
