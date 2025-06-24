<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(['isLiked' => false]);
    exit;
}

include 'includes/db.php';

$user = $_SESSION['user'];
$user_id = is_array($user) ? $user['id'] : $user;
$item_id = $_POST['item_id'] ?? null;
$item_type = $_POST['item_type'] ?? null;

if (!$item_id || !$item_type) {
    echo json_encode(['isLiked' => false]);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT 1 FROM likes WHERE user_id = ? AND item_id = ? AND item_type = ?");
    $stmt->execute([$user_id, $item_id, $item_type]);
    $isLiked = $stmt->fetchColumn();
    
    echo json_encode(['isLiked' => (bool)$isLiked]);
} catch (PDOException $e) {
    echo json_encode(['isLiked' => false]);
}