<?php
include 'includes/db.php';
$stmt = $conn->prepare("SELECT * FROM establishments WHERE type = 'restaurant' ORDER BY created_at DESC");
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skikda Tours | Restaurants</title>
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
    
    /* Section title styling */
    .section-title {
        text-align: center;
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: var(--dark-blue);
        margin: 40px 0 20px;
        padding: 0 10%;
    }
    
    /* Footer styling */
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
</style>
</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skikda Tours | Restaurants</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <style>
        /* Your existing CSS styles here */
        :root {
            --gold: #d4af37;
            --dark-blue: #0a1f3d;
            --white: #ffffff;
            --card-bg: #0a1f3d;
        }
        
        /* Keep all your existing CSS styles */
        /* ... */
        
        /* Add this new style for the like button */
        .like-btn {
            position: absolute;
            top: 0px;
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
                <li><a href="restaurants.php" class="active" data-en="Restaurants" data-fr="Restaurants" data-ar="مطاعم">Restaurants</a></li>
                <li><a href="hotels.php" data-en="Hotels" data-fr="Hôtels" data-ar="فنادق">Hotels</a></li>
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
            <button id="modeToggle"><i class="fas fa-moon"></i> Dark Mode</button>
            <a href="user-dashboard.php" class="profile-btn" title="Account">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="page-content">
        <br>
        <br>
        <br>
        <br>
        
       
        <h1 class="section-title">Restaurants in Skikda</h1>
        <div class="cards-grid">
            <?php foreach ($restaurants as $restaurant): ?>
            <div class="unified-card animate">
                <button class="like-btn" 
                        data-item-id="<?= htmlspecialchars($restaurant['id']) ?>" 
                        data-item-type="restaurant">
                    <i class="far fa-heart"></i>
                    <span>Like</span>
                </button>

                <img src="<?= htmlspecialchars($restaurant['image']) ?>" alt="<?= htmlspecialchars($restaurant['name']) ?>" />
                <div class="unified-card-content">
                    <h3><?= htmlspecialchars($restaurant['name']) ?></h3>
                    <p>
                        <span class="location">
                            <i class="fas fa-map-marker-alt"></i>
                            <a href="<?= htmlspecialchars($restaurant['location_url']) ?>" target="_blank">
                                <?= htmlspecialchars(parse_url($restaurant['location_url'], PHP_URL_HOST) ?? 'Location') ?>
                            </a>
                        </span>
                    </p>
                    <p><?= nl2br(htmlspecialchars($restaurant['services'])) ?></p>
                    <div class="extras">
                        <?php if ($restaurant['email']): ?>
                            <p>Email: <?= htmlspecialchars($restaurant['email']) ?></p>
                        <?php endif; ?>
                        <?php if ($restaurant['phone']): ?>
                            <p>Phone: <?= htmlspecialchars($restaurant['phone']) ?></p>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all like buttons
        document.querySelectorAll('.like-btn').forEach(button => {
            // Check initial like status
            checkLikeStatus(button);
            
            // Add click handler
            button.addEventListener('click', function() {
                toggleLike(this);
            });
        });

        // Check if an item is liked
        async function checkLikeStatus(button) {
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
                    button.classList.add('liked');
                    button.innerHTML = '<i class="fas fa-heart"></i> <span>Liked</span>';
                }
            } catch (error) {
                console.error('Error checking like status:', error);
            }
        }

        // Toggle like status
        async function toggleLike(button) {
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
                    button.classList.toggle('liked');
                    const icon = button.querySelector('i');
                    icon.classList.toggle('far');
                    icon.classList.toggle('fas');
                    
                    const span = button.querySelector('span');
                    span.textContent = button.classList.contains('liked') ? 'Liked' : 'Like';
                    
                    showToast(button.classList.contains('liked') ? 'Added to likes!' : 'Removed from likes');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error updating like');
            }
        }

        // Show toast notification
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

        // Set current year in footer
        document.getElementById('year').textContent = new Date().getFullYear();

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

        // Language switch functionality
        const languageSwitch = document.getElementById('languageSwitch');
        languageSwitch.addEventListener('change', function() {
            const lang = this.value;
            updateLanguage(lang);
        });

        function updateLanguage(lang) {
            document.querySelectorAll('[data-en]').forEach(element => {
                if (element.dataset[lang]) {
                    element.textContent = element.dataset[lang];
                }
            });

            const titleElement = document.querySelector('title');
            if (lang === 'en') {
                titleElement.textContent = 'Skikda Tours | Restaurants';
            } else if (lang === 'fr') {
                titleElement.textContent = 'Skikda Tours | Restaurants';
            } else if (lang === 'ar') {
                titleElement.textContent = 'جولات سكيكدة | مطاعم';
            }
        }
    });
    </script>
</body>
</html>