<?php 

    session_start();

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
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $getVerified = $pdo->prepare("SELECT id, email, password, verified FROM userdata WHERE email = :email");

            $getVerified->bindValue(":email", $email);

            $getVerified->execute();

            $user = $getVerified->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password"])) {
                if ($user["verified"] == 0) {
                    header("Location: ../forms/signin.php?error=user+not+verified");
                    exit();
                }

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["email"] = $user["email"]; 
                
                header("Location: ../home/index.php?signin=success");
                exit();


            } else {
                header("Location: ../forms/signin.php?error=invalid+credentials");
                exit();
            }
        }
    }

?>