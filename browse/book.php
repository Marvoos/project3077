<?php
    require __DIR__ . "/../config.php";

    // Initialize session state so we know whether this user is allowed to view details.
    session_start();

    $isLoggedIn = isset($_SESSION["user_id"]);
    $bookInfo = null;

    if (!$isLoggedIn) {
        header("Location: ../forms/signin.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === 'GET' && isset($_GET['book_id'])) {
        
        $bookId = (int) $_GET['book_id'];

        $getBookStmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
        $getBookStmt->bindValue(":id", $_GET['book_id']);
        $getBookStmt->execute();
        $bookInfo = $getBookStmt->fetch(PDO::FETCH_ASSOC);

        // Remove debug print_r
        // print_r($bookInfo);

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
    <!-- The title is dynamically set based on the book's name, with a fallback to 'Book Details' if not available. -->
    <title><?php echo htmlspecialchars($bookInfo['name'] ?? 'Book Details'); ?></title>
</head>
<body class="bg-main">  
    <!-- Navigation bar with conditional links based on login state. -->
    <nav class="nav">
        <div class="nav-inner flex justify-between items-center p-lg">
            <h2 class="nav-title">SLS</h2>
            
            <div class="flex items-center">
                <a href="../forms/signin.php" class="btn btn-outline  m-md">Sign Out</a>
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
            <a href="../user/profile.php" class="nav-link">
                <i class="fa-solid fa-user"></i>
            </a>
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
    <main class="main page-content">
        <!-- If book information is available, display it. Otherwise, show a not found message. -->
        <?php if ($bookInfo): ?>
            <!-- Display a message based on the borrow action result, if applicable. -->
            <?php if (isset($_GET['borrow'])): ?>
                <!-- The message class is determined by whether the borrow action was successful or not. -->
                <div class="message <?php echo $_GET['borrow'] === 'success' ? 'message-success' : 'message-error'; ?>">
                    <!-- The message content is determined by the specific borrow result, with a fallback for unexpected values. -->
                    <?php
                        if ($_GET['borrow'] === 'success') {
                            echo 'Borrow request placed for ' . htmlspecialchars($_GET['days'] ?? 'the selected') . ' days.';
                        } elseif ($_GET['borrow'] === 'unavailable') {
                            echo 'This book is unavailable.';
                        } elseif ($_GET['borrow'] === 'invalid') {
                            echo 'Invalid borrow request.';
                        } else {
                            echo 'Something went wrong while borrowing.';
                        }
                    ?>
                </div>
            <?php endif; ?>
            
            <!-- Book details section, including cover image, metadata, description, and borrow button if available. -->
            <section class="flex flex-col">
                <div class="border rounded shadow-md">
                    <!-- The book cover image is displayed with a fallback alt text if the image is not available. -->
                    <img class="book-cover" src="../<?php echo htmlspecialchars($bookInfo['image']); ?>" alt="<?php echo htmlspecialchars($bookInfo['name']); ?> cover">
                </div>

                <!-- Book metadata and description are displayed in a card layout. -->
                <div class="book-meta card border rounded bg-card p-lg shadow-md">
                    <!-- A badge indicates whether the book is currently available or not, based on the number of copies available. -->
                    <span class="badge <?php echo $bookInfo['copies_available'] > 0 ? 'badge-available' : 'badge-unavailable'; ?>">
                        <?php echo $bookInfo['copies_available'] > 0 ? 'Available' : 'Unavailable'; ?>
                    </span>
                    <!-- The book title and author are displayed, with fallbacks for missing information. -->
                    <h1 class="book-title"><?php echo htmlspecialchars($bookInfo['name']); ?></h1>
                    <!--  The author's name is displayed with a fallback to 'Unknown Author' if the information is not available. -->
                    <p class="book-author">By <?php echo htmlspecialchars($bookInfo['author'] ?? 'Unknown Author'); ?></p>
                    <div class="book-stats flex items-center justify-between">
                        <!-- The number of copies available is displayed, along with the date the book was added to the library. -->
                        <p><strong>Copies:</strong> <?php echo htmlspecialchars($bookInfo['copies_available']); ?></p>
                        <!-- The date the book was added is displayed in a human-readable format, with a fallback to 'Unknown' if the information is not available. -->
                        <p><strong>Added:</strong> <?php echo htmlspecialchars(date('M d, Y', strtotime($bookInfo['created_at']))); ?></p>
                    </div>
                    <!-- The book description is displayed, with newlines converted to line breaks and special characters escaped for security. -->
                    <p class="book-description"><?php echo nl2br(htmlspecialchars($bookInfo['description'])); ?></p>

                    <!-- If the book is available, a button is shown to open the borrow dialog. Otherwise, a message indicates that the book is unavailable. -->
                    <?php if ($bookInfo['copies_available'] > 0): ?>
                        <button id="open-borrow-dialog" class="btn btn-primary mt-md">Borrow for a period</button>
                    <?php else: ?>
                        <p class="unavailable-text mt-md">This book is currently unavailable. Check back soon.</p>
                    <?php endif; ?>
                </div>
            </section>
            
            <!-- Modal dialog for borrowing the book, which includes a form to select the borrow duration and add optional notes. -->
            <div class="modal-overlay hidden" id="borrowModal">
                <div class="modal-card border rounded bg-card shadow-md">
                    <div class="modal-header flex justify-between items-center">
                        <div>
                            <h2>Borrow this book</h2>
                            <p class="text-secondary">Choose how long you need it for.</p>
                        </div>
                        <button type="button" class="modal-close" id="closeBorrowDialog">×</button>
                    </div>
                    <!-- The form submits a POST request to the borrow.php script, including the book ID, selected duration, and any optional notes. -->
                    <form method="POST" action="../server/borrow.php" class="modal-body">
                        <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($bookInfo['id']); ?>">

                        <label for="duration" class="form-label">Borrow duration</label>
                        <select id="duration" name="duration" class="text-input w-full" required>
                            <option value="7">7 days</option>
                            <option value="14" selected>14 days</option>
                            <option value="21">21 days</option>
                        </select>

                        <label for="notes" class="form-label">Notes (optional)</label>
                        <textarea id="notes" name="notes" rows="3" class="text-input w-full" placeholder="Reason for borrowing"></textarea>

                        <div class="modal-actions flex justify-between items-center">
                            <button type="button" class="btn btn-outline" id="cancelBorrowDialog">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm borrow</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>Book not found.</p>
        <?php endif; ?>
    </main>

    <script src="../scripts/navScript.js"></script>
    <script>
        // JavaScript to handle opening and closing the borrow modal dialog, including event listeners for the open button, close button, cancel button, and clicking outside the modal to close it.
        const openBorrowDialog = document.getElementById('open-borrow-dialog');
        const borrowModal = document.getElementById('borrowModal');
        const closeBorrowDialog = document.getElementById('closeBorrowDialog');
        const cancelBorrowDialog = document.getElementById('cancelBorrowDialog');

        function toggleBorrowModal(show) {
            borrowModal.classList.toggle('hidden', !show);
        }

        // Event listeners for opening and closing the borrow modal dialog.
        // The open button shows the modal, while the close and cancel buttons hide it. Additionally, clicking outside the modal content will also hide the modal.
        openBorrowDialog?.addEventListener('click', () => toggleBorrowModal(true));
        closeBorrowDialog?.addEventListener('click', () => toggleBorrowModal(false));
        cancelBorrowDialog?.addEventListener('click', () => toggleBorrowModal(false));
        borrowModal?.addEventListener('click', (event) => {
            if (event.target === borrowModal) {
                toggleBorrowModal(false);
            }
        });
    </script>
</body>
</html>