<?php
require 'vendor/autoload.php';
 
use App\AppLogger; // Make sure the class name matches
 
$logger = new AppLogger(); // Instantiate the AppLogger class
$logger->logInfo('This is an info message.');
$logger->logError('This is an error message.');
 
 