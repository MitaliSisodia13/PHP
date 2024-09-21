<?php
include 'Book.php';

$response = ['success' => false, 'errors' => [], 'book' => []];
$title = $author = $year = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = $_POST['year'];

        try {
            if (empty($title)) {
                $response['errors']['title'] = "Title is required.";
            }

        if (empty($author)) {
            $response['errors']['author'] = "Author is required.";
        }elseif (!preg_match('/^[a-zA-Z\s]+$/', $author)) {
            $response['errors']['author'] = "Author name must contain only letters and spaces.";
        }

        if (empty($year)) {
            $response['errors']['year'] = "Publication year is required.";
        }elseif (!is_numeric($year) || $year < 0) {
            $response['errors']['year'] = "Invalid publication year.";
        }

        if (empty($response['errors'])) {
                $book = new Book($title, $author, $year);
                
                $response['success'] = true;
                $response['book'] = [
                    'title' => $book->getTitle(),
                    'author' => $book->getAuthor(),
                    'year' => $book->getYear(),
                ];
            }
    } catch (Exception $e) {
        $response['errors']['general'] = $e->getMessage();
    }
header('Content-Type: application/json');
    echo json_encode($response);
    exit;
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
    <form id="bookForm" method="POST" action="">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Enter book title" value="<?php echo htmlspecialchars($title); ?>" required><br>
        <span id="titleError" class="error"></span>
        
        <label>Author:</label> 
        <input type="text" name="author" placeholder="Enter author name" value="<?php echo htmlspecialchars($author); ?>" required><br>
        <span id="authorError" class="error"></span>

        <label>Publication Year:</label> 
        <input type="text" name="year" placeholder="Enter publication year" value="<?php echo htmlspecialchars($year); ?>" required><br>
        <span id="yearError" class="error"></span>
        
        <input type="submit" value="Add Book">
    </form>

    <h2 id="bookListHeading" style="display:none;">Book List</h2>
    <table id="bookTable" style="display:none;">
        <thead id="bookTableHead" style="display:none;">
            <tr><th>Title</th><th>Author</th><th>Year</th></tr>
        </thead>
        <tbody id="bookTableBody"></tbody>
    </table>


    <script>
        document.getElementById('bookForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Clear previous errors
            document.getElementById('titleError').textContent = '';
            document.getElementById('authorError').textContent = '';
            document.getElementById('yearError').textContent = '';

            // Create form data
            var formData = new FormData(this);

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'index.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // Show the book table and heading if it's the first book
                        document.getElementById('bookTable').style.display = 'table';
                        document.getElementById('bookListHeading').style.display = 'block';
                        document.getElementById('bookTableHead').style.display = 'table-header-group';

                        // Add the new book to the table
                        var bookTableBody = document.getElementById('bookTableBody');
                        var newRow = bookTableBody.insertRow();
                        newRow.innerHTML = '<td>' + response.book.title + '</td><td>' + response.book.author + '</td><td>' + response.book.year + '</td>';

                        // Clear form fields
                        document.getElementById('title').value = '';
                        document.getElementById('author').value = '';
                        document.getElementById('year').value = '';
                    } else {
                        // Display validation errors
                        if (response.errors.title) {
                            document.getElementById('titleError').textContent = response.errors.title;
                        }
                        if (response.errors.author) {
                            document.getElementById('authorError').textContent = response.errors.author;
                        }
                        if (response.errors.year) {
                            document.getElementById('yearError').textContent = response.errors.year;
                        }
                    }
                }
            };
            xhr.send(formData);
        });
    </script>
</body>
</html>