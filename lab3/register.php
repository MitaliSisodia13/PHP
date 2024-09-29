<?php

$userDataFile = 'users.json';
$userAccounts = [];
$registrationErrors = [];

// Load user accounts from JSON file
if (file_exists($userDataFile) && filesize($userDataFile) > 0) {
    $jsonContent = file_get_contents($userDataFile);
    $userAccounts = json_decode($jsonContent, true);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $newUsername = trim($_POST['user_name'] ?? '');
    $newEmail = trim($_POST['user_email'] ?? '');
    $newPassword = $_POST['user_password'] ?? '';

    // Validate inputs
    if (empty($newUsername)) {
        $registrationErrors['user_name'] = "Username is required.";
    }

    if (empty($newEmail)) {
        $registrationErrors['user_email'] = "Email is required.";
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $registrationErrors['user_email'] = "Invalid email format.";
    }

    if (empty($newPassword)) {
        $registrationErrors['user_password'] = "Password is required.";
    }

    if (empty($registrationErrors)) {

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $newUserAccount = [
            'username' => $newUsername,
            'email' => $newEmail,
            'password' => $hashedPassword
        ];

        $userAccounts[] = $newUserAccount;

        file_put_contents($userDataFile, json_encode($userAccounts, JSON_PRETTY_PRINT));

        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Registration</title>
</head>
<body>
    <h1>Create an Account</h1>
    <div class="form-container">
        <form action="" method="post">

            <label for="user_name">Username</label>
            <input type="text" name="user_name" id="user_name" value="<?php echo isset($newUsername) ? htmlspecialchars($newUsername) : ''; ?>" placeholder="Enter your username">
            <span class="error"><?php echo $registrationErrors['user_name'] ?? ''; ?></span><br>

            <label for="user_email">Email</label>
            <input type="email" name="user_email" id="user_email" value="<?php echo isset($newEmail) ? htmlspecialchars($newEmail) : ''; ?>" placeholder="Enter your email">
            <span class="error"><?php echo $registrationErrors['user_email'] ?? ''; ?></span><br>

            <label for="user_password">Password</label>
            <input type="password" name="user_password" id="user_password" placeholder="Enter your password">
            <span class="error"><?php echo $registrationErrors['user_password'] ?? ''; ?></span><br>

            <input type="submit" name="register_user" value="Register">       
        </form>
        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>
</body>
</html>
