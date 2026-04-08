<?php
require __DIR__ . '/../config.php';

// Start session and require login to process returns.
session_start();

// If the user is not logged in, redirect to the sign-in page.
if (!isset($_SESSION['user_id'])) {
    header('Location: ../forms/signin.php');
    exit();
}

// Only allow POST requests to process the return. If accessed via GET or other methods, redirect back to the user's books page.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../user/my_books.php');
    exit();
}

// Validate and sanitize input data.
$borrowId = isset($_POST['borrow_id']) ? (int)$_POST['borrow_id'] : 0;
$userId = $_SESSION['user_id'];

// If the borrow ID is missing or invalid, redirect back with an error message.
if (!$borrowId) {
    header("Location: ../user/my_books.php?error=invalid");
    exit();
}

// Get book info and verify ownership
$borrowStmt = $pdo->prepare('SELECT book_id FROM borrowedbooks WHERE id = :id AND user_id = :user_id AND returned_at IS NULL');
$borrowStmt->bindValue(':id', $borrowId);
$borrowStmt->bindValue(':user_id', $userId);
$borrowStmt->execute();
$borrow = $borrowStmt->fetch(PDO::FETCH_ASSOC);

// If the borrow record doesn't exist or doesn't belong to the user, redirect back with an error message.
if (!$borrow) {
    header("Location: ../user/my_books.php?error=not_found");
    exit();
}

// Use a transaction to ensure both the return record update and book availability update succeed together.
$pdo->beginTransaction();
try {
    // Mark the borrow record as returned, then increase book availability.
    $returnStmt = $pdo->prepare('UPDATE borrowedbooks SET returned_at = NOW() WHERE id = :id');
    $returnStmt->bindValue(':id', $borrowId);
    $returnStmt->execute();

    // Increment copies available
    $updateStmt = $pdo->prepare('UPDATE books SET copies_available = copies_available + 1 WHERE id = :id');
    $updateStmt->bindValue(':id', $borrow['book_id']);
    $updateStmt->execute();
    // Commit the transaction and redirect back to the user's books page with a success message.
    $pdo->commit();
    header("Location: ../user/my_books.php?success=returned");
    exit();
} catch (PDOException $e) {
    // If any part of the transaction fails, roll back to maintain data integrity and redirect back with an error message.
    $pdo->rollBack();
    header("Location: ../user/my_books.php?error=failed");
    exit();
}
?>