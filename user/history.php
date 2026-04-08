<?php
require __DIR__ . "/../config.php";

// Start session to verify the user and show their borrowing history.
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../forms/signin.php");
    exit();
}

$userId = $_SESSION["user_id"];

// Fetch borrowing history
$historyStmt = $pdo->prepare("
    SELECT b.name, b.author, bb.borrowed_at, bb.returned_at, bb.due_date
    FROM borrowedbooks bb
    JOIN books b ON bb.book_id = b.id
    WHERE bb.user_id = :user_id AND bb.returned_at IS NOT NULL
    ORDER BY bb.returned_at DESC
");

$historyStmt->bindValue(":user_id", $userId);
$historyStmt->execute();
$history = $historyStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowing History - SLS</title>
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
            <li class="sidebar-item">
                <a href="../user/my_books.php" class="sidebar-link">
                    <i class="fa-solid fa-book"></i> My Books
                </a>
            </li>
            <li class="sidebar-item active">
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
        <h1>Borrowing History</h1>
        <!-- If the user has no borrowing history, display a message encouraging them to start borrowing books. Otherwise, display their borrowing history in a card format showing the book name, author, borrowed date, due date, and returned date. -->
        <?php if (empty($history)): ?>
            <div class="card bg-card rounded shadow-md p-lg">
                <p>No borrowing history yet. <a href="../browse/browse.php">Start borrowing books</a> to build your history.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-1">
                <?php foreach ($history as $item): ?>
                    <div class="card bg-card rounded shadow-md p-lg">
                        <!-- Display the name of the book, author, borrowed date, due date, and returned date for each item in the user's borrowing history. -->
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <!-- If the author is not available, display "Unknown" instead. -->
                        <p>By <?php echo htmlspecialchars($item['author'] ?? 'Unknown'); ?></p>
                        <!-- Format the borrowed date, due date, and returned date in a human-readable format. -->
                        <p><strong>Borrowed:</strong> <?php echo date('M d, Y', strtotime($item['borrowed_at'])); ?></p>
                        <!-- Display the due date and returned date for each borrowed book in the user's history. -->
                        <p><strong>Due:</strong> <?php echo date('M d, Y', strtotime($item['due_date'])); ?></p>
                        <!-- Display the returned date for each borrowed book in the user's history. If the returned date is not available, it will show as "N/A". -->
                        <p><strong>Returned:</strong> <?php echo date('M d, Y', strtotime($item['returned_at'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script src="../scripts/navScript.js"></script>
</body>
</html>