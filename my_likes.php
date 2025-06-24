<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login-form.php");
    exit();
}

include 'includes/db.php';

$user = $_SESSION['user'];
$user_id = is_array($user) ? $user['id'] : $user;

try {
    // Get all liked items with their details from establishments table
    $stmt = $conn->prepare("
        SELECT e.*, l.item_type, l.liked_at 
        FROM establishments e
        JOIN likes l ON e.id = l.item_id
        WHERE l.user_id = ?
        ORDER BY l.liked_at DESC
    ");
    $stmt->execute([$user_id]);
    $liked_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Error fetching likes: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Likes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/user-dashboard.css">
  <style>
    .liked-items-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .liked-item {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .liked-item img {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }
    .liked-item-content {
        flex: 1;
    }
    .liked-item h3 {
        margin-top: 0;
        color: #0a1f3d;
    }
    .item-type {
        display: inline-block;
        padding: 3px 8px;
        background: #d4af37;
        color: white;
        border-radius: 4px;
        font-size: 0.8rem;
        margin-bottom: 10px;
    }
    .no-likes {
        text-align: center;
        padding: 50px;
        font-size: 1.2rem;
        color: #666;
    }
  </style>
</head>
<body>
<header class="glass-header">
    <div class="user-left">
      <h1>My Likes ❤️</h1>
    </div>
    <div class="user-right">
      <a href="user-dashboard.php">🏠 Back</a>
    </div>
</header>

<main class="liked-items-container">
  <?php if (empty($liked_items)): ?>
    <div class="no-likes">
      <p>You haven't liked anything yet.</p>
      <p>Start exploring and like your favorite places!</p>
    </div>
  <?php else: ?>
    <?php foreach ($liked_items as $item): ?>
      <div class="liked-item">
        <?php if (!empty($item['image'])): ?>
          <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <?php endif; ?>
        <div class="liked-item-content">
          <span class="item-type"><?= ucfirst($item['item_type']) ?></span>
          <h3><?= htmlspecialchars($item['name']) ?></h3>
          <?php if (!empty($item['description'])): ?>
            <p><?= htmlspecialchars($item['description']) ?></p>
          <?php endif; ?>
          <?php if (!empty($item['location_url'])): ?>
            <p><i class="fas fa-map-marker-alt"></i> 
              <a href="<?= htmlspecialchars($item['location_url']) ?>" target="_blank">View Location</a>
            </p>
          <?php endif; ?>
          <p><small>Liked on: <?= date('M j, Y', strtotime($item['liked_at'])) ?></small></p>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</main>

<footer>All rights reserved © Skikda Guide</footer>
</body>
</html>