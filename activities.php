<?php
include 'includes/db.php'; // Adjust path if needed

$stmt = $conn->prepare("SELECT * FROM establishments WHERE type = 'activity' ORDER BY created_at DESC");
$stmt->execute();
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Activities - Skikda</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="index.css">
  <style>
    /* Unified Card Styles for all pages */
    .unified-card {
        background: var(--card-bg);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 50px -15px rgba(0, 0, 0, 0.2);
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        height: 500px;
    }

    .unified-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        filter: brightness(0.9);
    }

    .unified-card:hover img {
        transform: scale(1.08);
        filter: brightness(0.7);
    }

    .unified-card::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60%;
        background: linear-gradient(to top, rgba(10, 31, 61, 0.9) 0%, transparent 100%);
        z-index: 1;
        opacity: 0;
        transition: opacity 0.6s ease;
    }

    .unified-card:hover::before {
        opacity: 1;
    }

    .unified-card-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 30px;
        z-index: 2;
        transform: translateY(100px);
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        text-align: left;
        color: white;
    }

    .unified-card:hover .unified-card-content {
        transform: translateY(0);
    }

    .unified-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }

    .unified-card h3::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gold);
        transition: width 0.6s ease;
    }

    .unified-card:hover h3::after {
        width: 100%;
    }

    .unified-card p {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 20px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease 0.1s;
    }

    .unified-card:hover p {
        opacity: 1;
        transform: translateY(0);
    }

    .unified-card .location {
        display: flex;
        align-items: center;
        color: var(--gold);
        font-size: 0.95rem;
        margin-bottom: 10px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease 0.2s;
    }

    .unified-card:hover .location {
        opacity: 1;
        transform: translateY(0);
    }

    .unified-card .location i {
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .unified-card .location a {
        color: var(--gold);
        text-decoration: none;
        transition: color 0.3s;
        border-bottom: 1px dotted transparent;
    }

    .unified-card .location a:hover {
        color: var(--white);
        border-bottom-color: var(--gold);
    }

    .unified-card::after {
        content: '';
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 8px;
        z-index: 1;
        pointer-events: none;
        opacity: 0;
        transform: scale(0.95);
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .unified-card:hover::after {
        opacity: 1;
        transform: scale(1);
    }

    /* Grid Layout for Cards */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 40px;
        padding: 60px 10%;
    }

    /* Animation for cards */
    .animate {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s ease;
    }

    .animate.in-view {
        opacity: 1;
        transform: translateY(0);
    }

    /* Favorite button styles */
    .favorite-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.6);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 3;
        transition: all 0.3s ease;
    }
    
    .favorite-btn i {
        color: white;
        font-size: 18px;
        transition: all 0.3s ease;
    }
    
    .favorite-btn:hover {
        background: rgba(0, 0, 0, 0.8);
    }
    
    .favorite-btn.active {
        background: rgba(255, 59, 59, 0.8);
    }
    
    .favorite-btn.active i {
        color: white;
    }
    
    .button {
        display: inline-block;
        padding: 10px 20px;
        background-color: var(--gold);
        color: var(--dark-blue);
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
        margin-top: 10px;
    }
    
    .button:hover {
        background-color: var(--white);
        transform: translateY(-2px);
    }
    
    /* Add to favorites button in card content */
    .add-to-favorites {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 15px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid var(--gold);
        color: white;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 15px;
        font-size: 0.9rem;
    }
    
    .add-to-favorites:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .add-to-favorites i {
        color: var(--gold);
    }
    
    .add-to-favorites.active {
        background: var(--gold);
        color: var(--dark-blue);
    }
    
    .add-to-favorites.active i {
        color: var(--dark-blue);
    }
    
    .card-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
  </style>
</head>
<body>

<header id="mainHeader">
   <a href="index.php" style="text-decoration: none; color: inherit;">
  <h1 class="logo">City Guide</h1>
</a>
  <nav>
    <ul class="nav-links">
      <li><a href="index.php" data-en="Home" data-fr="Accueil" data-ar="الرئيسية">Home</a></li>
      <li><a href="restaurants.php" data-en="Restaurants" data-fr="Restaurants" data-ar="مطاعم">Restaurants</a></li>
      <li><a href="hotels.php" data-en="Hotels" data-fr="Hôtels" data-ar="فنادق">Hotels</a></li>
      <li><a href="activities.php" class="active" data-en="Activities" data-fr="Activités" data-ar="أنشطة">Activities</a></li>
      <li><a href="facilities.php" data-en="Facilities" data-fr="Installations" data-ar="مرافق">Facilities</a></li>
      <li><a href="history.html" data-en="History" data-fr="Histoire" data-ar="تاريخ">History</a></li>
      <li><a href="infos.html" data-en="Info" data-fr="Infos" data-ar="معلومات">Info</a></li>
    </ul>
  </nav>
  <div class="actions">
    <select id="languageSwitch">
      <option value="en">EN</option>
      <option value="fr">FR</option>
      <option value="ar">AR</option>
    </select>
    <button id="modeToggle"><i class="fas fa-moon"></i> Dark Mode</button>
    <a href="user-dashboard.php" class="profile-btn" title="Account">
            <i class="fas fa-user"></i>
          </a>
  </div>
</header>

<main class="page-content">
  <br>
  <br>
  <br>

  <br>
  <br>
  <br>
  <br>
  <h1 class="section-title" data-en="Adventure Activities in Skikda" data-fr="Activités d'Aventure à Skikda" data-ar="أنشطة المغامرة في سكيكدة">Adventure Activities in Skikda</h1>
  
  <div class="cards-grid">
  <?php foreach ($activities as $activity): ?>
    <div class="unified-card animate">
      <button class="favorite-btn" data-activity-id="<?= htmlspecialchars($activity['id']) ?>">
        <i class="far fa-heart"></i>
      </button>

      <img src="<?= htmlspecialchars($activity['image']) ?>" alt="<?= htmlspecialchars($activity['name']) ?>">

      <div class="unified-card-content">
        <h3><?= htmlspecialchars($activity['name']) ?></h3>

        <p><?= nl2br(htmlspecialchars($activity['description'] ?? '')) ?></p>

        <div class="location">
          <i class="fas fa-map-marker-alt"></i>
          <a href="<?= htmlspecialchars($activity['location_url']) ?>" target="_blank">
            View on Map
          </a>
        </div>

        <div class="card-actions">
          <button class="add-to-favorites" data-activity-id="<?= htmlspecialchars($activity['id']) ?>">
            <i class="far fa-heart"></i> <span>Add to Favorites</span>
          </button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>


<footer>
    <div class="footer-grid">
      <div class="footer-col">
        <h4 data-en="About Us" data-fr="À propos" data-ar="معلومات عنا">About Us</h4>
        <p data-en="Discover the beauty and history of Skikda with our expert guides."
           data-fr="Découvrez la beauté et l'histoire de Skikda avec nos guides experts."
           data-ar="اكتشف جمال وتاريخ سكيكدة مع مرشدينا الخبراء.">
          Discover the beauty and history of Skikda with our expert guides.
        </p>
      </div>
      <div class="footer-col">
        <h4 data-en="Quick Links" data-fr="Liens rapides" data-ar="روابط سريعة">Quick Links</h4>
        <ul>
          <li><a href="index.html" data-en="Home" data-fr="Accueil" data-ar="الرئيسية">Home</a></li>
          <li><a href="facilities.html" data-en="Facilities" data-fr="Installations" data-ar="مرافق">Facilities</a></li>
          <li><a href="activities.html" data-en="Activities" data-fr="Activités" data-ar="أنشطة">Activities</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4 data-en="Contact" data-fr="Contact" data-ar="اتصل بنا">Contact</h4>
        <ul>
          <li><i class="fas fa-map-marker-alt"></i> Skikda, Algeria</li>
          <li><i class="fas fa-phone"></i> +213 123 456 789</li>
          <li><i class="fas fa-envelope"></i> info@skikdatours.com</li>
        </ul>
      </div>
    </div>
    <div class="copyright">
      <p>&copy; <span id="year"></span> <span data-en="Skikda Tours" data-fr="Tours Skikda" data-ar="جولات سكيكدة">Skikda Tours</span>. <span data-en="All rights reserved." data-fr="Tous droits réservés." data-ar="جميع الحقوق محفوظة.">All rights reserved.</span></p>
    </div>
  </footer>

<script src="index.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Set current year in footer
    const yearEl = document.getElementById('year');
    if (yearEl) {
      yearEl.textContent = new Date().getFullYear();
    }

    // Favorite button logic
    const favoriteBtns = document.querySelectorAll('.favorite-btn, .add-to-favorites');
    const savedFavorites = JSON.parse(localStorage.getItem('favoriteHotels')) || {};

    favoriteBtns.forEach(btn => {
      const hotelId = btn.getAttribute('data-hotel-id');
      const icon = btn.querySelector('i');
      if (savedFavorites[hotelId]) {
        btn.classList.add('active');
        if (icon) {
          icon.classList.remove('far');
          icon.classList.add('fas');
        }
      }

      btn.addEventListener('click', function () {
        const icon = this.querySelector('i');
        const hotelId = this.getAttribute('data-hotel-id');

        this.classList.toggle('active');

        if (this.classList.contains('active')) {
          savedFavorites[hotelId] = true;
          if (icon) {
            icon.classList.remove('far');
            icon.classList.add('fas');
          }
          showToast('Added to favorites!');
        } else {
          delete savedFavorites[hotelId];
          if (icon) {
            icon.classList.remove('fas');
            icon.classList.add('far');
          }
          showToast('Removed from favorites');
        }

        localStorage.setItem('favoriteHotels', JSON.stringify(savedFavorites));
      });
    });

    // Toast message
    function showToast(message) {
      const toast = document.createElement('div');
      toast.textContent = message;
      toast.style.position = 'fixed';
      toast.style.bottom = '20px';
      toast.style.right = '20px';
      toast.style.backgroundColor = 'var(--gold)';
      toast.style.color = 'var(--dark-blue)';
      toast.style.padding = '10px 20px';
      toast.style.borderRadius = '5px';
      toast.style.zIndex = '1000';
      toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
      document.body.appendChild(toast);

      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s';
        setTimeout(() => toast.remove(), 500);
      }, 2000);
    }
  });
</script>
</body>
</html>