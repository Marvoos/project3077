<?php
    // Start session to prevent signed-in users from accessing the registration form.
    session_start();

    $isLoggedIn = isset($_SESSION["user_id"]);
    // If the user is already logged in, redirect them to their profile page instead of showing the registration form.
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
                <?php if ($isLoggedIn): ?>
                    <a href="../server/signout.php" class="btn btn-primary m-md">Sign out</a>
                    <a href="../user/profile.php" class="nav-link">
                        <i class="fa-solid fa-user"></i>
                    </a>
                <?php else: ?>
                    <a href="../forms/signin.php" class="btn btn-outline  m-md">Sign in</a>
                    <a href="../forms/register.php" class="btn btn-primary">Register</a> 
                <?php endif; ?> 
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
            <?php if ($isLoggedIn): ?>
                <a href="../server/signout.php" class="btn btn-primary">Sign out</a>
            <?php else: ?>
                <a href="../forms/signin.php" class="btn btn-outline">Sign in</a>
                <a href="../forms/register.php" class="btn btn-primary">Register</a>
            <?php endif; ?>
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
                <a href="../info/about.html" class="sidebar-link">
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
            <!-- Registration form that submits to process_register.php. It includes fields for first name, last name, email, and password. The password field has a toggle to show/hide the password. There is also a link for users who already have an account to sign in. -->
            <form class="form" method="POST" action="../server/process_register.php">
                <h2>Register</h2>
                <p>Fill out the form below to create an account with us.<p>
                <div class="form-fields flex flex-col justify-center items-center">
                    <input class="text-input" type="text" name="fname" placeholder="First Name" required>
                    <input class="text-input" type="text" name="lname" placeholder="Last Name" required>
                    <input class="text-input" type="email" name="email" autocomplete="email" placeholder="Email Address" required>
                    <div class="pass-div flex justify-center items-center">
                        <input class="text-input pass" type="password" name="password" placeholder="Password" required><span id="toggle-pass" class="fa-solid fa-eye"></span>
                    </div>
                </div>
                <div>
                    <input class="btn btn-primary w-full" type="submit" class="button">
                    <p class="m-md">Already have an account? <a class="link" href="signin.php">Sign in</a></p>
                </div>
            </form>
        </div>
    </main>

    <script src="../scripts/navScript.js"></script>
    <script src="../scripts/inputScript.js"></script>
</body>
</html>