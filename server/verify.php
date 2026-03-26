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

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["email"]) && isset($_GET["token"])) {
            $email = $_GET["email"];
            $token = $_GET["token"];

            $stmt = $pdo->prepare("SELECT * FROM userdata WHERE email = :email AND token = :token");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":token", $token);

            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
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