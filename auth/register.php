<?php include __DIR__ . '/../partials/head.php'; ?>

<?php
// Check if user is logged in
if (isset($authUser)) {
    header("Location: " . BASE_URL . "/dashboard.php");
    exit;
}

$errors = [];

function registerUser(
    PDO $pdo,
    string $name,
    string $username,
    string $email,
    string $phone,
    string $password,
) {
    $sql = "INSERT INTO users (username, name, email, phone, password, created_at, updated_at) 
            VALUES (:username, :name, :email, :phone, :password, NOW(), NOW())";

    $statement = $pdo->prepare($sql);

    // Bind parameters securely
    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->bindValue(':name', $name, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':phone', $phone, PDO::PARAM_STR);
    $statement->bindValue(':password', hashPassword($password), PDO::PARAM_STR);

    if($statement->execute()) {
        $user = findUserByUsername($pdo, $username);

        if (authAttempt($user, $password)) {
            $_SESSION["user"]['name'] = $name;
            $_SESSION["user"]['username'] = $username;
            $_SESSION["user"]['email'] = $email;

            header("Location: " . BASE_URL . "/dashboard.php");
            exit;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    if (empty($name)) {
        $errors['name'] = "name is required.";
    }

    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($email)) {
        $errors['email'] = "email is required.";
    }

    if (empty($phone)) {
        $errors['phone'] = "phone is required.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    if (!count($errors)) {
        $registeredUser = registerUser(
            $pdo,
            $name,
            $username,
            $email,
            $phone,
            $password,
        );

        if ($registeredUser !== null) {
            $_SESSION["user"]['id'] = $registeredUser['id'];
            $_SESSION["user"]['name'] = $registeredUser['name'];
            $_SESSION["user"]['username'] = $registeredUser['username'];
            $_SESSION["user"]['email'] = $registeredUser['email'];
            $_SESSION["user"]['phone'] = $registeredUser['phone'];

            header("Location: " . BASE_URL . "/dashboard.php");
            exit;
        }
    }
}
?>

<h2>Register</h2>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" name="name" placeholder="Name" value="<?= $name ?? '' ?>" />
    <br>

    <input type="text" name="username" placeholder="Username" value="<?= $username ?? '' ?>" />
    <br>

    <input type="email" name="email" placeholder="Email" value="<?= $email ?? '' ?>" />
    <br>

    <input type="tel" name="phone" placeholder="Phone" value="<?= $phone ?? '' ?>" />
    <br>

    <input type="password" name="password" placeholder="Password" />
    <br>

    <button type="submit">Register</button>
</form>

<?php if (count($errors) > 0): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li class="invalid-error-message"><?= htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
