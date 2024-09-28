<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="index.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="remember">Remember Me:</label>
        <input type="checkbox" id="remember" name="remember"><br>
        <input type="submit" value="Login">
    </form>
    <p>Not a user? <a href="register.php">Register here</a></p>
</body>
</html>

<?php
session_start();

$rememberedUsername = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Load user data
    $usersFile = 'users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    // Validate user
    $userFound = false;
    foreach ($users as $user) {
        if ($user['username'] == $username && password_verify($password, $user['password'])) {
            $userFound = true;
            break;
        }
    }

    if ($userFound) {
        // Set session
        $_SESSION['username'] = $username;

        // Remember Me feature
        if ($remember) {
            setcookie('username', $username, time() + (7 * 24 * 60 * 60)); // 7 days
        } else {
            setcookie('username', '', time() - 3600); // Expire cookie
        }

        // Redirect to job application form
        header('Location: application.php');
        exit();
    } else {
        echo "Invalid username or password. <a href='login.html'>Try again</a>";
    }
}
?>
