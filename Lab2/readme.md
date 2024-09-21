# Book Management System

This is a basic PHP-based Book Management System developed using Object-Oriented Programming (OOP) principles. The system allows users to input book details (title, author, and publication year) via a web form and stores them in an array as objects. The application includes input validation, error handling, and displays a list of the added books.

## Features

- Add books via a web form (Title, Author, Publication Year).
- Validation to ensure no field is left blank and the year is a valid number.
- Error handling with try-catch blocks for invalid inputs.
- Displays a list of books in a table format.
- Error messages shown for invalid inputs.

## Contents

- HTML form for user input
- PHP script for handling form submission and validation
- AJAX handling to dynamically update content without reloading the page

## Files

- **index.php**: The main file that contains the HTML form, handles form submissions, and displays the list of books.
- **Book.php**: This file defines the `Book` class, including validation methods for title, author, and publication year.

### Prerequisites

To run this project locally, you need to set up a local server environment that supports PHP, such as:

- [XAMPP] (for Windows, macOS, Linux)

These tools come with Apache and PHP pre-installed, which are required to run PHP scripts.

