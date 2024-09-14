<?php include __DIR__ . '/../partials/head.php'; ?>

<?php
include __DIR__ . '/../database/data.php';

// Check if user is logged in
if (isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "/dashboard.php");
    exit;
}

// Function to hash password
function hashPassword(string $password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to register a new user
function registerUser(array $users, string $name, string $username, string $email, string $password) {
    $hashedPassword = hashPassword($password);
    $user = [
        'id' => uniqid(),
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword
    ];
    array_push($users, $user);

    return $user;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Register user
    $registeredUser = registerUser($users, $name, $username, $email, $password);

    // Store registered user in session
    $_SESSION["user"] = $registeredUser;

    header("Location: " . BASE_URL . "/dashboard.php");
    exit;
}
?>

<h2>Register</h2>
<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
