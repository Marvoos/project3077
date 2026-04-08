<?php
// Database configuration file
// TODO: Move these to environment variables for security
$host = "localhost";
$dbName = "sls_data";
$dbUser = "root";
$dbPass = "";

    try {
        // Establish PDO connection with error handling
        $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Display error message if connection fails
        die("Error message: " . $e->getMessage());
    }
    
?>