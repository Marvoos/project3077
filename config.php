<?php
// Database configuration file
$host = "localhost";
$dbName = "ions_sls_data";
$dbUser = "ions_sls_data";
$dbPass = "n47gU2JJJH7ScJtVQzzx";

    try {
        // Establish PDO connection with error handling
        $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Display error message if connection fails
        die("Error message: " . $e->getMessage());
    }
    
?>