<?php
session_start();

// Check if all required session variables are set
if (!isset($_SESSION['full-name']) || !isset($_SESSION['email']) || !isset($_SESSION['phone-number']) || 
    !isset($_SESSION['degree']) || !isset($_SESSION['field']) || !isset($_SESSION['institute']) || !isset($_SESSION['year']) || 
    !isset($_SESSION['job_position']) || !isset($_SESSION['company_name']) || !isset($_SESSION['years_experience']) || !isset($_SESSION['job_responsibilities'])) {

    header('Location: index.php');
    exit();
}

// Initialize username
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Retrieve session variables
$fullName = $_SESSION['full-name'];
$email = $_SESSION['email'];
$phoneNumber = $_SESSION['phone-number'];
$degreeName = $_SESSION['degree'];
$fieldStudy = $_SESSION['field'];
$instituteName = $_SESSION['institute'];
$yearOfGraduation = $_SESSION['year'];
$jobTitle = $_SESSION['job_position'];
$companyName = $_SESSION['company_name'];
$yearsOfExperience = $_SESSION['years_experience'];
$responsibilities = $_SESSION['job_responsibilities'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $application = [
        'full_name' => $fullName,
        'email' => $email,
        'phone_number' => $phoneNumber,
        'degree' => $degreeName,
        'field' => $fieldStudy,
        'institute' => $instituteName,
        'graduation_year' => $yearOfGraduation,
        'job_position' => $jobTitle,
        'company_name' => $companyName,
        'years_experience' => $yearsOfExperience,
        'job_responsibilities' => $responsibilities
    ];

    $file = 'applications.json';
    $applications = [];

    // Load existing applications if the file exists
    if (file_exists($file)) {
        $applications = json_decode(file_get_contents($file), true);
    }

    // Add new application to the array
    $applications[] = $application;

    // Save the updated applications back to the JSON file
    file_put_contents($file, json_encode($applications, JSON_PRETTY_PRINT));

    // Prepare and send confirmation email (consider using a mail library)
    $to = $email;
    $subject = "Application Submitted!";
    $message = "Dear $fullName, \n\n Your application has been submitted.";

    echo "<h2>Application Submitted!</h2>";
    echo "<h2>A confirmation email has been sent to your email.</h2>";

    // Clear session data and destroy the session
    session_unset();
    session_destroy();

    // Clear the cookie if set
    if (isset($_COOKIE['username_remember'])) {
        setcookie('username_remember', '', time() - 3600, "/");
    }

    echo '<a href="login.php"><button>Logout</button></a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Review</title>
</head>
<body>
    <h1>Review Your Application</h1>
    <div class="form-container">
        <p> Full Name: <?php echo htmlspecialchars($fullName); ?><a href="personal_data.php"> Edit</a></p> 
        <p> Email: <?php echo htmlspecialchars($email); ?><a href="personal_data.php"> Edit</a></p> 
        <p> Phone Number: <?php echo htmlspecialchars($phoneNumber); ?><a href="personal_data.php"> Edit</a></p> 

        <p> Highest Degree Obtained: <?php echo htmlspecialchars($degreeName); ?><a href="background.php"> Edit</a></p>  
        <p> Field of Study: <?php echo htmlspecialchars($fieldStudy); ?><a href="background.php"> Edit</a></p> 
        <p> Institution Name: <?php echo htmlspecialchars($instituteName); ?><a href="background.php"> Edit</a></p> 
        <p> Year of Graduation: <?php echo htmlspecialchars($yearOfGraduation); ?><a href="background.php"> Edit</a></p>  

        <p> Job Title: <?php echo htmlspecialchars($jobTitle); ?><a href="work_experience.php"> Edit</a></p> 
        <p> Company Name: <?php echo htmlspecialchars($companyName); ?><a href="work_experience.php"> Edit</a></p>  
        <p> Year of Experience: <?php echo htmlspecialchars($yearsOfExperience); ?><a href="work_experience.php"> Edit</a></p>  
        <p> Responsibilities: <?php echo htmlspecialchars($responsibilities); ?><a href="work_experience.php"> Edit</a></p> 

        <form action="" method="POST">
            <button type="submit" name="submit"> Submit </button>
            <a href="experience.php"><button type="button">Previous</button></a>
        </form>
    </div>
</body>
</html>
