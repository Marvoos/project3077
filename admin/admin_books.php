<?php
    require __DIR__ . "/../config.php";

    // Start session so the admin check can verify the current user.
    session_start();

    // Check if user is logged in and is admin
    if (!isset($_SESSION["user_id"])) {
        header("Location: ../forms/signin.php");
        exit();
    }
    // Fetch user role to verify admin access
    $userId = $_SESSION["user_id"];
    $userStmt = $pdo->prepare("SELECT role FROM userdata WHERE id = :id");
    $userStmt->bindValue(":id", $userId);
    $userStmt->execute();
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);

    if ($user["role"] !== "admin") {
        header("Location: ../home/index.php");
        exit();
    }

    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["add_book"])) {
            // Add new book
            $name = trim($_POST["name"]);
            $author = trim($_POST["author"]);
            $description = trim($_POST["description"]);
            $copies = (int)$_POST["copies"];
            // Using a placeholder image service for simplicity. In a real app, you'd handle file uploads or use a proper image URL.
            $image = "https://picsum.photos/200/300?random=" . rand(1, 1000); // Random placeholder image
            // Insert new book into database
            $insertStmt = $pdo->prepare("INSERT INTO books (name, author, description, copies_available, image) VALUES (:name, :author, :desc, :copies, :image)");
            $insertStmt->bindValue(":name", $name);
            $insertStmt->bindValue(":author", $author);
            $insertStmt->bindValue(":desc", $description);
            $insertStmt->bindValue(":copies", $copies);
            $insertStmt->bindValue(":image", $image);
            $insertStmt->execute();

            // Redirect back to admin page with success message
            header("Location: admin_books.php?success=added");
            exit();
        } elseif (isset($_POST["edit_book"])) {
            // Edit existing book
            $id = (int)$_POST["book_id"];
            $name = trim($_POST["name"]);
            $author = trim($_POST["author"]);
            $description = trim($_POST["description"]);
            $copies = (int)$_POST["copies"];

            // Update book in database
            $updateStmt = $pdo->prepare("UPDATE books SET name = :name, author = :author, description = :desc, copies_available = :copies WHERE id = :id");
            $updateStmt->bindValue(":name", $name);
            $updateStmt->bindValue(":author", $author);
            $updateStmt->bindValue(":desc", $description);
            $updateStmt->bindValue(":copies", $copies);
            $updateStmt->bindValue(":id", $id);
            $updateStmt->execute();

            // Redirect back to admin page with success message
            header("Location: admin_books.php?success=updated");
            exit();
        } elseif (isset($_POST["delete_book"])) {
            // Delete book
            $id = (int)$_POST["book_id"];
            $deleteStmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
            $deleteStmt->bindValue(":id", $id);
            $deleteStmt->execute();

            header("Location: admin_books.php?success=deleted");
            exit();
        }
    }

    // Fetch all books for display
    $booksStmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
    $books = $booksStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Standard meta tags and linking stylesheets -->
    <meta charset="UTF-8">
    <!-- Using a responsive viewport for mobile compatibility -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Defining the author of the page -->
    <meta name="author" content="Kayden Ions">
    <title>Admin - Book Management</title>
    <!-- Linking external stylesheets for navigation and page styling -->
    <link rel="stylesheet" href="../stylesheets/nav.css">
    <link rel="stylesheet" href="../stylesheets/style.css">
    <link rel="stylesheet" href="../stylesheets/formstyle.css">
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/7d8aa418e1.js" crossorigin="anonymous"></script>
</head>

<body class="bg-main">
    <!-- Navigation similar to other pages -->
    <nav class="nav">
        <div class="nav-inner flex justify-between items-center p-lg">
            <h2 class="nav-title">SLS Admin</h2>
            <div class="flex items-center">
                <a href="../server/signout.php" class="btn btn-primary m-md">Sign out</a>
            </div>
        </div>
        <div class="nav-mobile flex justify-between items-center p-md">
            <h2 class="nav-title">SLS Admin</h2>

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
        </ul>
        <ul class="sidebar-list">
            <li class="sidebar-item active">
                <a href="../admin/admin_books.php" class="sidebar-link">
                    <i class="fa-solid fa-right-to-bracket"></i> Staff Portal
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main content area for book management -->
    <main class="main">
        <h1>Book Management</h1>
        <!-- Display success message if redirected after an action -->
         <?php if (isset($_GET["success"])): ?>
            <p class="success">Book <?php echo htmlspecialchars($_GET["success"]); ?> successfully!</p>
        <?php endif; ?>

        <!-- Add New Book Form -->
        <div class="card bg-card p-lg m-md">
            <h2>Add New Book</h2>
            <!-- Simple form for adding a new book. -->
            <form method="POST">
                <input class="text-input" type="text" name="name" placeholder="Book Title" required>
                <input class="text-input" type="text" name="author" placeholder="Author" required>
                <textarea class="text-input" name="description" placeholder="Description" rows="4"></textarea>
                <input class="text-input" type="number" name="copies" placeholder="Copies Available" min="0" required>
                <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
            </form>
        </div>

        <!-- Existing Books -->
        <h2>Existing Books</h2>
        <div class="grid grid-1">
            <!-- Loop through books and display them with edit/delete options -->
             <?php if (empty($books)): ?>
                <p>No books in the library yet.</p>
            <?php endif; ?>
            <!-- Each book is displayed in a card with its details and forms for editing or deleting. -->
            <?php foreach ($books as $book): ?>
                <div class="card bg-card p-lg m-md">
                    <h3><?php echo htmlspecialchars($book["name"]); ?></h3>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($book["author"] ?? "Unknown"); ?></p>
                    <p><strong>Copies:</strong> <?php echo htmlspecialchars($book["copies_available"]); ?></p>
                    <p><?php echo htmlspecialchars(substr($book["description"], 0, 100)); ?>...</p>

                    <!-- Edit Form -->
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book["id"]; ?>">
                        <input class="text-input" type="text" name="name" value="<?php echo htmlspecialchars($book["name"]); ?>" required>
                        <input class="text-input" type="text" name="author" value="<?php echo htmlspecialchars($book["author"]); ?>">
                        <textarea class="text-input" name="description" rows="2"><?php echo htmlspecialchars($book["description"]); ?></textarea>
                        <input class="text-input" type="number" name="copies" value="<?php echo $book["copies_available"]; ?>" min="0" required>
                        <button type="submit" name="edit_book" class="btn btn-outline">Update</button>
                    </form>

                    <!-- Delete Form -->
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this book?')">
                        <input type="hidden" name="book_id" value="<?php echo $book["id"]; ?>">
                        <button type="submit" name="delete_book" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <script src="../scripts/navScript.js"></script>
</body>
</html>