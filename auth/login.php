<?php include __DIR__ . '/../partials/head.php'; ?>

<?php
include __DIR__ . '/../database/data.php';

// Check if user is logged in
if (isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "/dashboard.php");
    exit;
}

function findUserByUsername(array $users, string $username) {
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return $user;
        }
    }

    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = findUserByUsername($users, $username);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user"] = $user;

        header("Location: " . BASE_URL . "/dashboard.php");
        exit;
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<h2>Login</h2>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" name="username" placeholder="Username" required /><br>
    <input type="password" name="password" placeholder="Password" required /><br>
    <button type="submit">Login</button>
</form>

<?php if(isset($error_message)): ?>
    <ul>
        <li class="invalid-error-message"><?= $error_message; ?></li>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
