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

    if (isset($_POST["token"]) && isset($_POST["password"])) {

        $token = $_POST["token"];

        $stmt = $pdo->prepare("SELECT * FROM passwordresets WHERE token = ?");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();

        if (!$reset || strtotime($reset['expires_at']) < time()) {
            header("Location: ../forms/signin.php?reset=invalid");
            exit();
        }

        $stmt = $pdo->prepare("SELECT * FROM userdata WHERE email = ?");
        $stmt->execute([$reset['email']]);
        $user = $stmt->fetch();

        if (!$user) {
            header("Location: ../forms/signin.php?reset=error");
            exit();
        }

        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE userdata SET password = ? WHERE email = ?");
        $stmt->execute([$newPassword, $reset['email']]);

        $stmt = $pdo->prepare("DELETE FROM passwordresets WHERE token = ?");
        $stmt->execute([$token]);

        header("Location: ../forms/signin.php?reset=success");
        exit();
    }
}
?>