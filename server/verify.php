<?php
    require __DIR__ . '/../config.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Validate the email and token parameters from the verification link, then update the user's verification status in the database if valid.
        if (isset($_GET["email"]) && isset($_GET["token"])) {
            
            $email = $_GET["email"];
            $token = $_GET["token"];
            
            // Prepare a query to find the user with the provided email and token, and if a matching user is found, update their verification status to verified and clear the token.
            $stmt = $pdo->prepare("SELECT * FROM userdata WHERE email = :email AND token = :token");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":token", $token);

            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // If a matching user is found, update their verification status to verified and clear the token, then redirect to the sign-in page with a success message. If no matching user is found, redirect back to the registration page with an error message.
            if ($user) {
                $updateToken = $pdo->prepare("UPDATE userdata SET verified = 1, token = NULL WHERE email = :email");
                $updateToken->bindValue(":email", $email);
                $updateToken->execute();
                header("Location: ../forms/signin.php?validation=success");
                exit();
            } else {
                header("Location: ../forms/register.php?validation=failure");
                exit();
            }
            
        }
        else {
            header("Location: ../forms/register.php?validation=nodata");
            exit();
        }
    }
?>