<?php 
session_start();

$dataFile = 'users.json';
$accountList = [];
$errorMessages = [];

// Load user accounts from JSON file
if (file_exists($dataFile) && filesize($dataFile) > 0) {
    $jsonContent = file_get_contents($dataFile);
    $accountList = json_decode($jsonContent, true);
}

// Setting cookie 
$savedUsername = isset($_COOKIE['saved_username']) ? $_COOKIE['saved_username'] : '';

// Handling submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $inputUsername = trim($_POST['login_name'] ?? '');
    $inputPassword = $_POST['login_pass'] ?? '';
    $keepLoggedIn = isset($_POST['stay_signed_in']);

    // Validating inputs
    if (empty($inputUsername)) {
        $errorMessages['login_name'] = "Username cannot be empty.";
    }

    if (empty($inputPassword)) {
        $errorMessages['login_pass'] = "Password cannot be empty.";
    }

    // Check for errors and authenticate user
    if (empty($errorMessages)) {
        $userExists = false;

        foreach($accountList as $account) {
            if ($account['username'] === $inputUsername) {
                $userExists = true;

                if (password_verify($inputPassword, $account['password'])) {

                    session_regenerate_id(true);

                    // Store user information in session
                    $_SESSION['username'] = $inputUsername;
                    $_SESSION['email'] = $account['email'];

                    // Set cookie for remembering username
                    if ($keepLoggedIn) {
                        setcookie('saved_username', $inputUsername, time() + (7 * 24 * 60 * 60), "/");
                    } else {
                        if (isset($_COOKIE['saved_username'])) {
                            setcookie('saved_username', '', time() - 3600, "/");
                        }
                    }

                    // Redirect to dashboard
                    header('Location: personal_data.php');
                    exit();
                } else {
                    $errorMessages['login_pass'] = "Password is incorrect.";
                }
                break;
            }
        }
        if (!$userExists) {
            $errorMessages['login_name'] = "Username not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Login</title>
</head>
<body>
    <h1>User Login</h1>
    <div class="form-container">
        <form action="" method="post">

            <label for="login_name">Login Name</label>
            <input type="text" name="login_name" id="login_name" value="<?php echo htmlspecialchars($savedUsername); ?>" placeholder="Enter login name" >
            <span class="login-error"><?php echo $errorMessages['login_name'] ?? ''; ?></span><br>

            <label for="login_pass">Password</label>
            <input type="password" name="login_pass" id="login_pass" placeholder="Enter your password" >
            <span class="login-error"><?php echo $errorMessages['login_pass'] ?? ''; ?></span><br>

            <label for="stay_signed_in">
                <input type="checkbox" name="stay_signed_in" id="stay_signed_in" <?php if (!empty($savedUsername)) echo 'checked'; ?>>
                Stay Signed In
            </label><br>

            <input type="submit" name="login_submit" value="Log In">       
        </form>

        <p>New user? <a href="register.php">Create an Account</a></p>
    </div>
</body>
</html>
