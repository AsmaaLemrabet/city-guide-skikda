<?php
include 'includes/db.php';
$stmt = $conn->prepare("SELECT * FROM establishments WHERE type = 'hotel' ORDER BY created_at DESC");
$stmt->execute();
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skikda Tours | Hotels</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <style>
:root {
    --gold: #d4af37;
    --dark-blue: #0a1f3d;
    --white: #ffffff;
    --card-bg: #0a1f3d;
}

/* Header Styles */
#mainHeader {
  
    background-color:#3E4D67;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px 70px 25px 70px; /* Removed top padding */
    position: sticky;
    top: 0;
    z-index: 1000;
    margin-top: 0; /* Added to remove top margin */
}

/* Body adjustment to remove space above header */
body {
    margin: 0;
    padding: 0;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.logo-link {
    text-decoration: none;
    color: inherit;
}

.logo {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    margin: 0;
    color: var(--dark-blue);
}

.main-nav {
    flex-grow: 1;
    margin: 0 40px;
}

.nav-links {
    display: flex;
    justify-content: center;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-links li {
    margin: 0 15px;
}

.nav-links a {
    text-decoration: none;
    color: var(--dark-blue);
    font-weight: 500;
    font-size: 1rem;
    transition: color 0.3s;
    padding: 5px 0;
    position: relative;
}

.nav-links a.active {
    color: var(--gold);
}

.nav-links a.active:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--gold);
}

.nav-links a:hover {
    color: var(--gold);
}

.header-actions {
    display: flex;
    align-items: center;
}

#modeToggle {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--dark-blue);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

#modeToggle i {
    font-size: 1rem;
}

/* Main Content Styles */
.page-content {
    min-height: calc(100vh - 300px);
    padding-top: 0; /* Removed top padding */
    margin-top: 0; /* Removed top margin */
}

/* Rest of your existing CSS remains exactly the same below this point */
.section-title {
    text-align: center;
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    color: var(--dark-blue);
    margin: 40px 0 20px;
    padding: 0 10%;
}

.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    padding: 60px 10%;
}

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
    pointer-events: none;
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

.like-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(0, 0, 0, 0.6);
    border: none;
    padding: 8px 15px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    z-index: 3;
    color: white;
    font-size: 14px;
    transition: all 0.3s ease;
}

.like-btn:hover {
    background: rgba(0, 0, 0, 0.8);
}

.like-btn.liked {
    background: rgba(212, 175, 55, 0.8);
}

.like-btn i {
    transition: all 0.3s ease;
}

.animate {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s ease;
}

.animate.in-view {
    opacity: 1;
    transform: translateY(0);
}

footer {
    background-color: var(--dark-blue);
    color: var(--white);
    padding: 40px 10%;
    margin-top: 40px;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.footer-col h4 {
    font-family: 'Playfair Display', serif;
    margin-bottom: 20px;
    font-size: 1.3rem;
    color: var(--gold);
}

.footer-col ul {
    list-style: none;
    padding: 0;
}

.footer-col ul li {
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.copyright {
    text-align: center;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid rgba(212, 175, 55, 0.2);
}

@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        padding: 10px;
    }
    
    .main-nav {
        margin: 15px 0;
        width: 100%;
    }
    
    .nav-links {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .nav-links li {
        margin: 5px 10px;
    }
    
    .cards-grid {
        grid-template-columns: 1fr;
        padding: 30px 5%;
        gap: 30px;
    }
    
    .section-title {
        font-size: 2rem;
        padding: 0 5%;
    }
}

@media (max-width: 480px) {
    .unified-card {
        height: 450px;
    }
    
    .unified-card-content {
        padding: 20px;
    }
    
    .footer-grid {
        grid-template-columns: 1fr;
    }
}
    </style>
</head>
<body>
    <!-- Header -->
    <header id="mainHeader">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <h1 class="logo">City Guide</h1>
        </a>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php" data-en="Home" data-fr="Accueil" data-ar="الرئيسية">Home</a></li>
                <li><a href="restaurants.php" data-en="Restaurants" data-fr="Restaurants" data-ar="مطاعم">Restaurants</a></li>
                <li><a href="hotels.php" class="active" data-en="Hotels" data-fr="Hôtels" data-ar="فنادق">Hotels</a></li>
                <li><a href="activities.php" data-en="Activities" data-fr="Activités" data-ar="أنشطة">Activities</a></li>
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
            <button id="modeToggle"><i class="fas fa-moon"></i> <span data-en="Dark Mode" data-fr="Mode Sombre" data-ar="الوضع المظلم">Dark Mode</span></button>
            <a href="user-dashboard.php" class="profile-btn" title="Account">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="page-content">
        <h1 class="section-title" data-en="Hotels in Skikda" data-fr="Hôtels à Skikda" data-ar="فنادق في سكيكدة">Hotels in Skikda</h1>
        <div class="cards-grid">
            <?php foreach ($hotels as $hotel): ?>
            <div class="unified-card animate">
                <!-- Like Button -->
                <button class="like-btn" 
                        data-item-id="<?= htmlspecialchars($hotel['id']) ?>" 
                        data-item-type="hotel">
                    <i class="far fa-heart"></i>
                    <span>Like</span>
                </button>

                <img src="<?= htmlspecialchars($hotel['image']) ?>" alt="<?= htmlspecialchars($hotel['name']) ?>" />
                
                <div class="unified-card-content">
                    <h3><?= htmlspecialchars($hotel['name']) ?></h3>
                    <p>
                        <span><?= str_repeat("★", (int) $hotel['rating']) ?></span> |
                        <span class="location">
                            <i class="fas fa-map-marker-alt"></i>
                            <a href="<?= htmlspecialchars($hotel['location_url']) ?>" target="_blank">
                                <?= htmlspecialchars(parse_url($hotel['location_url'], PHP_URL_HOST) ?? 'Location') ?>
                            </a>
                        </span>
                    </p>
                    <p><?= nl2br(htmlspecialchars($hotel['services'])) ?></p>
                    <div class="extras">
                        <p>⭐️ <?= number_format($hotel['rating'], 1) ?></p>
                        <?php if ($hotel['email']): ?>
                            <p>Email: <?= htmlspecialchars($hotel['email']) ?></p>
                        <?php endif; ?>
                        <?php if ($hotel['phone']): ?>
                            <p>Phone: <?= htmlspecialchars($hotel['phone']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
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
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Like system initialized');
        
        // Set current year in footer
        document.getElementById('year').textContent = new Date().getFullYear();

        // Improved event delegation for like buttons
        document.addEventListener('click', function(e) {
            const likeBtn = e.target.closest('.like-btn');
            if (likeBtn) {
                handleLikeClick(likeBtn);
            }
        });

        // Initialize like buttons on page load
        document.querySelectorAll('.like-btn').forEach(btn => {
            initLikeButton(btn);
        });

        // Initialize a like button
        async function initLikeButton(button) {
            const itemId = button.getAttribute('data-item-id');
            const itemType = button.getAttribute('data-item-type');
            
            try {
                const response = await fetch('check_like.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `item_id=${itemId}&item_type=${itemType}`
                });
                
                const result = await response.json();
                
                if (result.isLiked) {
                    setLikedState(button, true);
                }
            } catch (error) {
                console.error('Error checking like status:', error);
            }
        }

        // Handle like button click
        async function handleLikeClick(button) {
            const itemId = button.getAttribute('data-item-id');
            const itemType = button.getAttribute('data-item-type');
            const isLiked = button.classList.contains('liked');
            
            try {
                const response = await fetch('like_handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `item_id=${itemId}&item_type=${itemType}`
                });
                
                const result = await response.text();
                
                if (result === 'liked' || result === 'unliked') {
                    setLikedState(button, result === 'liked');
                    showToast(result === 'liked' ? 'Added to likes!' : 'Removed from likes');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error updating like');
            }
        }

        // Update button visual state
        function setLikedState(button, isLiked) {
            button.classList.toggle('liked', isLiked);
            const icon = button.querySelector('i');
            const span = button.querySelector('span');
            
            if (isLiked) {
                icon.classList.replace('far', 'fas');
                span.textContent = 'Liked';
            } else {
                icon.classList.replace('fas', 'far');
                span.textContent = 'Like';
            }
        }

        // Toast notification function
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

        // Language switch functionality
        const languageSwitch = document.getElementById('languageSwitch');
        if (languageSwitch) {
            languageSwitch.addEventListener('change', function() {
                const lang = this.value;
                updateLanguage(lang);
            });
        }

        function updateLanguage(lang) {
            document.querySelectorAll('[data-en]').forEach(element => {
                if (element.dataset[lang]) {
                    element.textContent = element.dataset[lang];
                }
            });

            const titleElement = document.querySelector('title');
            if (lang === 'en') {
                titleElement.textContent = 'Skikda Tours | Hotels';
            } else if (lang === 'fr') {
                titleElement.textContent = 'Skikda Tours | Hôtels';
            } else if (lang === 'ar') {
                titleElement.textContent = 'جولات سكيكدة | فنادق';
            }
        }

        // Intersection Observer for animations
        const animateElements = document.querySelectorAll('.animate');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                }
            });
        }, { threshold: 0.1 });
        
        animateElements.forEach(element => {
            observer.observe(element);
        });
    });
    </script>
</body>
</html>