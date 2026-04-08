<?php
    require __DIR__ . "/../config.php";
    // Start session for sign-in state and link generation.
    session_start();

    // Track whether a user is currently signed in.
    $isLoggedIn = isset($_SESSION["user_id"]);

    $pageLimit = 12; // Books per page
    $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $pageOffset = ($currentPage - 1) * $pageLimit;

    $sql = "FROM books WHERE 1=1"; // Base query
    $params = [];

    // Apply filters
    if (isset($_GET["filter"])) {
        switch($_GET["filter"]) {
            case "available":
                $sql .= " AND copies_available > 0";
                break;
            case "checked-out":
                $sql .= " AND copies_available = 0";
                break;
            case "new-arrivals":
                $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                break;
        }
    }

    // Apply search if the user typed text into the search box.
    if (!empty($_GET["search-q"])) {
        $sql .= " AND (name LIKE :search OR author LIKE :search)";
        $params[":search"] = "%" . $_GET["search-q"] . "%";
    }

    // Count the matching books to calculate pagination.
    $countStmt = $pdo->prepare("SELECT COUNT(*) " . $sql);
    $countStmt->execute($params);
    $amtBooks = $countStmt->fetchColumn();

    $pages = ceil($amtBooks / $pageLimit);

    // Prepare data query
    $dataStmt = $pdo->prepare("SELECT * " . $sql . " LIMIT :limit OFFSET :offset");

    // Bind search params
    foreach ($params as $key => $value) {
        $dataStmt->bindValue($key, $value);
    }

    // Bind pagination
    $dataStmt->bindValue(':limit', $pageLimit, PDO::PARAM_INT);
    $dataStmt->bindValue(':offset', $pageOffset, PDO::PARAM_INT);

    $dataStmt->execute();
    $allbooks = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

    // Dropdown helper
    function dropDownSelected($filterName, $filterString) {
        return ($filterName === $filterString) ? "selected" : "";
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
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/7d8aa418e1.js" crossorigin="anonymous"></script>
    
    <title>Browse - SLS</title>
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
            <li><a href="../status/index.php">Status</a></li>
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
    <main class="main">
        <!-- The search form allows users to enter a search query to find books by title or author. It submits a GET request to the same page (browse.php) with the search query as a parameter. -->
        <form class="search-form" method="GET" action="browse.php">
            <div class="search-input-group">
                <input type="text" name="search-q" placeholder="search by title or author" class="search-input">
                <button type="submit" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
        <!-- The filter form allows users to select a filter from the dropdown and submit it to the same page (browse.php) using the GET method. The selected filter is preserved in the dropdown after submission. -->
        <form class="filter-form" method="GET" action="browse.php">
            <!-- The filter dropdown provides options to filter the book list by availability, checked-out status, or new arrivals. The selected option is maintained after form submission using the dropDownSelected helper function. -->
            <select id="book-filters" name="filter" class="filter-dropdown">
                <!-- The options in the dropdown allow users to filter the book list. The "All Books" option is selected by default if no filter is applied. -->
                <option value="all" <?php echo isset($_GET['filter']) ? dropDownSelected($_GET['filter'], "all") : "selected" ?>>All Books</option>
                <!-- The "Available" option filters the book list to show only books that have copies available. -->
                <option value="available" <?php echo isset($_GET['filter']) ? dropDownSelected($_GET['filter'], "available") : "" ?>>Available</option>
                <!-- The "Checked Out" option filters the book list to show only books that are currently checked out (i.e., have no copies available). -->
                <option value="checked-out" <?php echo isset($_GET['filter']) ? dropDownSelected($_GET['filter'], "checked-out") : "" ?>>Checked Out</option>
                <!-- The "New Arrivals" option filters the book list to show only books that were added to the catalog within the last 7 days. -->
                <option value="new-arrivals" <?php echo isset($_GET['filter']) ? dropDownSelected($_GET['filter'], "new-arrivals") : "" ?>>New Arrivals</option>
            </select>
            <!-- The submit button for the filter form allows users to apply the selected filter to the book list. When clicked, it submits the form and updates the displayed books based on the chosen filter. -->
            <input type="submit" value="Filter" class="btn btn-primary">
        </form>
        <br>
        <!-- Display the total number of books in the catalog that match the current search and filter criteria. This provides users with feedback on how many books are available based on their selections. -->
        <p>Books in our catalog: <?php echo $amtBooks ?></p>
        <div class="grid grid-3 p-md">
            <?php 
                // Prepare the SQL query to fetch books based on the applied filters and search query, including pagination using LIMIT and OFFSET. The query is constructed dynamically based on the presence of search and filter parameters, and the results are fetched as an array for display.
                $dataStmt = $pdo->prepare("SELECT * " . $sql . " LIMIT :limit OFFSET :offset");

                // Bind normal params
                foreach ($params as $key => $value) {
                    $dataStmt->bindValue($key, $value);
                }

                // Bind LIMIT/OFFSET safely
                $dataStmt->bindValue(':limit', $pageLimit, PDO::PARAM_INT);
                $dataStmt->bindValue(':offset', $pageOffset, PDO::PARAM_INT);

                $dataStmt->execute();
                $allbooks = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

                // Loop through the fetched books and display them in a grid format. Each book is presented as a card with its cover image, title, author, and the number of copies available. If a book has no copies available, it is visually indicated as unavailable.
                foreach($allbooks as $book):
                    $bookCoverImg = htmlspecialchars($book['image']);
                    $bookName = htmlspecialchars($book['name']);
                    $bookAuthor = htmlspecialchars($book['author']);
                    $copiesAvailable = htmlspecialchars($book["copies_available"]);
                    $isAvailable = $copiesAvailable > 0 ? True : False;
            ?>
            <!-- Each book is displayed as a clickable card that links to the book's detail page (book.php) using the book's ID as a query parameter. The card includes the book's cover image, title, author, and availability status. If the book is unavailable (no copies available), it is styled differently to indicate this status. -->
                <a class="card bg-card rounded book-item-hover <?php echo !$isAvailable ? "book-unavailable" : "" ?>" href="book.php?book_id=<?php echo $book["id"]?>">
                    <img class="card-img" alt="<?php echo $bookName?> cover image" src="../<?php echo $bookCoverImg?>">
                    <div class="card-body p-md">
                        <!-- The book title is displayed, and if it exceeds 27 characters, it is truncated with an ellipsis for better display. -->
                        <h3><?php echo mb_strlen($book['name']) > 27 ? substr($book['name'], 0, 27) . "..." : htmlspecialchars($book['name']); ?></h3>
                        <!-- The book author is displayed, and if the author information is unavailable, it shows "Author Unavailable". -->
                        <p><?php echo isset($book['author']) ? htmlspecialchars($book['author']) : "Author Unavailable"; ?></p>
                        <!-- The number of copies available is displayed. If there are no copies available, the text is styled to indicate that the book is unavailable. -->
                        <p class="<?php echo !$isAvailable ? "unavailable-text" : ""?>">Copies Available: <?php echo $copiesAvailable ?></p>
                        <p class="link">See more...</p>
                    </div>
                </a>
            <?php endforeach; ?>
            </div>
            <div class="flex p-md">
                <!-- Pagination links are generated based on the total number of pages calculated from the book count and page limit. -->
            <?php
                for ($i = $currentPage == 1 ? $currentPage : $currentPage - (1); $i <= $pages; $i++):
            ?>
                <a class="m-sm link <?php echo $currentPage == $i ? "active-link" : "" ?>" 
                href="browse.php?page=<?php echo $i ?>&filter=<?php echo $_GET['filter'] ?? '' ?>&search-q=<?php echo $_GET['search-q'] ?? '' ?>">
                    <?php echo $i ?>
                </a>
            <?php endfor; ?>

        </div>
    </main>

    <script src="../scripts/navScript.js"></script>
</body>
</html>