<?php

class Book {
    private $title;
    private $author;
    private $year;

    public function __construct($title, $author, $year) {
        $this->setTitle($title);
        $this->setAuthor($author);
        $this->setYear($year);
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        if (empty($title)) {
            throw new Exception("Title cannot be empty");
        }
        $this->title = $title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        if (empty($author)) {
            throw new Exception("Author cannot be empty");
        }
        if (!preg_match('/^[a-zA-Z\s]+$/', $author)) {
            throw new Exception("Author must contain only letters and spaces");
        }
        $this->author = $author;
    }
    

    public function getYear() {
        return $this->year;
    }

    public function setYear($year) {
        if (!is_numeric($year) || $year < 0) {
            throw new Exception("Invalid publication year");
        }
        $this->year = $year;
    }
}
?>
