
<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
require 'test-connection.php';

// Fetch user reviews from the database
$reviews = $conn->query("
    SELECT comments.content, comments.created_at, users.username
    FROM comments
    JOIN users ON comments.user_id = users.id
    ORDER BY comments.created_at DESC
");

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skikda | Mediterranean Elegance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --navy: #0A1F3D;
            --sand: #E8D8C3;
            --rust: #B85C38;
            --white: #FFFFFF;
            --black: #121212;
            --bg-color: #FFFFFF;
            --text-color: #121212;
            --card-bg: #FFFFFF;
        }

        [data-theme="dark"] {
            --bg-color: #121212;
            --text-color: #E8D8C3;
            --card-bg: #1E1E1E;
            --navy: #1A2A4D;
            --sand: #3A3A3A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            overflow-x: hidden;
            background: var(--bg-color);
            transition: background 0.5s ease, color 0.5s ease;
        }

        /* Language Switch Button */
        .language-switch {
            position: fixed;
            top: 20px;
            right: 120px;
            z-index: 1000;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 5px;
            display: flex;
        }

        .language-btn {
            background: none;
            border: none;
            color: var(--text-color);
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .language-btn.active {
            background: var(--gold);
            color: var(--navy);
            border-radius: 15px;
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 5px 10px;
            border: none;
            color: var(--text-color);
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Luxury Header */
        header {
            position: fixed;
            width: 100%;
            padding: 28px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            background: rgba(10, 31, 61, 0.8);
        }

        header.scrolled {
            background: rgba(10, 31, 61, 0.95);
            padding: 18px 6%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 40px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--white);
            font-size: 14px;
            letter-spacing: 1.5px;
            position: relative;
            transition: color 0.4s;
        }

        .nav-links a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -5px;
            left: 0;
            background: var(--gold);
            transition: width 0.4s;
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        .nav-links a:hover:after {
            width: 100%;
        }

        .nav-links a.active {
            color: var(--gold);
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        #languageSwitch {
            background: rgba(255,255,255,0.2);
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
         
        }

        #modeToggle {
            background: rgba(255,255,255,0.2);
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: var(--white);
            cursor: pointer;
        }

        /* Cinematic Hero */
        .hero {
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(10, 31, 61, 0.7) 0%, rgba(10, 31, 61, 0.3) 100%);
        }

.hero-content {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end; /* This pushes content to the bottom */
    padding: 0 10% 80px; /* Added bottom padding (80px) */
    color: var(--white);
    position: relative;
    z-index: 2;
}
.hero-buttons {
    display: flex;
    gap: 15px; /* Reduced gap between buttons */
    margin-top: 30px; /* Slightly less space above buttons */
}

.hero-cta, .learn-more {
    display: inline-block;
    padding: 12px 28px; /* Smaller padding (was 18px 40px) */
    background: transparent;
    color: var(--white);
    border: 1px solid var(--gold);
    font-size: 13px; /* Slightly smaller font */
    letter-spacing: 1.5px; /* Reduced letter spacing */
    text-decoration: none;
    transition: all 0.4s; /* Faster transition */
    opacity: 0;
    transform: translateY(30px); /* Less initial translation */
    animation: fadeInUp 0.8s 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; /* Faster animation */
    border-radius: 4px; /* Added subtle rounding */
    font-weight: 500; /* Slightly bolder */
}

.hero-cta:hover, .learn-more:hover {
    background: var(--gold);
    color: var(--navy);
    transform: translateY(-2px); /* Added lift effect on hover */
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3); /* Subtle glow */
}
        /* Luxury Card Grid */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            text-align: center;
            margin-bottom: 80px;
            color: var(--navy);
            position: relative;
            padding-bottom: 20px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 2px;
            background: var(--gold);
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            padding: 120px 10%;
        }

        .card {
            position: relative;
            height: 500px;
            overflow: hidden;
            border-radius: 5px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
            transform: translateY(60px);
            opacity: 0;
            transition: transform 0.8s, opacity 0.8s;
            background: var(--card-bg);
        }

        .card.in-view {
            transform: translateY(0);
            opacity: 1;
        }

        .card-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card:hover .card-video {
            transform: scale(1.1);
        }

        .card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 40px;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: var(--white);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card:hover .card-content {
            transform: translateY(0);
            opacity: 1;
        }

        .card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        /* Enhanced Services Section */
        .services-section {
            padding: 100px 10%;
            background: var(--sand);
            position: relative;
            overflow: hidden;
        }

        .services-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            position: relative;
            z-index: 2;
        }

        .services-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            text-align: center;
            margin-bottom: 60px;
            color: var(--navy);
            position: relative;
        }

        .services-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--gold);
        }

        .service-card {
            background: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 1;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        .service-card::before {
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

        .service-card:hover::before {
            opacity: 1;
        }

        .service-img-container {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .service-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .service-card:hover .service-img {
            transform: scale(1.1);
        }

        .service-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            font-size: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.5s;
        }

        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(15deg);
            background: var(--navy);
            color: var(--gold);
        }

        .service-content {
            padding: 25px;
            position: relative;
        }

        .service-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--navy);
            position: relative;
            display: inline-block;
        }

        .service-content h3::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.5s;
        }

        .service-card:hover .service-content h3::after {
            width: 100%;
        }

        .service-content p {
            color: var(--text-color);
            line-height: 1.6;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .service-link {
            display: inline-flex;
            align-items: center;
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .service-link i {
            margin-left: 8px;
            transition: transform 0.3s;
        }

        .service-card:hover .service-link {
            color: var(--navy);
        }

        .service-card:hover .service-link i {
            transform: translateX(5px);
        }

        .services-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            background-image: radial-gradient(var(--gold) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: 1;
        }

        /* Luxury Parallax Section */
        .parallax-section {
            height: 70vh;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .parallax-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 31, 61, 0.6);
        }

        .parallax-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 20px;
        }

        .parallax-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .parallax-content p {
            font-size: 1.2rem;
            font-style: italic;
            opacity: 0.9;
        }
        /* Add Review Section */
.add-review-container {
    max-width: 800px;
    margin: 60px auto 0;
    padding: 40px;
    background: var(--white);
    border-radius: 10px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.add-review-container h3 {
    font-family: 'Playfair Display', serif;
    color: var(--navy);
    margin-bottom: 30px;
    text-align: center;
    font-size: 1.8rem;
}

.review-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group input,
.form-group textarea {
    padding: 15px;
    border: 1px solid rgba(10, 31, 61, 0.2);
    border-radius: 5px;
    font-family: 'Montserrat', sans-serif;
    font-size: 1rem;
    transition: all 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--gold);
    box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
}

.rating-group {
    flex-direction: row;
    align-items: center;
    gap: 15px;
}

.stars {
    display: flex;
    gap: 5px;
}

.stars i {
    font-size: 1.5rem;
    color: var(--sand);
    cursor: pointer;
    transition: color 0.2s;
}

.stars i:hover,
.stars i.active {
    color: var(--gold);
}

.submit-review-btn {
    padding: 15px 30px;
    background: var(--gold);
    color: var(--navy);
    border: none;
    border-radius: 5px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.3s;
}

.submit-review-btn:hover {
    background: var(--navy);
    color: var(--gold);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(10, 31, 61, 0.2);
}

        /* Luxury Testimonials */
        .testimonials {
            padding: 150px 10%;
            background: var(--sand);
            text-align: center;
        }

        .testimonial-slider {
            max-width: 800px;
            margin: 0 auto;
        }

        .testimonial {
            padding: 40px;
            background: var(--white);
            border-radius: 5px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin: 20px;
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s;
        }

        .testimonial.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        .testimonial-text {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 30px;
            font-style: italic;
            color: var(--navy);
        }

        .testimonial-author {
            font-family: 'Playfair Display', serif;
            color: var(--rust);
        }

        /* Luxury Footer */
        footer {
            padding: 120px 10% 60px;
            background: var(--navy);
            color: var(--white);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 60px;
            margin-bottom: 80px;
        }

        .footer-col h4 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            margin-bottom: 30px;
            color: var(--gold);
            position: relative;
            padding-bottom: 15px;
        }

        .footer-col h4:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 1px;
            background: var(--gold);
        }

        .footer-col a {
            display: block;
            color: var(--white);
            text-decoration: none;
            margin-bottom: 15px;
            transition: color 0.4s;
        }

        .footer-col a:hover {
            color: var(--gold);
        }

        .social-links {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-links a {
            color: var(--white);
            font-size: 18px;
            transition: color 0.4s;
        }

        .social-links a:hover {
            color: var(--gold);
        }

        .copyright {
            text-align: center;
            padding-top: 60px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Animations */
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* RTL Support */
        html[dir="rtl"] {
            direction: rtl;
        }
        html[dir="rtl"] .hero-content,
        html[dir="rtl"] .section-title,
        html[dir="rtl"] .services-container,
        html[dir="rtl"] .service-content {
            text-align: right;
        }
        html[dir="rtl"] .nav-links li {
            margin-left: 0;
            margin-right: 40px;
        }
        html[dir="rtl"] .nav-links a:after {
            left: auto;
            right: 0;
        }
        html[dir="rtl"] .service-icon {
            right: auto;
            left: 20px;
        }
        html[dir="rtl"] .service-link i {
            margin-left: 0;
            margin-right: 8px;
            transform: rotate(180deg);
        }
        html[dir="rtl"] .service-card:hover .service-link i {
            transform: rotate(180deg) translateX(5px);
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
            <button id="modeToggle">Dark/Light</button>
           <a href="<?= $isLoggedIn ? 'user-dashboard.php' : 'login-form.php' ?>" class="profile-btn" title="Account">

            <i class="fas fa-user"></i>
          </a>
        </li>
        </div>
    </header>

    <!-- Cinematic Hero with Video -->
    <section class="hero">
        <video autoplay muted loop class="hero-video">
            <source src="assets/clips/city.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
                <a href="history.html" class="learn-more" data-en="LEARN MORE" data-fr="EN SAVOIR PLUS" data-ar="معرفة المزيد">LEARN MORE</a>
            </div>
        </div>
    </section>

    <!-- Luxury Experiences Grid -->
    <section class="card-grid" id="experiences">
        <h2 class="section-title" data-en="Curated Experiences" data-fr="Expériences Sélectionnées" data-ar="تجارب مختارة">Curated Experiences</h2>
        
        <div class="card">
            <video autoplay muted loop class="card-video">
                <source src="assets/clips/beaches.mp4" type="video/mp4">
            </video>
            <div class="card-content">
                <h3 data-en="Historical Journeys" data-fr="Voyages Historiques" data-ar="رحلات تاريخية">Historical Journeys</h3>
                <p data-en="Exclusive guided tours of Rusicade's Roman ruins with archaeology experts"
                   data-fr="Visites guidées exclusives des ruines romaines de Rusicade avec des experts en archéologie"
                   data-ar="جولات إرشادية حصرية لآثار روسيكاد الرومانية مع خبراء الآثار">
                    Exclusive guided tours of Rusicade's Roman ruins with archaeology experts
                </p>
            </div>
        </div>
        
        <div class="card">
            <video autoplay muted loop class="card-video">
                <source src="assets/clips/hispty(1).mp4" type="video/mp4">
            </video>
            <div class="card-content">
                <h3 data-en="Kategoria Bazar" data-fr="Bazar Kategoria" data-ar="بازار كاتيجوريا">Kategoria Bazar</h3>
                <p data-en="Private shopping experiences in Skikda's historic markets with local guides"
                   data-fr="Expériences de shopping privé dans les marchés historiques de Skikda avec des guides locaux"
                   data-ar="تجارب تسوق خاصة في أسواق سكيكدة التاريخية مع مرشدين محليين">
                    Private shopping experiences in Skikda's historic markets with local guides
                </p>
            </div>
        </div>
    </section>

    <!-- Enhanced Services Section -->
    <section class="services-section">
        <div class="services-bg-pattern"></div>
        <h2 class="services-title" data-en="Our Services" data-fr="Nos services" data-ar="خدماتنا">Our Services</h2>
        
        <div class="services-container">
            <div class="service-card">
                <a href="restaurants.php" style="text-decoration: none; color: inherit;">
                    <div class="service-img-container">
                        <img src="assets/images/general/rest.jpg" alt="Restaurants" class="service-img">
                        <div class="service-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 data-en="Gourmet Dining" data-fr="Restaurants Gastronomiques" data-ar="مطاعم فاخرة">Gourmet Dining</h3>
                        <p data-en="Experience Skikda's finest culinary offerings from seaside cafes to upscale restaurants."
                           data-fr="Découvrez les meilleures offres culinaires de Skikda, des cafés en bord de mer aux restaurants haut de gamme."
                           data-ar="جرب أفضل العروض الطهوية في سكيكدة من المقاهي البحرية إلى المطاعم الفاخرة.">
                            Experience Skikda's finest culinary offerings from seaside cafes to upscale restaurants.
                        </p>
                        <span class="service-link" data-en="Explore" data-fr="Explorer" data-ar="اكتشف">
                            Explore <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <div class="service-card">
                <a href="hotels.php" style="text-decoration: none; color: inherit;">
                    <div class="service-img-container">
                        <img src="assets/images/general/photo_2025-04-18_15-30-48.jpg" alt="Hotels" class="service-img">
                        <div class="service-icon">
                            <i class="fas fa-hotel"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 data-en="Luxury Stays" data-fr="Séjours de Luxe" data-ar="إقامات فاخرة">Luxury Stays</h3>
                        <p data-en="Discover exquisite accommodations from boutique hotels to beachfront resorts."
                           data-fr="Découvrez des hébergements exquis, des hôtels boutique aux complexes balnéaires."
                           data-ar="اكتشف أماكن إقامة رائعة من فنادق بوتيك إلى منتجعات على الشاطئ.">
                            Discover exquisite accommodations from boutique hotels to beachfront resorts.
                        </p>
                        <span class="service-link" data-en="Explore" data-fr="Explorer" data-ar="اكتشف">
                            Explore <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <div class="service-card">
                <a href="facilities.php" style="text-decoration: none; color: inherit;">
                    <div class="service-img-container">
                        <img src="assets/images/general/fac.jpg" alt="Facilities" class="service-img">
                        <div class="service-icon">
                            <i class="fas fa-umbrella-beach"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 data-en="Premium Facilities" data-fr="Installations Premium" data-ar="مرافق فاخرة">Premium Facilities</h3>
                        <p data-en="Enjoy exclusive access to private beaches, wellness centers, and family amenities."
                           data-fr="Profitez d'un accès exclusif aux plages privées, centres de bien-être et équipements familiaux."
                           data-ar="استمتع بالوصول الحصري إلى الشواطئ الخاصة ومراكز الرفاهية ومرافق العائلة.">
                            Enjoy exclusive access to private beaches, wellness centers, and family amenities.
                        </p>
                        <span class="service-link" data-en="Explore" data-fr="Explorer" data-ar="اكتشف">
                            Explore <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
            
            <div class="service-card">
                <a href="activities.php" style="text-decoration: none; color: inherit;">
                    <div class="service-img-container">
                        <img src="assets/images/general/act.jpg" alt="Activities" class="service-img">
                        <div class="service-icon">
                            <i class="fas fa-sailboat"></i>
                        </div>
                    </div>
                    <div class="service-content">
                        <h3 data-en="Curated Activities" data-fr="Activités Sélectionnées" data-ar="أنشطة مختارة">Curated Activities</h3>
                        <p data-en="From yacht excursions to guided historical tours, we craft unforgettable experiences."
                           data-fr="Des excursions en yacht aux visites historiques guidées, nous créons des expériences inoubliables."
                           data-ar="من رحلات اليخت إلى الجولات التاريخية المصحوبة بمرشدين، نصنع تجارب لا تنسى.">
                            From yacht excursions to guided historical tours, we craft unforgettable experiences.
                        </p>
                        <span class="service-link" data-en="Explore" data-fr="Explorer" data-ar="اكتشف">
                            Explore <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Luxury Parallax Section -->
    <section class="parallax-section" style="background-image: url('https://images.unsplash.com/photo-1505118380757-91f5f5632de0?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80')">
        <div class="parallax-overlay"></div>
        <div class="parallax-content">
            <h2 data-en="Skikda is where the Mediterranean reveals its soul" 
                data-fr="Skikda est l'endroit où la Méditerranée révèle son âme"
                data-ar="سكيكدة هي المكان الذي يكشف فيه البحر الأبيض المتوسط عن روحه">
                "Skikda is where the Mediterranean reveals its soul"
            </h2>
            <p data-en="- Travel + Leisure Magazine" 
               data-fr="- Magazine Travel + Leisure"
               data-ar="- مجلة Travel + Leisure">
                - Travel + Leisure Magazine
            </p>
        </div>
    </section>

    
   <!-- Testimonials Section -->
<section class="testimonials">
    <h2 class="section-title" data-en="Guest Experiences" data-fr="Expériences Clients" data-ar="تجارب الضيوف">Guest Experiences</h2>
    <div class="testimonial-slider">
        <div class="testimonial">
            <p class="testimonial-text" data-en="The private tour of Rusicade's ruins was unforgettable. Our guide's knowledge brought the ancient city to life in ways we never imagined."
               data-fr="La visite privée des ruines de Rusicade était inoubliable. Les connaissances de notre guide ont donné vie à la ville antique d'une manière que nous n'avions jamais imaginée."
               data-ar="كانت الجولة الخاصة في أطلال روسيكاد لا تُنسى. جلب دليلنا المعرفة التي أحيَت المدينة القديمة بطرق لم نتخيلها أبدًا.">
                "The private tour of Rusicade's ruins was unforgettable. Our guide's knowledge brought the ancient city to life in ways we never imagined."
            </p>
            <p class="testimonial-author">- Sophia & James, London</p>
        </div>
        <div class="testimonial">
            <p class="testimonial-text" data-en="Dining on fresh seafood at a hidden beachfront restaurant as the sun set over the Mediterranean was the highlight of our Algerian journey."
               data-fr="Dîner de fruits de mer frais dans un restaurant caché en bord de mer tandis que le soleil se couchait sur la Méditerranée a été le point culminant de notre voyage en Algérie."
               data-ar="كان تناول المأكولات البحرية الطازجة في مطعم مخفي على شاطئ البحر بينما تغرب الشمس فوق البحر الأبيض المتوسط هو أبرز ما في رحلتنا إلى الجزائر.">
                "Dining on fresh seafood at a hidden beachfront restaurant as the sun set over the Mediterranean was the highlight of our Algerian journey."
            </p>
            <p class="testimonial-author">- The Chen Family, Singapore</p>
        </div>
    </div>
    
     <!-- Add Review Form -->
  <?php if ($isLoggedIn): ?>
  <div class="add-review-container">
    <h3 data-en="Share Your Experience" data-fr="Partagez votre expérience" data-ar="شارك تجربتك">Share Your Experience</h3>
    <form id="reviewForm" class="review-form">
      <div class="form-group">
        <textarea id="reviewText" name="reviewText" rows="4" required
          data-en-placeholder="Your review..."
          data-fr-placeholder="Votre avis..."
          data-ar-placeholder="مراجعتك..."></textarea>
      </div>
      <div class="form-group rating-group">
        <span data-en="Rating:" data-fr="Note:" data-ar="التقييم:">Rating:</span>
        <div class="stars">
          <i class="far fa-star" data-rating="1"></i>
          <i class="far fa-star" data-rating="2"></i>
          <i class="far fa-star" data-rating="3"></i>
          <i class="far fa-star" data-rating="4"></i>
          <i class="far fa-star" data-rating="5"></i>
        </div>
        <input type="hidden" id="reviewRating" name="reviewRating" value="0">
      </div>
      <button type="submit" class="submit-review-btn"
        data-en="Submit Review"
        data-fr="Soumettre l'avis"
        data-ar="إرسال المراجعة">Submit Review</button>
    </form>
  </div>
  <?php endif; ?>
</section>

<footer>
    
  <p>&copy; <?= date('Y') ?> city guide. All rights reserved.</p>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const stars = document.querySelectorAll('.stars i');
  const ratingInput = document.getElementById('reviewRating');

  stars.forEach(star => {
    star.addEventListener('click', function () {
      const rating = parseInt(this.getAttribute('data-rating'));
      ratingInput.value = rating;

      stars.forEach((s, index) => {
        if (index < rating) {
          s.classList.add('active', 'fas');
          s.classList.remove('far');
        } else {
          s.classList.remove('active', 'fas');
          s.classList.add('far');
        }
      });
    });
  });

  const reviewForm = document.getElementById('reviewForm');
  if (reviewForm) {
    reviewForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const reviewText = document.getElementById('reviewText').value.trim();
      const reviewRating = document.getElementById('reviewRating').value;

      fetch('submit-review.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `reviewText=${encodeURIComponent(reviewText)}&reviewRating=${reviewRating}`
      })
      .then(res => res.text())
      .then(response => {
        if (response === 'success') {
          alert('✅ Review submitted!');
          location.reload();
        } else {
          alert('❌ Error: ' + response);
        }
      });
    });
  }
});
</script>
</body>

   <script src="index.js" defer></script>
</html>