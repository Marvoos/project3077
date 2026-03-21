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
    <link rel="stylesheet" href="stylesheets/nav.css">

    <link rel="stylesheet" href="stylesheets/formstyle.css">
    <script src="https://kit.fontawesome.com/7d8aa418e1.js" crossorigin="anonymous"></script>
    
    <title>SLS</title>
</head>
<body>  
    <nav class="sls-nav">
        <div class="desktop">
            <div>
                <h2>SLS</h2>
                <ul class="page-links">
                    <li id="active-nav"><a href="index.php" class="nav-item">Home</a></li>
                    <li><a href="browse/browse.php" class="nav-item">Browse</a></li>
                    <li><a href="about/about.html" class="nav-item">About</a></li>
                </ul>
            </div>
            <div>
                <ul class="account-controls">
                    <li><a href="signin.php" class="account">Sign in</a></li>
                    <li><a href="register.php" class="account-bold">Register</a></li>  
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
                <li><a href="signin.php" class="account">Sign in</a></li>
                <li><a href="register.php" class="account-bold">Register</a></li>  
            </ul>
            <ul class="hidden-nav">  
                <li><a href="index.php" class="nav-item">Home</a></li>
                <li><a href="browse/browse.php" class="nav-item">Browse</a></li>
                <li><a href="about/about.html" class="nav-item">About</a></li>
            </ul>
        </div>  
    </nav>

    <main class="content">
        <div class="form">
            <form method="POST">
                <h2>Sign In</h2>
                <input type="email" name="email" autocomplete="email" placeholder="Email Address" required>
                <div class="pass-div">
                    <input type="password" name="password" placeholder="Password" required><span id="toggle-pass" class="fa-solid fa-eye"></span>
                </div>
                <div>
                    <input type="submit" class="button">
                    <p>Don't have an account? <a href="register.php">Register</a></p>
                </div>
            </form>
        </div>
    </main>
    <script src="scripts/navScript.js"></script>
</body>
</html>