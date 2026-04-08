<?php
    require __DIR__ . '/../config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ensure all required fields are provided and validate the password against the defined pattern before attempting to register the user.
        if (isset($_POST["email"]) && isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["password"])) {
            // Password must have at least 10 chars, upper, lower, digit, special char
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{10,}$/';

            // Trim email and password to remove any leading/trailing whitespace, and generate a unique token for email verification.
            $email = trim($_POST["email"]);
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $password = trim($_POST["password"]);
            // Generate verification token
            $token = bin2hex(random_bytes(16)); 

            // Validate the password against the defined pattern, and if it doesn't meet the criteria, redirect back to the registration page with an error message.
            if (!preg_match($pattern, $password)) {
                header("Location: ../forms/register.php?password=invalid");
                exit();
            }

            // Hash the password securely before storing it in the database, and validate the email format to ensure it's a valid email address before attempting to register the user.
            $hash_to_store = password_hash($password, PASSWORD_DEFAULT);

            // Validate the email format to ensure it's a valid email address before attempting to register the user.
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../forms/register.php?email=invalid");
                exit();
            }

            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO userdata (username, email, password, verified, token) VALUES (:name, :email, :password, 0, :token)");
            
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":name", $fname . " " . $lname);
            $stmt->bindValue(":password", $hash_to_store);
            $stmt->bindValue(":token", $token);

            try {
                $stmt->execute();
                // TODO: Send email instead of echoing HTML
                $verificationLink = "../server/verify.php?email=$email&token=$token";
                $subject = "Verify your email!";
                $message = "Click to verify: $verificationLink";
                $headers = "From: no-reply@simplelibsystems.com";

                echo "<!DOCTYPE html> Verification link: <a href=\"$verificationLink\">$verificationLink</a>";

            } catch(PDOException $e) {

                if ($e->errorInfo[1] == 1062) {
                    // Duplicate email
                    header("Location: ../forms/register.php?error=email_taken");
                    exit();
                } else {
                    die("Error: " . $e->getMessage());
                }
                die("Error Message: " . $e->getMessage());
            }

            
        }
    }
    


?>