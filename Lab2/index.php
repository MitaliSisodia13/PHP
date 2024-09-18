<?php
include 'Book.php';
session_start(); // Start the session

$errorMsg = "";
$title = $author = $year = "";

// Initialize books array from session or create an empty array
if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [];
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        // Retrieve form data
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = $_POST['year'];

        try {
        // Validate the input data
        if (empty($title) || empty($author) || empty($year)) {
            throw new Exception("All fields are required.");
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $author)) {
            throw new Exception("Author name must contain only letters and spaces.");
        }

        if (!is_numeric($year) || $year < 0) {
            throw new Exception("Invalid publication year.");
        }

        // Store book data as an associative array
        $book = [
            'title' => $title,
            'author' => $author,
            'year' => $year
        ];

        // Append the new book to the books array in the session
        $_SESSION['books'][] = $book;

        $title = $author = $year = "";

    } catch (Exception $e) {
        $errorMsg = $e->getMessage();
    }
}

// Retrieve the updated books array from the session
$books = $_SESSION['books'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 45px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        form input[type="text"], form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form input[type="submit"] {
            background-color: purple;
            color: white;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: purple;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Add a New Book</h1>
    <form method="POST" action="">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Enter book title" value="<?php echo htmlspecialchars($title); ?>" required><br>
        <label>Author:</label> 
        <input type="text" name="author" placeholder="Enter author name" value="<?php echo htmlspecialchars($author); ?>" required><br>
        <label>Publication Year:</label> 
        <input type="text" name="year" placeholder="Enter publication year" value="<?php echo htmlspecialchars($year); ?>" required><br>
        <input type="submit" value="Add Book">
    </form>

    <?php
    if ($errorMsg) {
        echo "<p style='color:red;'>$errorMsg</p>";
    }

    if (count($books) > 0) {
        echo "<h2>Book List</h2>";
        echo "<table>
                <tr><th>Title</th><th>Author</th><th>Year</th></tr>";
        foreach ($books as $book) {
            echo "<tr><td>{$book['title']}</td><td>{$book['author']}</td><td>{$book['year']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No books added yet.</p>";
    }
    ?>
</body>
</html>
