<?php
    // Destroy the current session and sign the user out.
    session_start();
    // Clear all session variables and destroy the session to log the user out, then redirect to the home page.
    session_unset();
    session_destroy();
    header("Location: ../home/index.php");
    exit();

?>