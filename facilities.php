<?php
include 'includes/db.php';

try {
    $stmt = $conn->prepare("SELECT * FROM establishments WHERE type = 'facility' ORDER BY created_at DESC");
    $stmt->execute();
    $facilities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debugging - uncomment if still having issues
    // echo "<pre>"; print_r($facilities); echo "</pre>";
    
    if (empty($facilities)) {
        echo "<p class='error'>No facilities found in database</p>";
    }
} catch (PDOException $e) {
    echo "<p class='error'>Database error: " . $e->getMessage() . "</p>";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Facilities - Skikda | Mediterranean Elegance</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="index.css">
  <style>
    /* Hero Section */
    .facilities-hero {
      height: 70vh;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      overflow: hidden;
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.5)), url('assets/images/facilities/faci.jpg') no-repeat center center/cover;
      margin-top: 0px;
    }

    .facilities-hero-content {
      position: relative;
      z-index: 2;
      max-width: 800px;
      padding: 0 20px;
    }

    .facilities-hero h1 {
      font-size: 4.5rem;
      margin-bottom: 20px;
      font-family: 'Playfair Display', serif;
      text-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .facilities-hero p {
      font-size: 1.5rem;
      margin-bottom: 30px;
      text-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }

    /* Facilities Section */
    .facilities-section {
      padding: 100px 6%;
      background: var(--sand);
      position: relative;
    }

    /* Enhanced Facility Cards */
    .facilities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 40px;
      max-width: 1400px;
      margin: 0 auto;
    }

    .facility-card {
      background: var(--card-bg);
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 20px 60px var(--shadow-color);
      transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      z-index: 20;
      height: 85;
      display: flex;
      flex-direction: column;
      transform: translateY(40px);
      opacity: 0;
    }

    .facility-card.in-view {
      transform: translateY(0);
      opacity: 1;
    }

    .facility-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(212,175,55,0.1) 0%, rgba(10,31,61,0.1) 100%);
      z-index: -1;
      opacity: 0;
      transition: opacity 0.5s;
    }

    .facility-card:hover {
      transform: translateY(-15px);
      box-shadow: 0 30px 80px rgba(0,0,0,0.2);
    }

    .facility-card:hover::before {
      opacity: 1;
    }

    .card-header {
      height: 300px;
      background: var(--navy);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .card-header img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

   

    .card-header::after {
      content: '';
      position: absolute;
      bottom: -20px;
      left: 0;
      width: 200%;
      height: 10px;
      background: var(--sand);
      transform: skewY(-3deg);
      z-index: 11;
    }

    .card-icon {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 60px;
      height: 60px;
      background: var(--gold);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--navy);
      font-size: 24px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      transition: all 0.6s;
      z-index: 0;
    }

    .facility-card:hover .card-icon {
      transform: scale(1.2) rotate(15deg);
      background: var(--navy);
      color: var(--gold);
    }

    .card-content {
      padding: 30px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .card-content h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem;
      margin-bottom: 15px;
      color: var(--black);
      position: relative;
      display: inline-block;
    }

    .card-content h3::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--gold);
      transition: width 0.5s;
    }

    .facility-card:hover .card-content h3::after {
      width: 100%;
    }

    .card-content p {
      color: var(--black);
      line-height: 1.6;
      margin-bottom: 20px;
      opacity: 0.8;
      flex: 1;
    }

    .card-link {
      display: inline-flex;
      align-items: center;
      color: var(--gold);
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
      margin-top: auto;
    }

    .card-link i {
      margin-left: 8px;
      transition: transform 0.3s;
    }

    .facility-card:hover .card-link {
      color: var(--navy);
    }

    .facility-card:hover .card-link i {
      transform: translateX(5px);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .facilities-hero h1 {
        font-size: 3rem;
      }
      
      .facilities-hero p {
        font-size: 1.2rem;
      }
      
      .facilities-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <!-- HEADER -->
  <header id="mainHeader">
       <a href="index.php" style="text-decoration: none; color: inherit;">
  <h1 class="logo">City Guide</h1>
</a>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php" data-en="Home" data-fr="Accueil" data-ar="الرئيسية">Home</a></li>
        <li><a href="restaurants.php" data-en="Restaurants" data-fr="Restaurants" data-ar="مطاعم">Restaurants</a></li>
        <li><a href="hotels.php" data-en="Hotels" data-fr="Hôtels" data-ar="فنادق">Hotels</a></li>
        <li><a href="activities.php" data-en="Activities" data-fr="Activités" data-ar="أنشطة">Activities</a></li>
        <li><a href="facilities.php" class="active" data-en="Facilities" data-fr="Installations" data-ar="مرافق">Facilities</a></li>
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
      <button id="modeToggle"><i class="fas fa-moon"></i> <span data-en="Dark Mode" data-fr="Mode Sombre" data-ar="الوضع المظلم">Dark Mode</span></button>
      <a href="user-dashboard.php" class="profile-btn" title="Account">
            <i class="fas fa-user"></i>
          </a>
        </li>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="facilities-hero" data-aos="fade">
    <div class="facilities-hero-content">
      <h1 data-en="City Facilities" data-fr="Installations Urbaines" data-ar="مرافق المدينة">City Facilities</h1>
      <p data-en="Essential services and amenities in Skikda" data-fr="Services et équipements essentiels à Skikda" data-ar="الخدمات والمرافق الأساسية في سكيكدة">Essential services and amenities in Skikda</p>
    </div>
  </section>

 <!-- Facilities Grid Section -->
  <section class="facilities-section">
    <h2 class="section-title" data-en="Key Locations" data-fr="Lieux Clés" data-ar="مواقع رئيسية">Key Locations</h2>
    
    <div class="facilities-grid">
    <?php foreach ($facilities as $facility): ?>
        <!-- Facility Card -->
        <div class="facility-card" data-aos="fade-up">
            <div class="card-header">
                <img src="<?= htmlspecialchars($facility['image']) ?>" alt="<?= htmlspecialchars($facility['name']) ?>">
               <div class="card-icon"><i class="fas fa-building"></i></div>
            </div>
            <div class="card-content">
                <h3 data-en="<?= htmlspecialchars($facility['name']) ?>" data-fr="<?= htmlspecialchars($facility['name']) ?>" data-ar="<?= htmlspecialchars($facility['name']) ?>"><?= htmlspecialchars($facility['name']) ?></h3>
                <p data-en="<?= htmlspecialchars($facility['description']) ?>" data-fr="<?= htmlspecialchars($facility['description']) ?>" data-ar="<?= htmlspecialchars($facility['description']) ?>">
                    <?= htmlspecialchars($facility['description']) ?>
                </p>
                <a href="<?= htmlspecialchars($facility['location_url']) ?>" target="_blank" class="card-link" data-en="View on Map" data-fr="Voir sur la carte" data-ar="عرض على الخريطة">
                    View on Map <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
  </section>

  <!-- FOOTER -->
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
          <li><a href="index.php" data-en="Home" data-fr="Accueil" data-ar="الرئيسية">Home</a></li>
          <li><a href="facilities.php" data-en="Facilities" data-fr="Installations" data-ar="مرافق">Facilities</a></li>
          <li><a href="activities.php" data-en="Activities" data-fr="Activités" data-ar="أنشطة">Activities</a></li>
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

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="index.js"></script>
  <script>
    // Initialize AOS animation
    AOS.init({
      duration: 800,
      once: true
    });

    // Set current year in footer
    document.getElementById('year').textContent = new Date().getFullYear();

    // Intersection Observer for card animations
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
        }
      });
    }, { threshold: 0.2 });

    document.querySelectorAll('.facility-card').forEach(card => {
      observer.observe(card);
    });
  </script>
</body>
</html>