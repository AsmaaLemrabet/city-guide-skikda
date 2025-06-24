<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login-form.php");
    exit();
}

$user = $_SESSION['user'];  // must have this!

// 🌍 Language setup
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}
$lang = $_SESSION['lang'] ?? 'en';

// 🌐 Translations
$text = [
    'en' => [
        'My Comments' => 'My Comments',
        'You haven\'t written any comments yet.' => 'You haven\'t written any comments yet.',
        'Comment' => 'Comment',
        'Posted on' => 'Posted on',
        'On Item' => 'On Item',
        'Back' => 'Back'
    ],
    'fr' => [
        'My Comments' => 'Mes Commentaires',
        'You haven\'t written any comments yet.' => 'Vous n\'avez encore rédigé aucun commentaire.',
        'Comment' => 'Commentaire',
        'Posted on' => 'Publié le',
        'On Item' => 'Sur l\'élément',
        'Back' => 'Retour'
    ],
    'ar' => [
        'My Comments' => 'تعليقاتي',
        'You haven\'t written any comments yet.' => 'لم تقم بكتابة أي تعليق حتى الآن.',
        'Comment' => 'التعليق',
        'Posted on' => 'نُشر في',
        'On Item' => 'على العنصر',
        'Back' => 'رجوع'
    ]
];

// ✅ Get user's comments
$stmt = $conn->prepare("SELECT * FROM comments WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user['id']]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title>💬 <?= $text[$lang]['My Comments'] ?></title>
  <link rel="stylesheet" href="css/user-dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Elsie+Swash+Caps&display=swap" rel="stylesheet">
</head>
<body>
 
  <header class="glass-header">
    <div class="user-left">
      <h1>💬 <?= $text[$lang]['My Comments'] ?></h1>
    </div>
    <div class="user-right">
      <a href="user-dashboard.php">🏠 <?= $text[$lang]['Back'] ?></a>
      <button onclick="toggleMode()">🌓</button>

      <div class="lang-dropdown">
        <button class="lang-toggle">🌍</button>
        <div class="lang-menu">
          <a href="?lang=en">🇬🇧 English</a>
          <a href="?lang=fr">🇫🇷 Français</a>
          <a href="?lang=ar">🇩🇿 العربية</a>
        </div>
      </div>
    </div>
  </header>

  <main class="container">
    <?php if (count($comments) === 0): ?>
      <p style="text-align:center; font-weight:bold;">
        <?= $text[$lang]["You haven't written any comments yet."] ?>
      </p>
    <?php else: ?>
      <ul>
        <?php foreach ($comments as $comment): ?>
          <li>
            <strong><?= $text[$lang]['Comment'] ?>:</strong> <?= htmlspecialchars($comment['content']) ?> |
            <em><?= $text[$lang]['Posted on'] ?>:</em> <?= htmlspecialchars($comment['created_at']) ?> |
            <strong><?= $text[$lang]['On Item'] ?>:</strong> <?= htmlspecialchars($comment['item_type']) ?> ID <?= htmlspecialchars($comment['item_id']) ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </main>

  <footer>All rights reserved © Skikda Guide</footer>
  <script src="js/user-dashboard.js"></script>
</body>
</html>
