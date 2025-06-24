<?php
session_start();
require 'test-connection.php'; // This uses PDO

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo "You must be logged in.";
    exit;
}

$userId = $_SESSION['user']['id'];
$content = trim($_POST['reviewText'] ?? '');
$rating = intval($_POST['reviewRating'] ?? 0);

// Validate inputs
if (empty($content) || $rating < 1 || $rating > 5) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

// Optional if you want to support item_id / item_type later
$item_id = null;
$item_type = null;

try {
    $stmt = $conn->prepare("INSERT INTO comments (user_id, item_id, item_type, content) VALUES (:user_id, :item_id, :item_type, :content)");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
    $stmt->bindParam(':item_type', $item_type, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    
    $stmt->execute();
    echo "success";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
}
?>
