<?php
include 'Book.php';

$books = [];
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = $_POST['year'];

        $book = new Book($title, $author, $year);
        $books[] = $book;
    } catch (Exception $e) {
        $errorMsg = $e->getMessage();
    }
}
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
        <input type="text" name="title" placeholder="Enter book title"><br>
        <label>Author:</label> 
        <input type="text" name="author" placeholder="Enter author name"><br>
        <label>Publication Year:</label> 
        <input type="text" name="year" placeholder="Enter publication year"><br>
        <input type="submit" value="Add Book">
    </form>

    <?php
    if ($errorMsg) {
        echo "<p style='color:red;'>$errorMsg</p>";
    }

    if (count($books) > 0) {
        echo "<h2>Book List</h2>";
        echo "<table border='1'>
                <tr><th>Title</th><th>Author</th><th>Year</th></tr>";
        foreach ($books as $book) {
            echo "<tr><td>{$book->getTitle()}</td><td>{$book->getAuthor()}</td><td>{$book->getYear()}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No books added yet.</p>";
    }
    ?>
</body>
</html>
