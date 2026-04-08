<?php
    require __DIR__ . '/../config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["email"])) {
            $email = $_POST["email"];
            $token = bin2hex(random_bytes(16));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            $stmt = $pdo->prepare("SELECT * FROM userdata WHERE email = ?");
            $stmt->execute([$email]);

            if (!$stmt->fetch()) {
                header("Location: ../forms/signin.php?reset=sent");
                exit();
            }

            $stmt = $pdo->prepare("INSERT INTO passwordresets (email, token, expires_at) VALUES (:email, :token, :expires_at)");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":token", $token);
            $stmt->bindValue(":expires_at", $expiry);

            $stmt->execute();

            $resetLink = "https://ions.myweb.cs.uwindsor.ca/COMP3077/sls/forms/reset_pass.php?token=$token";
            $subject = "Reset your password!";

            $message = "Click to reset your password: $resetLink";
            $headers = "From: no-reply@simplelibsystems.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (mail($email, $subject, $message, $headers)) {
                header("Location: ../forms/signin.php?reset=sent");
                exit();
            } else {
                echo "Reset link: <a href='$resetLink'>$resetLink</a>";
                exit();
            }
        
        }
    }
    


?>