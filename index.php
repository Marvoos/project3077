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
    
    <title>SLS</title>
</head>
<body>  
    <nav class="sls-nav">
        <div class="desktop">
            <div>
                <h2>SLS</h2>
                <ul class="page-links">
                    <li id="active-nav"><a href="index.php" class="nav-item">Home</a></li>
                    <li><a href="browse/browse.html" class="nav-item">Browse</a></li>
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
                <li><a href="browse/browse.html" class="nav-item">Browse</a></li>
                <li><a href="about/about.html" class="nav-item">About</a></li>
            </ul>
        </div>  
    </nav>

    <main class="content">
        <div>
            
        </div>
    </main>

    <script src="scripts/navScript.js"></script>
</body>
</html>