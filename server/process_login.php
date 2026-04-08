<?php 

    // Start session so login state can be stored after successful authentication.
    session_start();

    require __DIR__ . '/../config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ensure both email and password are provided before attempting to authenticate the user.
        if (isset($_POST["email"]) && isset($_POST["password"])) {

            $email = $_POST["email"];
            $password = $_POST["password"];

            // Prepare query to get user data
            $getVerified = $pdo->prepare("SELECT id, email, password, verified FROM userdata WHERE email = :email");
            $getVerified->bindValue(":email", $email);

            $getVerified->execute();

            $user = $getVerified->fetch(PDO::FETCH_ASSOC);

            // Verify the provided password against the hashed password stored in the database, and check if the user's email is verified before allowing login.
            if ($user && password_verify($password, $user["password"])) {
                // Check if the user's email is verified before allowing login.
                if ($user["verified"] == 0) {
                    // User not verified, redirect with error
                    header("Location: ../forms/signin.php?error=user+not+verified");
                    exit();
                }

                // Set session variables
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["email"] = $user["email"]; 
                
                // Redirect to home on success
                header("Location: ../home/index.php?signin=success");
                exit();


            } else {
                // Invalid credentials
                header("Location: ../forms/signin.php?error=invalid+credentials");
                exit();
            }
        }
    }

?>