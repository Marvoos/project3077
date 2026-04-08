<?php
    // Database connection details used by the status page.
    $host = "localhost";
    $dbName = "sls_data";
    $dbUser = "root";
    $dbPass = "";
    session_start();

    $isLoggedIn = isset($_SESSION["user_id"]);

    function testDatabase() {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
            return true;
        }
        catch(PDOException $e) {
            return false;
        }
    }

    function testUsersTable($pdo) {
        try {
            $stmt = $pdo->query("SELECT 1 FROM userdata LIMIT 1");
            return true;
        }
        catch(PDOException $e) {
            return false;
        }
    }

    function testBooksTable($pdo) {
        try {
            $stmt = $pdo->query("SELECT 1 FROM books LIMIT 1");
            return true;
        }
        catch(PDOException $e) {
            return false;
        }
    }
    function testBorrowTable($pdo) {
        try {
            $stmt = $pdo->query("SELECT 1 FROM borrowedbooks LIMIT 1");
            return true;
        }
        catch(PDOException $e) {
            return false;
        }
    }

    $status = [];

    try {
        // Establish PDO connection with error handling and test each critical table to determine overall service status.
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $dbUser, $dbPass);
        $status['database'] = true;

        // Test each critical table and store the results in the status array to determine if each service is online or offline.
        $status['users'] = testUsersTable($pdo);
        $status['books'] = testBooksTable($pdo);
        $status['borrowing'] = testBorrowTable($pdo);

    } catch (PDOException $e) {
        // If the database connection fails, set all services to offline in the status array to reflect the overall system status.
        $status['database'] = false;
        $status['users'] = false;
        $status['books'] = false;
        $status['borrowing'] = false;
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
    <meta http-equiv="refresh" content="10">

    <script src="https://kit.fontawesome.com/7d8aa418e1.js" crossorigin="anonymous"></script>
    
    <title>SLS</title>
</head>
<body class="bg-main">  
    <nav class="nav">
        <div class="nav-inner flex justify-between items-center p-lg">
            <h2 class="nav-title">SLS</h2>  
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
            <li><a href="../my_books/my_books.php">My Books</a></li>
            <li><a href="../history/history.php">History</a></li>
        </ul>

        <ul class="mobile-list">
            <li><a href="../info/about.html">About</a></li>
            <li><a href="../info/faq.html">FAQ</a></li>
            <li><a href="../info/contact.php">Contact</a></li>
        </ul>

    </div>
    <aside class="sidebar">
        <ul class="sidebar-list">
            <li class="sidebar-item">
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
            <li class="sidebar-item active">
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
    <main class="main">
        <div class="card p-md rounded bg-card border m-md">
            <h2>Server Status</h2>
            <p>This page has been developed to aid in the creation of this website's underlying system. In the future, this webpage will be utilized by the user or staff to determine whether the site is under maintenance, experiencing server issues, or completely down altogether.</p>
            <br>
            <p>There are a total of <strong>four</strong> connections being tracked. These were deemed most important to our system and to our userbase.</p>
        </div>
        <!-- Display the status of each service in a card format, showing whether each service is online or offline based on the results from the database tests. -->
        <?php foreach($status as $service => $isOnline): ?>
            <div class="card bg-card border rounded p-md m-md">
                <!-- Display the name of the service and its status (online/offline) with appropriate styling based on the status. -->
                <h3><?php echo strtoupper($service) ?></h3>
                <?php if($isOnline): ?>
                    <!-- If the service is online, display a green "ONLINE" badge. If the service is offline, display a red "OFFLINE" badge. -->
                    <p class="rounded p-sm" style="background: var(--success-colour); color: var(--bg-main); font-weight: 600;">ONLINE</p>
                <?php elseif (!$isOnline): ?>
                    <p class="rounded p-sm" style="background: var(--error-colour); color: var(--bg-main); font-weight: 600;">OFFLINE</p>
                <?php endif;?>
            </div>
        <?php endforeach;?>
    </main>

    <script src="../scripts/navScript.js"></script>

</body>
</html>