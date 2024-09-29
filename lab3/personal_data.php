<?php
session_start();

$formErrors = [];
$userFullName = $userEmail = $userPhone = "";

if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
}

if (isset($_SESSION['email'])) {
    $userEmail = $_SESSION['email'];
}

if (isset($_SESSION['full-name'])) {
    $userFullName = $_SESSION['full-name'];
}

if (isset($_SESSION['phone-number'])) {
    $userPhone = $_SESSION['phone-number'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitizing and validating each field
    $userFullName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    if (empty($userFullName)) {
        $formErrors['name'] = "Full Name is required.";
    }

    $userEmail = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_EMAIL);
    if (empty($userEmail)) {
        $formErrors['email_address'] = "Email Address is required.";
    } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $formErrors['email_address'] = "Invalid email format.";
    }

    $userPhone = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_STRING);
    if (empty($userPhone)) {
        $formErrors['contact_number'] = "Contact Number is required.";
    }

    // Store data in session if there are no errors
    if (empty($formErrors)) {
        $_SESSION['full-name'] = $userFullName;
        $_SESSION['email'] = $userEmail;
        $_SESSION['phone-number'] = $userPhone;

        header('Location: background_data.php');
        exit();
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();

    if (isset($_COOKIE['remember_user'])) {
        setcookie('remember_user', '', time() - 3600, "/");
    }

    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Information</title>
</head>
<body>
    <h1>Your Personal Information</h1>
    <div class="form-container">
        <form action="" method="POST">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($userFullName); ?>" placeholder="Enter your full name">
            <span class="error-message"><?php echo $formErrors['name'] ?? ''; ?></span><br>

            <label for="email_address">Email Address</label>
            <input type="email" name="email_address" id="email_address" value="<?php echo htmlspecialchars($userEmail); ?>" placeholder="Enter your email">
            <span class="error-message"><?php echo $formErrors['email_address'] ?? ''; ?></span><br>

            <label for="contact_number">Phone Number</label>
            <input type="text" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($userPhone); ?>" placeholder="Enter your phone number">
            <span class="error-message"><?php echo $formErrors['contact_number'] ?? ''; ?></span><br>

            <button type="submit" name="submit_info">Proceed</button>
            <form action="" method="POST">
            <a href="login.php"><button class="logout-button" type="submit" name="logout">LOGOUT</button></a>
    </form>
        </form>
    </div>
</body>
</html>
