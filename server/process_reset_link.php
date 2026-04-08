<?php
    require __DIR__ . '/../config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["email"])) {
            $email = $_POST["email"];
            $token = bin2hex(random_bytes(16));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            $stmt = $pdo->prepare("INSERT INTO passwordresets (email, token, expires_at) VALUES (:email, :token, :expires_at)");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":token", $token);
            $stmt->bindValue(":expires_at", $expiry);

            $stmt->execute();
            $resetLink = "../forms/reset_pass.php?token=$token";

            echo "Email sent: <a href=\"$resetLink\"> $resetLink </a>";
            
        }
    }
    


?>