<?php
    // Start session to determine whether a user is already signed in.
    session_start();
    // If the user is already logged in, redirect them to their profile page instead of showing the sign-in form.
    $isLoggedIn = isset($_SESSION["user_id"]);

    if ($isLoggedIn) {
        header("Location: ../user/profile.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--SEO Meta tags-->
    <!--Character set definition-->
    <meta charset="UTF-8">
    <!--Standard viewport definition-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Defining the author-->
    <meta name="author" content="Kayden Ions">
    <!--The description of the site-->
    <meta name="description" content="A local library service to view and hold books">
    <!--Linking the external stylesheet-->
    <link rel="stylesheet" href="../stylesheets/nav.css">
    <link rel="stylesheet" href="../stylesheets/style.css">
    <link rel="stylesheet" href="../stylesheets/formstyle.css">

    <script src="https://kit.fontawesome.com/7d8aa418e1.js" crossorigin="anonymous"></script>
    
    <title>SLS</title>
</head>
<body class="bg-main">  
    <nav class="nav">
        <div class="nav-inner flex justify-between items-center p-lg">
            <h2 class="nav-title">SLS</h2>
            
            <div class="flex items-center">
                <a href="../forms/signin.php" class="btn btn-outline  m-md">Sign in</a>
                <a href="../forms/register.php" class="btn btn-primary">Register</a> 
            </div>
        </div>
        <div class="nav-mobile flex justify-between items-center p-md">
            <h2 class="nav-title">SLS</h2>

            <button class="hamburger" id="hamburger-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </nav>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">

        <ul class="mobile-list">
            <li><a href="../home/index.php">Home</a></li>
            <li><a href="../browse/browse.php">Browse</a></li>
            <li><a href="../user/my_books.php">My Books</a></li>
            <li><a href="../user/history.php">History</a></li>
        </ul>

        <ul class="mobile-list">
            <li><a href="../info/about.html">About</a></li>
            <li><a href="../info/faq.html">FAQ</a></li>
            <li><a href="../info/contact.php">Contact</a></li>
        </ul>

        <div class="mobile-auth">
            <a href="../forms/signin.php" class="btn btn-outline">Sign in</a>
            <a href="../forms/register.php" class="btn btn-primary">Register</a>
        </div>

    </div>
    <aside class="sidebar">
        <ul class="sidebar-list">
            <li class="sidebar-item active">
                <a href="../home/index.php" class="sidebar-link">
                    <i class="fa-solid fa-house"></i> Home
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../browse/browse.php" class="sidebar-link">
                    <i class="fa-solid fa-magnifying-glass"></i> Browse
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../user/my_books.php" class="sidebar-link">
                    <i class="fa-solid fa-book"></i> My Books
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../user/history.php" class="sidebar-link">
                    <i class="fa-solid fa-clock-rotate-left"></i> History
                </a>
            </li>
        </ul>
        <ul class="sidebar-list">
            <li class="sidebar-item">
                <a href="../about/about.html" class="sidebar-link">
                    <i class="fa-solid fa-circle-info"></i> About
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../info/faq.html" class="sidebar-link">
                    <i class="fa-solid fa-clipboard-question"></i> FAQ
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../info/contact.php" class="sidebar-link">
                    <i class="fa-solid fa-envelope"></i> Contact
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../status/index.php" class="sidebar-link">
                    <i class="fa-solid fa-signal"></i> Status
                </a>
            </li>
        </ul>
        <ul class="sidebar-list">
            <li class="sidebar-item">
                <a href="../admin/admin_books.php" class="sidebar-link">
                    <i class="fa-solid fa-right-to-bracket"></i> Staff Portal
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main forms">
        <div class="flex flex-col items-center justify-center">
            <form class="form" method="POST" action="../server/process_login.php">
                <h2>Sign In</h2>
                <p>Sign in using your email and password</p>

                <div class="form-fields flex flex-col items-center justify-center">
                    <input class="text-input" type="email" name="email" autocomplete="email" placeholder="Email Address" required>
                    <div class="pass-div flex justify-center items-center">
                        <input class="text-input" type="password" name="password" placeholder="Password" required><span id="toggle-pass" class="fa-solid fa-eye"></span>
                    </div>
                    <a class="link" href="../forms/forgotpass.php">Forgot your password?</a>
                </div>
                <div>
                    <input class="btn btn-primary w-full" type="submit" class="button">
                    <p>Don't have an account? <a class="link" href="register.php">Register</a></p>
                </div>
                
            </form>
        </div>
    </main>

    <script src="../scripts/navScript.js"></script>
    <script src="../scripts/inputScript.js"></script>
</body>
</html>