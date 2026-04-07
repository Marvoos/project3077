<?php
    require __DIR__ . "/../config.php";
    session_start();

    $isLoggedIn = isset($_SESSION["user_id"]);

    function dropDownSelected($filterName, $filterString) {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            if (isset($filterName) && $filterName == $filterString) {
                return "selected";
            }
            else {
                return "";
            }            
        } else {
            return "";
        }
    }

    function filterQueries($filterName, $servConnection) {
        if ($filterName == "all") {
            return $servConnection->prepare("SELECT * FROM books LIMIT 12");
        }
        else if ($filterName == "available") {
            return $servConnection->prepare("SELECT * FROM books WHERE copies_available > 0 LIMIT 12");
        }
        else if ($filterName == "checked-out") {
            return $servConnection->prepare("SELECT * FROM books WHERE copies_available = 0 LIMIT 12");
        }
        else if ($filterName == "new-arrivals") {
            return $servConnection->prepare("SELECT * FROM books WHERE created_at <= CURRENT_TIMESTAMP AND created_at >= DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 7 DAY) LIMIT 12");
        }
    }

    function searchQuery($searchString, $servConnection) {
        $stmt = $servConnection->prepare("SELECT * FROM books WHERE name = :name OR author = :author");
        $stmt->bindValue(":name", $searchString);
        $stmt->bindValue(":author", $searchString);
        return $stmt;
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
            <li><a href="#">My Books</a></li>
            <li><a href="#">History</a></li>
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
            <li class="sidebar-item">
                <a href="../home/index.php" class="sidebar-link">
                    <i class="fa-solid fa-house"></i> Home
                </a>
            </li>
            <li class="sidebar-item active">
                <a href="../browse/browse.php" class="sidebar-link">
                    <i class="fa-solid fa-magnifying-glass"></i> Browse
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-book"></i> My Books
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
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
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-right-to-bracket"></i> Staff Portal
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
        <form>
            <div class="search-input-group">
                <input type="text" name="search-q" placeholder="search by title or author" class="search-input">
                <button type="submit" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
        <form class="filter-form" method="GET" action="browse.php">
                
            <select id="book-filters" name="filter" class="filter-dropdown">
                <option value="all" <?php echo isset($_GET['filter']) ? dropDownSelected($_GET['filter'], "all") : "selected" ?>>All Books</option>
                <option value="available" <?php echo isset($_GET['filter']) ? dropDownSelected($_GET['filter'], "available") : "" ?>>Available</option>
                <option value="checked-out" <?php echo isset($_GET['filter']) ? dropDownSelected($_GET['filter'], "checked-out") : "" ?>>Checked Out</option>
                <option value="new-arrivals" <?php echo isset($_GET['filter']) ? dropDownSelected($_GET['filter'], "new-arrivals") : "" ?>>New Arrivals</option>
            </select>
            <input type="submit" value="Filter" class="btn btn-primary">
        </form>
        <div class="grid grid-3 p-md">
            <?php 
                $allBooksStmt = $pdo->prepare("SELECT * FROM books LIMIT 12");
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    if (isset($_GET['filter'])) {
                        $allBooksStmt = filterQueries($_GET['filter'], $pdo);
                    }
                    else if (isset($_GET['search-q'])) {
                        $allBooksStmt = searchQuery($_GET['search-q'], $pdo);
                    }
                }

                $allBooksStmt->execute();
                $allbooks = $allBooksStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($allbooks as $book):
                    $bookCoverImg = htmlspecialchars($book['image']);
                    $bookName = htmlspecialchars($book['name']);
                    $bookAuthor = htmlspecialchars($book['author']);
                    $copiesAvailable = htmlspecialchars($book["copies_available"]);
                    $isAvailable = $copiesAvailable > 0 ? True : False;
            ?>
                <a class="card bg-card rounded book-item-hover <?php echo !$isAvailable ? "book-unavailable" : "" ?>" href="book.php?book_id=<?php echo $book["id"]?>">
                    <img class="card-img" alt="<?php echo $bookName?> cover image" src="../<?php echo $bookCoverImg?>">
                    <div class="card-body p-md">
                        <h3><?php echo mb_strlen($book['name']) > 40 ? substr($book['name'], 0, 27) . "..." : htmlspecialchars($book['name']); ?></h3>
                        <p><?php echo isset($book['author']) ? htmlspecialchars($book['author']) : "Author Unavailable"; ?></p>
                        <p class="<?php echo !$isAvailable ? "unavailable-text" : ""?>">Copies Available: <?php echo $copiesAvailable ?></p>
                        <p class="link">See more...</p>
                    </div>
                </a>
            <?php endforeach; ?>

        </div>
    </main>

    <script src="../scripts/navScript.js"></script>
</body>
</html>