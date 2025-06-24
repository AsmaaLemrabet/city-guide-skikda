<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login-form.php");
    exit();
}

$user = $_SESSION['user'];

// Handle language switching
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

// Set default language
$lang = $_SESSION['lang'] ?? 'en';

// Simple translation array
$text = [
    'en' => [
        'welcome' => 'Welcome',
        'likes' => 'My Likes',
        
        'comments' => 'My Comments',
        'logout' => 'Log Out'
    ],
    'fr' => [
        'welcome' => 'Bienvenue',
        'likes' => 'Mes Aimes',
        
        'comments' => 'Mes Commentaires',
        'logout' => 'Déconnexion'
    ],
    'ar' => [
        'welcome' => 'مرحبا',
        'likes' => 'إعجاباتي',
        
        'comments' => 'تعليقاتي',
        'logout' => 'تسجيل الخروج'
    ],
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $text[$lang]['welcome'] ?>, <?= htmlspecialchars($user['username']) ?></title>
  <link rel="stylesheet" href="css/user-dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Elsie+Swash+Caps&display=swap" rel="stylesheet">
</head>
<body>

  <header class="glass-header">
    <div class="user-left">
      <h1>🏛️ <?= $text[$lang]['welcome'] ?>, <?= htmlspecialchars($user['username']) ?></h1>
    </div>

    <div class="admin-left">
      <a href="index.php" class="home-icon" title="Back to site">🏠</a>
    </div> 

    <div class="user-right">
      <button onclick="toggleMode()">🌓</button>

      <div class="lang-dropdown">
        <button class="lang-toggle">🌍</button>
        <div class="lang-menu">
          <a href="?lang=fr">🇫🇷 French</a>
          <a href="?lang=en">🇬🇧 English</a>
          <a href="?lang=ar">🇩🇿 Arabic</a>
        </div>
      </div>
    </div>
  </header>

  <main class="container">
    <div class="card">
      <a href="my_likes.php"><?= $text[$lang]['likes'] ?> ❤️</a>
    </div>

    <div class="card">
      <a href="my_comments.php"><?= $text[$lang]['comments'] ?> 💬</a>
    </div>
  </main>

  <div class="logout-section">
    <a href="logout.php" class="logout-btn">🚪 <?= $text[$lang]['logout'] ?></a>
  </div>

  <footer>All rights reserved © city Guide</footer>

  <script src="js/user-dashboard.js"></script>
</body>
</html>
