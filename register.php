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
    <link rel="stylesheet" href="stylesheets/styles.css">

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
                    <li id="active-nav"><a href="index.html" class="nav-item">Home</a></li>
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
            <div class="hamburger">
                <div id="ham-1"></div>
                <div id="ham-2"></div>
                <div id="ham-3"></div>
            </div>
            <h1>SLS</h1>
            <ul>  
                <li><a href="index.html" class="nav-item">Home</a></li>
                <li><a href="#" class="nav-item">About</a></li>
                <li><a href="#" class="nav-item">Sign in</a></li>
                <li><a href="#" class="nav-item">Register</a></li>
            </ul>
        </div>  
    </nav>

    <main class="content">
        <div class="form">
            <form method="POST">
                <h2>Register</h2>
                <input type="text" name="fname" placeholder="First Name" required>
                <input type="text" name="lname" placeholder="Last Name" required>
                <input type="email" name="email" autocomplete="email" placeholder="Email Address" required>
                <div class="pass-div">
                    <input type="password" name="password" placeholder="Password" required><span id="toggle-pass" class="fa-solid fa-eye"></span>
                </div>
                <div>
                    <input type="submit" class="button">
                    <p>Already have an account? <a href="signin.php">Sign in</a></p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>