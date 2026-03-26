<?php
    session_start();

    $isLoggedIn = isset($_SESSION["user_id"]);
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

    <script src="https://kit.fontawesome.com/7d8aa418e1.js" crossorigin="anonymous"></script>
    
    <title>SLS</title>
</head>
<body>  
    <nav class="sls-nav">
        <div class="desktop">
            <h2>SLS</h2>
            <div>
                <ul class="account-controls">
                    <?php if ($isLoggedIn): ?>
                        <li><a href="../server/signout.php" class="account-bold">Sign out</a></li>
                        <li><a href="../user/profile.php"><i class="fa-solid fa-user"></i></a></li>
                    <?php else: ?>
                        <li><a href="../forms/signin.php" class="account">Sign in</a></li>
                        <li><a href="../forms/register.php" class="account-bold">Register</a></li> 
                    <?php endif; ?> 
                </ul>
            </div>
        </div>
        <div class="mobile">
            <div>
                <div class="hamburger">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="close-x hidden">
                    <div id="line1"></div>
                    <div id="line2"></div>
                </div>
                <h2>SLS</h2>
            </div>
            
            <ul class="account-controls">
                <li><a href="../forms/signin.php" class="account">Sign in</a></li>
                <li><a href="../forms/register.php" class="account-bold">Register</a></li>  
            </ul>
            <ul class="hidden-nav">  
                <li><a href="../home/index.php" class="nav-item"><i class="fa-solid fa-house"></i>Home</a></li>
                <li><a href="../browse/browse.php" class="nav-item"><i class="fa-solid fa-magnifying-glass"></i>Browse</a></li>
                <li><a href="#"><i class="fa-solid fa-book"></i>My Books</a></li>
                <li><a href="#"><i class="fa-solid fa-clock-rotate-left"></i>History</a></li>
                <li><a href="../about/about.html" class="nav-item"><i class="fa-solid fa-circle-info"></i>About</a></li>
                <li><a href="#"><i class="fa-solid fa-clipboard-question"></i>FAQ</a></li>
                <li><a href="#"><i class="fa-solid fa-envelope"></i>Contact Us</a></li>
                <li><a href="#">Staff Portal</a></li>
            </ul>   
        </div>  
    </nav>
    <div class="sidebar">
        <ul>
            <li id="on-page"><a href="../home/index.php"><i class="fa-solid fa-house"></i>Home</a></li>
            <li><a href="../browse/browse.php"><i class="fa-solid fa-magnifying-glass"></i>Browse</a></li>
            <li><a href="#"><i class="fa-solid fa-book"></i>My Books</a></li>
            <li><a href="#"><i class="fa-solid fa-clock-rotate-left"></i>History</a></li>
        </ul>
        <ul>
            <li><a href="#"><i class="fa-solid fa-circle-info"></i>About</a></li>
            <li><a href="#"><i class="fa-solid fa-clipboard-question"></i>FAQ</a></li>
            <li><a href="#"><i class="fa-solid fa-envelope"></i>Contact Us</a></li>
        </ul>
        <ul>
            <li><a href="#"><i class="fa-solid fa-right-to-bracket"></i>Staff Portal</a></li>
        </ul>
    </div>
    <main class="content">
        <div class="jumbo">
            
        </div>
    </main>

    <script src="../scripts/navScript.js"></script>
    <script src="../scripts/jumbotron.js"></script>
</body>
</html>