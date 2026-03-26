<?php
    $host = "localhost";
    $dbName = "sls_data";
    $dbUser = "root";
    $dbPass = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error message: " . $e->getMessage());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["email"]) && isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["password"])) {
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{10,}$/';

            $email = trim($_POST["email"]);
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $password = trim($_POST["password"]);
            $token = bin2hex(random_bytes(16));

            if (!preg_match($pattern, $password)) {
                header("Location: ../forms/register.php?password=invalid");
                exit();
            }

            $hash_to_store = password_hash($password, PASSWORD_DEFAULT);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../forms/register.php?email=invalid");
                exit();
            }

            $stmt = $pdo->prepare("INSERT INTO userdata (username, email, password, verified, token) VALUES (:name, :email, :password, 0, :token)");
            
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":name", $fname . " " . $lname);
            $stmt->bindValue(":password", $hash_to_store);
            $stmt->bindValue(":token", $token);

            try {
                $stmt->execute();
                $verificationLink = "../server/verify.php?email=$email&token=$token";
                $subject = "Verify your email!";
                $message = "Click to verify: $verificationLink";
                $headers = "From: no-reply@simplelibsystems.com";

                echo "<!DOCTYPE html> Verification link: <a href=\"$verificationLink\">$verificationLink</a>";

            } catch(PDOException $e) {

                if ($e->errorInfo[1] == 1062) {
                    // Apply the query string error=email_taken
                    header("Location: ../forms/register.php?error=email_taken");
                    // Exit the script immediately
                    exit();
                } else {
                    // If the error doesn't correspond to a duplicate entry error than retrieve the message from the exception
                    die("Error: " . $e->getMessage());
                }
                die("Error Message: " . $e->getMessage());
            }

            
        }
    }
    


?>