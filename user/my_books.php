<?php
require __DIR__ . "/../config.php";

// Start session to track the logged-in user and load their borrowed books.
session_start();
// If the user is not logged in, redirect them to the sign-in page to access their borrowed books.
if (!isset($_SESSION["user_id"])) {
    header("Location: ../forms/signin.php");
    exit();
}

$userId = $_SESSION["user_id"];

// Fetch currently borrowed books
$borrowedStmt = $pdo->prepare("
    SELECT b.name, b.author, bb.borrowed_at, bb.due_date, bb.id
    FROM borrowedbooks bb
    JOIN books b ON bb.book_id = b.id
    WHERE bb.user_id = :user_id AND bb.returned_at IS NULL
    ORDER BY bb.due_date ASC
");
$borrowedStmt->bindValue(":user_id", $userId);
$borrowedStmt->execute();
$borrowedBooks = $borrowedStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Books - SLS</title>
    <link rel="stylesheet" href="../stylesheets/nav.css">
    <link rel="stylesheet" href="../stylesheets/style.css">
    <link rel="stylesheet" href="../stylesheets/formstyle.css">
    <script src="https://kit.fontawesome.com/7d8aa418e1.js" crossorigin="anonymous"></script>
</head>
<body class="bg-main">
    <nav class="nav">
        <div class="nav-inner flex justify-between items-center p-lg">
            <h2 class="nav-title">SLS</h2>
            <div class="flex items-center">
                <a href="../server/signout.php" class="btn btn-primary m-md">Sign out</a>
                <a href="../user/profile.php" class="nav-link">
                    <i class="fa-solid fa-user"></i>
                </a>
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
            <a href="../server/signout.php" class="btn btn-primary">Sign out</a>
        </div>
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
            <li class="sidebar-item active">
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

    <main class="main">
        <!-- If there is a success message in the URL parameters, display a success message. If there is an error message in the URL parameters, display an error message. -->
        <?php if (isset($_GET['success'])): ?>
            <div class="message message-success">Book returned successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <!-- Display the error message from the URL parameters. -->
            <div class="message message-error">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <h1>My Borrowed Books</h1>
        <!-- If the user has no currently borrowed books, display a message encouraging them to browse the collection. Otherwise, display their currently borrowed books in a card format showing the book name, author, borrowed date, due date, and a button to return the book. -->
        <?php if (empty($borrowedBooks)): ?>
            <div class="card bg-card rounded shadow-md p-lg">
                <p>You haven't borrowed any books yet. <a href="../browse/browse.php">Browse our collection</a> to get started.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-1">
                <?php foreach ($borrowedBooks as $book): ?>
                    <div class="card bg-card rounded shadow-md p-lg">
                        <h3><?php echo htmlspecialchars($book['name']); ?></h3>
                        <p>By <?php echo htmlspecialchars($book['author'] ?? 'Unknown'); ?></p>
                        <p><strong>Borrowed:</strong> <?php echo date('M d, Y', strtotime($book['borrowed_at'])); ?></p>
                        <p><strong>Due:</strong> <?php echo date('M d, Y', strtotime($book['due_date'])); ?></p>
                        <form method="POST" action="../server/return_book.php" style="display: inline;">
                            <input type="hidden" name="borrow_id" value="<?php echo $book['id']; ?>">
                            <button type="submit" class="btn btn-primary">Return Book</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script src="../scripts/navScript.js"></script>
</body>
</html>