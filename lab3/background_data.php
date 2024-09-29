<?php
session_start();

$errors = [];
$degreeName = $fieldStudy = $instituteName = $graduationYear = "";
$username = ""; // Initialize username

// Check for session variables
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Retrieve username if set
}

if (isset($_SESSION['degree'])) {
    $degreeName = $_SESSION['degree'];
}
if (isset($_SESSION['field'])) {
    $fieldStudy = $_SESSION['field'];
}
if (isset($_SESSION['institute'])) {
    $instituteName = $_SESSION['institute'];
}
if (isset($_SESSION['year'])) {
    $graduationYear = $_SESSION['year'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Handle "Previous" button click
    if (isset($_POST['previous'])) {
        header('Location: experience.php'); // Adjusted to redirect correctly
        exit();
    }

    // Implementing sanitization and validation for each field
    $degreeName = filter_input(INPUT_POST, 'degree', FILTER_SANITIZE_STRING);
    if (empty($degreeName)) {
        $errors['degree'] = "Degree is required.";
    }

    $fieldStudy = filter_input(INPUT_POST, 'field', FILTER_SANITIZE_STRING);
    if (empty($fieldStudy)) {
        $errors['field'] = "Field of study is required.";
    }

    $instituteName = filter_input(INPUT_POST, 'institute', FILTER_SANITIZE_STRING);
    if (empty($instituteName)) {
        $errors['institute'] = "Institute name is required.";
    }

    $graduationYear = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_STRING);
    if (empty($graduationYear)) {
        $errors['year'] = "Graduation year is required.";
    }

    // Storing data in session once validation is done
    if (empty($errors)) {
        $_SESSION['degree'] = $degreeName;
        $_SESSION['field'] = $fieldStudy;
        $_SESSION['institute'] = $instituteName;
        $_SESSION['year'] = $graduationYear;

        header('Location: experience.php');
        exit();
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();

    if (isset($_COOKIE['username_remember'])) {
        setcookie('username_remember', '', time() - 3600, "/");
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
    <title>Educational Background</title>
</head>
<body>
    <h1>Educational Background</h1>
    <div class="form-container">
        <form action="" method="POST">
            <label for="degree">Highest Degree Obtained</label>
            <input type="text" name="degree" id="degree" value="<?php echo htmlspecialchars($degreeName); ?>" placeholder="Enter your degree name">
            <span class="error"><?php echo isset($errors['degree']) ? $errors['degree'] : ''; ?></span><br>

            <label for="field">Field of Study</label>
            <input type="text" name="field" id="field" value="<?php echo htmlspecialchars($fieldStudy); ?>" placeholder="Enter your field of study">
            <span class="error"><?php echo isset($errors['field']) ? $errors['field'] : ''; ?></span><br>

            <label for="institute">Name of Institution</label>
            <input type="text" name="institute" id="institute" value="<?php echo htmlspecialchars($instituteName); ?>" placeholder="Enter your institute name">
            <span class="error"><?php echo isset($errors['institute']) ? $errors['institute'] : ''; ?></span><br>

            <label for="year">Year of Graduation</label>
            <input type="text" name="year" id="year" value="<?php echo htmlspecialchars($graduationYear); ?>" placeholder="Enter your graduation year">
            <span class="error"><?php echo isset($errors['year']) ? $errors['year'] : ''; ?></span><br>

            <div>
                <button type="submit" name="previous">Previous</button>
                <button type="submit" name="next">Next Step</button>
            </div>
           
        </form>
    </div>

    <form action="" method="POST">
            <button class="logout-button" type="submit" name="logout">LOGOUT</button>
    </form>
    
</body>
</html>
