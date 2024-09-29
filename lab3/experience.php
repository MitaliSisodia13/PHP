<?php
session_start();

$formErrors = [];
$position = $companyName = $yearsOfExperience = $jobResponsibilities = "";

if (isset($_SESSION['username'])) {
    $currentUser = $_SESSION['username'];
}

if (isset($_SESSION['job_position'])) {
    $position = $_SESSION['job_position'];
}
if (isset($_SESSION['company_name'])) {
    $companyName = $_SESSION['company_name'];
}
if (isset($_SESSION['years_experience'])) {
    $yearsOfExperience = $_SESSION['years_experience'];
}
if (isset($_SESSION['job_responsibilities'])) {
    $jobResponsibilities = $_SESSION['job_responsibilities'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['back'])) {
        header('Location:   background_data.php');
        exit();
    }

    // Implementing sanitization and validation for each field
    $position = filter_input(INPUT_POST, 'job_position', FILTER_SANITIZE_STRING);
    if (empty($position)) {
        $formErrors['job_position'] = "Position is required.";
    }

    $companyName = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_STRING);
    if (empty($companyName)) {
        $formErrors['company_name'] = "Company Name is required.";
    }

    $yearsOfExperience = filter_input(INPUT_POST, 'years_experience', FILTER_SANITIZE_NUMBER_INT);
    if (empty($yearsOfExperience)) {
        $formErrors['years_experience'] = "Years of experience is required.";
    }

    $jobResponsibilities = filter_input(INPUT_POST, 'job_responsibilities', FILTER_SANITIZE_STRING);
    if (empty($jobResponsibilities)) {
        $formErrors['job_responsibilities'] = "Responsibilities are required.";
    }

    // Storing data in session once validation is done
    if (empty($formErrors)) {
        $_SESSION['job_position'] = $position;
        $_SESSION['company_name'] = $companyName;
        $_SESSION['years_experience'] = $yearsOfExperience;
        $_SESSION['job_responsibilities'] = $jobResponsibilities;

        header('Location: review.php');
        exit();
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();

    if (isset($_COOKIE['user_remember'])) {
        setcookie('user_remember', '', time() - 3600, "/");
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
    <title>Experience Information</title>
</head>
<body>
    <h1>Work Experience Details</h1>
    <div class="form-container">
        <form action="" method="POST">
            <label for="job_position">Previous Position</label>
            <input type="text" name="job_position" id="job_position" value="<?php echo htmlspecialchars($position); ?>" placeholder="Enter your previous job position">
            <span class="error-message"><?php echo $formErrors['job_position'] ?? ''; ?></span><br>

            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name" value="<?php echo htmlspecialchars($companyName); ?>" placeholder="Enter your company name">
            <span class="error-message"><?php echo $formErrors['company_name'] ?? ''; ?></span><br>

            <label for="years_experience">Years of Experience</label>
            <input type="number" name="years_experience" id="years_experience" value="<?php echo htmlspecialchars($yearsOfExperience); ?>" placeholder="Enter your years of experience">
            <span class="error-message"><?php echo $formErrors['years_experience'] ?? ''; ?></span><br>

            <label for="job_responsibilities">Key Responsibilities</label>
            <textarea name="job_responsibilities" id="job_responsibilities" placeholder="Describe your responsibilities"><?php echo htmlspecialchars($jobResponsibilities); ?></textarea>
            <span class="error-message"><?php echo $formErrors['job_responsibilities'] ?? ''; ?></span><br>

           
                <button type="submit" name="back" >Back</button>
                <button type="submit" name="next"> Next Step </button>
            </div>
        </form>
    </div>

    <form action="" method="POST">
        <button class="logout-button" type="submit" name="logout">LOGOUT</button>
    </form>
</body>
</html>
