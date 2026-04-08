<?php
require __DIR__ . '/../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["token"]) && isset($_POST["password"])) {

        $token = $_POST["token"];
        // Validate the token and ensure it hasn't expired, then update the user's password if valid.
        $stmt = $pdo->prepare("SELECT * FROM passwordresets WHERE token = ?");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();
        // If the token is invalid or expired, redirect back to the sign-in page with an error message.
        if (!$reset || strtotime($reset['expires_at']) < time()) {
            header("Location: ../forms/signin.php?reset=invalid");
            exit();
        }

        // Retrieve the user associated with the reset request, hash the new password, update it in the database, and delete the used token.
        $stmt = $pdo->prepare("SELECT * FROM userdata WHERE email = ?");
        $stmt->execute([$reset['email']]);
        $user = $stmt->fetch();

        // If the user doesn't exist (which shouldn't happen if the reset request is valid), redirect back with an error message.
        if (!$user) {
            header("Location: ../forms/signin.php?reset=error");
            exit();
        }  

        // Hash the new password securely before storing it in the database.
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Update the user's password in the database and remove the used reset token to prevent reuse.
        $stmt = $pdo->prepare("UPDATE userdata SET password = ? WHERE email = ?");
        $stmt->execute([$newPassword, $reset['email']]);


        // Delete the used token to prevent reuse and redirect back to the sign-in page with a success message.
        $stmt = $pdo->prepare("DELETE FROM passwordresets WHERE token = ?");
        $stmt->execute([$token]);

        header("Location: ../forms/signin.php?reset=success");
        exit();
    }
}
?>