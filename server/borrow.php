<?php
require __DIR__ . '/../config.php';

// Start the session to identify the signed-in user and protect borrow actions.
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect guests to sign-in before borrowing.
    header('Location: ../forms/signin.php');
    exit();
}

// Only allow POST requests for borrowing books. GET requests should be redirected back to the book page.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $redirectId = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
    header('Location: ../browse/book.php?book_id=' . $redirectId);
    exit();
}

// Validate and sanitize input data.
$bookId = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
$duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 0;
$userId = $_SESSION['user_id'];

// Validate book ID and duration against allowed values.
$validDurations = [7, 14, 21];
// Redirect back with error if validation fails.
if (!$bookId || !in_array($duration, $validDurations, true)) {
    header("Location: ../browse/book.php?book_id=$bookId&borrow=invalid");
    exit();
}

// Check if the book exists and has available copies before proceeding with the borrow process.
$bookStmt = $pdo->prepare('SELECT copies_available FROM books WHERE id = :id');
$bookStmt->bindValue(':id', $bookId, PDO::PARAM_INT);
$bookStmt->execute();
$book = $bookStmt->fetch(PDO::FETCH_ASSOC);

// If the book doesn't exist or has no available copies, redirect back with an error message.
if (!$book || $book['copies_available'] <= 0) {
    header("Location: ../browse/book.php?book_id=$bookId&borrow=unavailable");
    exit();
}

// Calculate the due date based on the selected duration.
$dueDate = new DateTime();
$dueDate->modify("+$duration days");

// Use a transaction to ensure both the borrow record and book availability update succeed together.
$pdo->beginTransaction();
try {
    // Insert the borrow record and reduce stock in a single transaction.
    $insertStmt = $pdo->prepare('INSERT INTO borrowedbooks (user_id, book_id, due_date) VALUES (:user_id, :book_id, :due_date)');
    $insertStmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $insertStmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
    $insertStmt->bindValue(':due_date', $dueDate->format('Y-m-d H:i:s'));
    $insertStmt->execute();
    // Decrement the available copies of the book.
    $updateStmt = $pdo->prepare('UPDATE books SET copies_available = copies_available - 1 WHERE id = :id');
    $updateStmt->bindValue(':id', $bookId, PDO::PARAM_INT);
    $updateStmt->execute();
    // Commit the transaction if both operations succeed, then redirect back to the book page with a success message.
    $pdo->commit();
    header("Location: ../browse/book.php?book_id=$bookId&borrow=success&days=$duration");
    exit();
} catch (PDOException $e) {
    // Roll back the transaction if any operation fails, then redirect back to the book page with an error message.
    $pdo->rollBack();
    header("Location: ../browse/book.php?book_id=$bookId&borrow=error");
    exit();
}
