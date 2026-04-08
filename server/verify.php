<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["email"]) && isset($_GET["token"])) {
        $email = $_GET["email"];
        $token = $_GET["token"];

        $updateToken = $pdo->prepare("
            UPDATE userdata 
            SET verified = 1, token = NULL 
            WHERE email = :email AND token = :token
        ");
        $updateToken->bindValue(":email", $email);
        $updateToken->bindValue(":token", $token);
        $updateToken->execute();

        if ($updateToken->rowCount() > 0) {
            // Token matched and user is now verified
            header("Location: ../forms/signin.php?validation=success");
        } else {
            // Token didn't match, could be already verified or invalid link
            header("Location: ../forms/signin.php?validation=already_verified");
        }
        exit();
        
    } else {
        header("Location: ../forms/register.php?validation=nodata");
        exit();
    }
}
?>