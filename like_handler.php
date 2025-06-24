<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo "unauthorized";
    exit;
}

include 'includes/db.php';

$user = $_SESSION['user'];
$user_id = is_array($user) ? $user['id'] : $user;

$item_id = $_POST['item_id'] ?? null;
$item_type = $_POST['item_type'] ?? null;

if (!$item_id || !$item_type) {
    http_response_code(400);
    echo "invalid";
    exit;
}

try {
    // Check if already liked
    $check = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND item_id = ? AND item_type = ?");
    $check->execute([$user_id, $item_id, $item_type]);

    if ($check->rowCount() > 0) {
        // Unlike - remove from database
        $delete = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND item_id = ? AND item_type = ?");
        $delete->execute([$user_id, $item_id, $item_type]);
        echo "unliked";
    } else {
        // Like - add to database
        $insert = $conn->prepare("INSERT INTO likes (user_id, item_id, item_type) VALUES (?, ?, ?)");
        $insert->execute([$user_id, $item_id, $item_type]);
        echo "liked";
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "error: " . $e->getMessage();
}