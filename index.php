<?php
// Data for the page - this can be fetched from a database in a real application
$page_title = "RAIS HOME";

// Services Offered Data
$services = [
    ["title" => "Caregiver Permit", "url" => "Service Offered/caregiver.php", "img" => "img/Fcaregiver.jpg"],
    ["title" => "Work Permit", "url" => "Service Offered/work.php", "img" => "img/Fwork.jpg"],
    ["title" => "Visit (Tourist Visa) Permit", "url" => "Service Offered/visitpermit.php", "img" => "img/Fvisit.jpg"],
    ["title" => "Permanent Residency (PR)", "url" => "Service Offered/PR.php", "img" => "img/Fpr.jpg"],
    ["title" => "Family Sponsorship", "url" => "Service Offered/fam.php", "img" => "img/Ffam.jpg"],
    ["title" => "Labour Market Impact Assessment (LMIA)", "url" => "Service Offered/lmia.php", "img" => "img/Flmia.jpg"],
    ["title" => "Study Permit", "url" => "Service Offered/study.php", "img" => "img/Fstudy.jpg"]
];

// Blogs/Map Data
$locations = [
    ["title" => "Student Life at La Salle Lipa", "summary" => "Experience education and values at La Salle.", "coordinates" => [13.9412, 121.1621], "url" => "blog/la-salle.php"],
    ["title" => "Tech & Training at STI Lipa", "summary" => "A look into STI Lipa’s modern curriculum.", "coordinates" => [13.9416, 121.1628], "url" => "blog/sti-lipa.php"],
    ["title" => "IELTS Prep at 9.0 Niner Calamba", "summary" => "Reviewing English with proven techniques.", "coordinates" => [14.2133, 121.1658], "url" => "blog/calamba.php"],
    ["title" => "Learning English in Tacloban", "summary" => "ELA helps students master the language.", "coordinates" => [11.2410, 125.0016], "url" => "blog/tacloban.php"]
];

// Partners Data
$partners = [
    [
        "name" => "9.0 Niner IELTS Review and Tutorial",
        "logo" => "img/niner.png",
        "backgroundImage" => "https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto-format&fit=crop",
        "url" => "https://www.nineronlinereview.com/"
    ],
    [
        "name" => "British Council IELTS",
        "logo" => "img/partner2.png",
        "backgroundImage" => "https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=2069&auto-format&fit=crop",
        "url" => "https://takeielts.britishcouncil.org/"
    ]
];

// Exams Data
$exams = [
    [
        "name" => "IELTS",
        "description" => "The International English Language Testing System is the world's most popular English language proficiency test for higher education and global migration.",
        "image" => "img/ielts.png",
        "alt" => "People taking the IELTS Exam",
        "url" => "ielts.php"
    ],
    [
        "name" => "OET",
        "description" => "The Occupational English Test (OET) evaluates the English language and communication skills essential for safe and effective patient care for healthcare professionals.",
        "image" => "img/OET.jpg",
        "alt" => "Healthcare professionals in a discussion",
        "url" => "oet.php"
    ]
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/logoulit.png" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* --- Splash Screen Styles --- */
        #splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 1;
            transition: opacity 1.5s ease-out;
            z-index: 10000;
            background-color: #000;
        }

        #splash-screen.fade-out {
            opacity: 0;
            pointer-events: none; /* Make it unclickable after fading */
        }

        #animation-video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }

        #skip-animation-btn {
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #058305ff, #b4ee72ff);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            cursor: pointer;
            z-index: 10001;
            font-size: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            animation: pulse 2s infinite;
        }

        #skip-animation-btn:hover {
            transform: scale(1.1);
            animation: none;
            filter: brightness(1.2);
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            70% {
                box-shadow: 0 0 0 20px rgba(255, 255, 255, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }
        
        /* --- Main Page Styles --- */
        html {
            min-height: 100%;
        }

        body {
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
            background-color: white;
            margin: 0;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Initially hide the main content */
        #main-content {
            display: none;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        #main-content > main {
            flex-grow: 1;
        }

        /* When splash is hidden, restore normal body scrolling */
        body.splash-hidden {
            overflow: auto;
            overflow-x: hidden;
        }

        /* During splash, hide the scrollbar */
        body.splash-visible {
            overflow: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #0C470C, #3BA43B);
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #023621, #2a7c2a);
        }

        .hero .display-1,
        .hero .fs-3 {
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.8);
        }
        
        /* --- Responsive Header Styles --- */
        .header-desktop {
            top: 0;
            width: 100%;
            z-index: 10;
        }
        .header-desktop .logo-img {
            height: 150px;
        }
        .nav-container-desktop {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        .nav-container-desktop .nav-link {
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
            transition: transform 0.3s ease;
        }
        .nav-container-desktop .nav-link:hover {
            transform: translateY(-2px);
        }
        .login-icon-wrapper {
            width: 60px;
            height: 60px;
            transition: transform 0.3s ease;
        }
        .login-icon-wrapper:hover {
            transform: scale(1.1);
        }

        .header-mobile {
            top: 0;
            width: 100%;
            z-index: 10;
        }
        .header-mobile .logo-img {
            height: 120px;
        }
        .navbar-toggler {
            border: none;
        }
        .navbar-toggler:hover{
            transform: scale(1.1);
        }
        .navbar-toggler:focus {
            box-shadow: none;
        }
        .navbar-collapse {
            background: rgba(12, 71, 12, 0.9); /* Green background for mobile nav */
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border-radius: 15px;
            margin-top: 1rem;
            padding: 1rem 1.5rem;
            width: auto; /* Make dropdown smaller */
            position: absolute;
            right: 1rem;
            top: 60%;
        }
        .navbar-nav .nav-item {
            text-align: left; /* Align text to the left */
            padding: 0.25rem 0; /* Reduced padding */
        }
        @media (max-width: 991.98px) {
            .hero .display-1 {
                font-size: 3rem;
            }
            .hero .fs-3 {
                font-size: 1.25rem;
            }
        }

        .video-container video {
            width: 100%;
            border-radius: 8px;
        }

        .expanded-about-wrapper {
            background-color: #fafcfa;
            max-height: 0;
            overflow: hidden;
            transition: max-height 1.2s ease-in-out;
            border-top: 1px solid #E0E0E0;
        }

        .expanded-about-wrapper.is-open {
            max-height: 3500px;
        }

        .expanded-nav {
            background: #f0f5f0;
            padding: 1rem 3rem;
            border-top: 1px solid #E0E0E0;
            border-bottom: 1px solid #E0E0E0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .expanded-nav a {
            margin: 0.5rem;
            text-decoration: none;
            color: #0C470C;
            font-weight: 600;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .expanded-nav a.active,
        .expanded-nav a:hover {
            background-color: #0C470C;
            color: white;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .content-box {
            background: #FFFFFF;
            border: 1px solid #E0E0E0;
            border-radius: 8px;
            margin-top: 1.5rem;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #0C470C;
        }

        .expanded-content h3 {
            color: #023621;
            margin-top: 0.5rem;
            border-bottom: 2px solid #0C470C;
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        .objectives-list li:not(:last-child) {
            margin-bottom: 1rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .service-section {
            color: black;
        }

        .full-height-center {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5rem 1rem 1rem;
        }

        .card-stack {
            position: relative;
            height: 320px;
            max-width: 500px;
            margin: auto;
            perspective: 1000px;
            margin-top: 50px;
        }

        .card-link {
            position: absolute;
            width: 100%;
            height: 300px;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-decoration: none;
            background-color: #ccc;
            transform: translate(calc(var(--i) * 30px), calc(var(--i) * -30px)) rotate(calc(var(--i) * 3deg));
            z-index: calc(10 - var(--i));
            transition: transform 1.5s ease, box-shadow 1.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .card-link:hover {
            transform: translate(calc(var(--i) * 30px), calc(var(--i) * -30px)) scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.5);
        }

        .card-link img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .card-link:nth-child(1) {
            background-color: #C2D6C3;
        }

        .card-link:nth-child(2) {
            background-color: #FFE0B3;
        }

        .card-link:nth-child(3) {
            background-color: #C8775D;
        }

        .card-link:nth-child(4) {
            background-color: #F19D6D;
        }

        .card-link:nth-child(5) {
            background-color: #F3C982;
        }

        .card-link:nth-child(6) {
            background-color: #7D9C7B;
        }

        .card-link:nth-child(7) {
            background-color: #5D8B6D;
        }

        .section-title {
            text-align: center;
            margin-bottom: 2.5rem;
            font-weight: 600;
            color: #023621;
            font-size: 3rem;
        }

        #map {
            height: 550px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border: 3px solid #0C470C;
        }

        .partner-info {
            background: linear-gradient(100deg, #0e640e, #0C470C);
            padding: 4rem;
            color: white;
        }

        .partner-info h2 {
            font-weight: 600;
        }

        .partner-info p {
            font-size: 1.4rem;
            line-height: 1.8;
        }

        .partner-image-wrapper {
            position: relative;
            background-size: cover;
            background-position: center;
            transition: background-image 0.4s ease-in-out;
        }

        .partner-image-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, #0C470C 0%, transparent 70%);
            z-index: 1;
        }

        .partner-image-content {
            position: relative;
            z-index: 2;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 2rem;
            color: white;
            transition: opacity 0.4s ease-in-out;
        }

        .partner-image-content img {
            max-height: 110px;
            margin-bottom: 1.5rem;
        }

        .partner-image-content p {
            font-size: 1.4rem;
            font-weight: 500;
        }

        .partner-image-content .h5 {
            font-size: 1.7rem;
        }

        .partner-image-content a {
            background-color: white;
            color: #333;
            padding: 0.6rem 1.75rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .partner-image-content a:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .exam-carousel-item img {
            height: 500px;
            object-fit: cover;
            border-radius: 12px;
        }

        .exam-carousel .carousel-control-prev,
        .exam-carousel .carousel-control-next {
            width: 50px;
            height: 50px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .exam-carousel .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #0C470C;
        }

        .exam-text-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            padding-right: 2rem;
        }

        #exams .exam-text-content h2 {
            color: #000;
            font-weight: 700;
            font-size: 2.8rem;
        }

        #exams .exam-text-content p {
            color: #000;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .arrow-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .arrow-buttons button {
            width: 44px;
            height: 44px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }

        .arrow-buttons button i {
            display: none;
        }

        .arrow-buttons button::before {
            content: '';
            display: block;
            width: 10px;
            height: 10px;
            border-style: solid;
            border-width: 3px 3px 0 0;
        }

        .partner-info .arrow-buttons button {
            background-color: white;
            border: 1px solid #ddd;
        }

        .partner-info .arrow-buttons button::before {
            border-color: #0C470C;
        }

        .partner-info .arrow-buttons button:hover {
            background-color: #f5f5f5;
            transform: scale(1.1);
        }

        #next-partner::before {
            transform: translateX(-2px) rotate(45deg);
        }

        #prev-partner::before {
            transform: translateX(2px) rotate(-135deg);
        }

        .btn-green {
            background-color: #0C470C;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-green:hover {
            background-color: #023621;
            transform: translateY(-3px);
        }

        @media (max-width: 991.98px) {
            .exam-text-content {
                padding-right: 0;
                text-align: center;
            }
            .partner-image-wrapper::before {
                background: linear-gradient(to bottom, #0C470C 5%, transparent 70%);
            }
            .partner-info {
                text-align: center;
                padding: 3rem 2rem;
            }
            .partner-info h2 {
                text-align: center !important;
            }
        }

        @media (max-width: 768px) {
            .hero .display-1 {
                font-size: 3rem;
            }

            .hero .fs-3 {
                font-size: 1.25rem;
            }

            #services .card-stack {
                position: static;
                height: 320px;
                overflow-y: scroll;
                scroll-snap-type: y mandatory;
                -webkit-overflow-scrolling: touch;
            }

            #services .card-link {
                position: relative;
                height: 300px;
                transform: none !important;
                scroll-snap-align: start;
                z-index: auto;
                margin-bottom: 1rem;
            }

            #services .card-link:hover {
                transform: scale(1.02) !important;
            }

            #services .card-link img {
                height: 220px;
            }

            #services .full-height-center {
                padding: 1.5rem 1rem;
                min-height: auto;
                display: block;
            }

            .text-section {
                text-align: center;
                margin-bottom: 1.5rem;
            }

            .expanded-nav {
                padding: 1rem;
            }

            .expanded-nav a {
                flex-grow: 1;
                text-align: center;
            }

            .content-box {
                padding: 1rem;
            }

            .partner-image-wrapper::before {
                background: linear-gradient(to bottom, #0C470C 5%, transparent 70%);
            }

            .partner-info {
                text-align: center;
                padding: 3rem 2rem;
            }

            .partner-info h2 {
                text-align: center !important;
            }
        }
    </style>
</head>

<body class="splash-visible">
    <!-- Splash Screen -->
    <div id="splash-screen">
        <video id="animation-video" autoplay muted playsinline>
            <source src="vids/intro4.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <button id="skip-animation-btn" title="Skip Animation">
            <i class="bi bi-skip-forward-fill"></i>
        </button>
    </div>

    <!-- Main Content Wrapper -->
    <div id="main-content">
        <main>
            <!-- Main page content -->
            <section class="hero position-relative text-white" style="min-height: 100vh; overflow: hidden;">
                <video autoplay muted loop playsinline class="position-absolute w-100 h-100"
                    style="object-fit: cover; top: 0; left: 0; z-index: -1;">
                    <source src="vids/niagarapoh.mp4" type="video/mp4" />
                    Your browser does not support HTML5 video.
                </video>
                
                <!-- DESKTOP HEADER -->
                <header class="d-none d-lg-flex justify-content-between align-items-center py-4 px-5 position-absolute header-desktop">
                    <a href="index.php">
                        <img src="img/logo.png" alt="RAIS Logo" class="logo-img">
                    </a>
                    <div class="nav-container-desktop">
                        <ul class="navbar-nav flex-row">
                            <li class="nav-item"><a class="nav-link text-white fs-5 mx-3" href="#about">About</a></li>
                            <li class="nav-item"><a class="nav-link text-white fs-5 mx-3" href="#services">Services</a></li>
                            <li class="nav-item"><a class="nav-link text-white fs-5 mx-3" href="#blogs">Blogs</a></li>
                            <li class="nav-item"><a class="nav-link text-white fs-5 mx-3" href="#partners">Partner</a></li>
                            <li class="nav-item"><a class="nav-link text-white fs-5 mx-3" href="#exams">Exams</a></li>
                            <li class="nav-item"><a class="nav-link text-white fs-5 mx-3" href="#footerWrapper">Contacts</a></li>
                        </ul>
                    </div>
                    <a href="login.php" class="d-flex align-items-center justify-content-center bg-white rounded-circle text-decoration-none login-icon-wrapper">
                        <i class="bi bi-person fs-3 text-success"></i>
                    </a>
                </header>

                <!-- MOBILE HEADER -->
                <header class="d-lg-none position-absolute header-mobile">
                    <nav class="navbar navbar-dark py-3 px-4">
                        <div class="container-fluid justify-content-between">
                            <a class="navbar-brand" href="index.php">
                                <img src="img/logo.png" alt="RAIS Logo" class="logo-img">
                            </a>
                            <div class="d-flex align-items-center">
                                <a href="login.php" class="d-flex align-items-center justify-content-center bg-white rounded-circle text-decoration-none login-icon-wrapper me-2" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person fs-4 text-success"></i>
                                </a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="bi bi-list" style="font-size: 2.5rem;"></i>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse" id="navbarContent">
                                <ul class="navbar-nav mt-3">
                                    <li class="nav-item"><a class="nav-link fs-5" href="#about">About</a></li>
                                    <li class="nav-item"><a class="nav-link fs-5" href="#services">Services</a></li>
                                    <li class="nav-item"><a class="nav-link fs-5" href="#blogs">Blogs</a></li>
                                    <li class="nav-item"><a class="nav-link fs-5" href="#partners">Partner</a></li>
                                    <li class="nav-item"><a class="nav-link fs-5" href="#exams">Exams</a></li>
                                    <li class="nav-item"><a class="nav-link fs-5" href="#footerWrapper">Contacts</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </header>

                <div class="d-flex flex-column justify-content-center align-items-center text-center px-3"
                    style="min-height: 100vh;">
                    <h1 class="display-1 fw-bold" style="font-family:'Poppins', 'sans-serif';">TARA CANADA!</h1>
                    <p class="fs-3 fst-italic mt-2 mb-4">The Best Pathway to your future</p>
                    <a href="register.php" class="btn btn-lg text-white fw-bold rounded-pill px-4 py-2 btn-green">Get Started</a>
                </div>
            </section>

            <!-- Other sections of your main page -->
            <section id="about" class="pt-5 position-relative"
                style="padding-bottom: 11rem; background-image: url('img/logoulit.png'); background-size: cover; background-attachment: fixed; background-position: center; color: #333;">
                <div
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(247, 249, 249, 0.9);">
                </div>
                <div class="container position-relative">
                    <div class="card overflow-hidden"
                        style="border-radius: 12px; box-shadow: 0 8px 24px rgba(16, 42, 67, 0.1); border-left: 6px solid #0C470C;">
                        <div class="card-body p-4 p-lg-5">
                            <div class="row align-items-center g-4">
                                <div class="col-lg-6 video-container">
                                    <video src="vids/about_vid.mov" loop autoplay controls muted
                                        poster="https://placehold.co/600x400/e2e8f0/e2e8f0?text=Video"></video>
                                </div>
                                <div class="col-lg-6">
                                    <h2 style="color: #023621; font-weight: 700;">About Roman & Associates Immigration Services LTD</h2>
                                    <p class="fs-5 my-4" style="line-height: 1.7;">We are a licensed Canadian immigration firm based in
                                        Vancouver Island BC, providing expert advice on visas, permits, and sponsorships to help people
                                        achieve a brighter future in Canada.</p>
                                    <button id="learnMoreBtn" class="btn btn-lg text-white fw-bold btn-green">Learn More</button>
                                </div>
                            </div>
                        </div>
                        <div class="expanded-about-wrapper" id="expandedAboutWrapper">
                            <div class="card-body p-4 p-lg-5">
                                <p>Canadian Immigration Consultants are able to help and support with the processing and documentation
                                    needed to work, study or immigrate to Canada. This process may seem overwhelming and confusing. We at
                                    Roman & Associates Immigration Services Ltd are here to provide support and services for your
                                    immigration needs and make it simple.</p>
                                <p>We are registered Canadian Immigration consultants with active good standing with ICCRC. Book an
                                    appointment now to see how your life can change.</p>
                                <p>We offer Immigration Services to clients across British Columbia including cities: Nanaimo, Ladysmith,
                                    Duncan, Parksville, Vancouver, Victoria, Richmond, Surrey, and the rest of Canada except Quebec.</p>
                                <p>We also serve across China, Japan, Philippines, Korea, Hong Kong, Saudi Arabia, UAE, Singapore, and the
                                    rest of the world.</p>
                            </div>
                            <nav class="expanded-nav">
                                <a href="#" data-target="mission" class="active">Mission</a>
                                <a href="#" data-target="vision">Vision</a>
                                <a href="#" data-target="objectives">Objectives</a>
                                <a href="#" data-target="background">Background</a>
                            </nav>
                            <div class="card-body p-4 p-lg-5 expanded-content">
                                <div class="content-box">
                                    <section id="mission" class="content-section active">
                                        <h3>Mission Statement</h3>
                                        <p>To provide honest, transparent, and expert Canadian immigration consulting services, empowering
                                            individuals and families worldwide to achieve better opportunities and a brighter future in Canada.
                                        </p>
                                    </section>
                                    <section id="vision" class="content-section">
                                        <h3>Vision Statement</h3>
                                        <p>To be a trusted global leader in Canadian immigration consultancy—known for our integrity,
                                            personalized service, and commitment to helping clients successfully build a new life in Canada.</p>
                                    </section>
                                    <section id="objectives" class="content-section">
                                        <h3>Company Objectives</h3>
                                        <ul class="objectives-list">
                                            <li><strong>Deliver Expert Guidance:</strong> Continuously provide up-to-date, professional
                                                immigration advice on Canadian visas including study permits, work permits, visit visas, and
                                                family sponsorships.</li>
                                            <li><strong>Uphold Integrity and Transparency:</strong> Maintain 100% honesty in all client
                                                interactions, fostering long-term trust and confidence in our services.</li>
                                            <li><strong>Stay Informed and Compliant:</strong> Attend regular industry seminars, training, and
                                                regulatory updates to ensure compliance with the latest Canadian immigration laws and policies.
                                            </li>
                                            <li><strong>Expand Global Reach:</strong> Serve clients not only across Canada (except Quebec) but
                                                also in Asia, the Middle East, and beyond, helping more individuals access life-changing
                                                opportunities.</li>
                                            <li><strong>Enhance Client Support:</strong> Offer personalized, compassionate support that
                                                motivates and encourages clients throughout their immigration journey.</li>
                                            <li><strong>Ensure Affordable Excellence:</strong> Provide high-quality services at reasonable fees,
                                                reflecting the care, diligence, and dedication poured into every application.</li>
                                            <li><strong>Promote Responsible Immigration:</strong> Actively contribute to Canada’s values by
                                                supporting qualified, deserving applicants and helping them integrate successfully into Canadian
                                                society.</li>
                                        </ul>
                                    </section>
                                    <section id="background" class="content-section">
                                        <h3>Company Background</h3>
                                        <p>Roman Canadian Immigration Services is a licensed Canadian immigration consultancy firm founded on
                                            December 1, 2016, and proudly based on Vancouver Island, British Columbia, Canada. We specialize in
                                            providing professional, transparent, and client-focused immigration services for individuals and
                                            families aiming to visit, study, work, or settle in Canada.</p>
                                        <p>Our firm is led by a Regulated Canadian Immigration Consultant (RCIC) and operates in full
                                            compliance with the Immigration Consultants of Canada Regulatory Council (ICCRC)—ensuring that all
                                            our services meet the highest standards of ethical and legal practice.</p>
                                        <p> With nearly a decade of experience in the immigration industry, we have successfully guided
                                            clients from various parts of the world—including the Philippines, Japan, China, Korea, Saudi
                                            Arabia, UAE, Singapore, and Hong Kong—through the complex immigration process. We also serve clients
                                            across British Columbia and other Canadian provinces, excluding Quebec.</p>
                                        <p>At Roman Canadian Immigration Services, we pride ourselves on our integrity, transparency, and
                                            dedication. We believe that each client deserves personalized attention, honest advice, and
                                            unwavering support throughout their immigration journey. Our commitment to lifelong learning and
                                            adaptation allows us to stay updated with the latest policies and pathways introduced by the
                                            Canadian government.</p>
                                        <p>Over the years, we have helped hundreds of clients realize their dream of starting a new life in
                                            Canada. Whether it's pursuing higher education, reuniting with loved ones, or securing a better job
                                            opportunity, we’re here to support our clients every step of the way.</p>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="services" class="service-section">
                <div class="container full-height-center">
                    <div class="row justify-content-center align-items-center text-center text-md-start w-100">
                        <div class="col-12 col-md-4 text-section mb-md-0">
                            <h1><strong>Service Offered</strong></h1>
                            <p>High-quality solutions with expert support and convenience.</p>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="card-stack">
                                <?php foreach ($services as $index => $service) : ?>
                                    <a href="<?php echo htmlspecialchars($service['url']); ?>" class="card-link" style="--i:<?php echo $index; ?>;">
                                        <?php echo htmlspecialchars($service['title']); ?>
                                        <img src="<?php echo htmlspecialchars($service['img']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" />
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="blogs" class="py-5 position-relative"
                style="background-image: url('img/logoulit.png'); background-size: cover; background-attachment: fixed; background-position: center; color: #333;">
                <div
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(247, 249, 249, 0.9);">
                </div>
                <div class="container position-relative">
                    <h2 class="section-title">Blogs and Events</h2>
                    <div id="map"></div>
                    <div class="text-center mt-4">
                        <a href="blogs.php" class="btn btn-lg text-white fw-bold btn-green">See More Blogs</a>
                    </div>
                </div>
            </section>

            <section id="partners">
                <div class="row g-0 partner-container-main">
                    <div class="col-lg-5 partner-info d-flex flex-column justify-content-center">
                        <h2 class="text-white mb-4 h1">Our Partners</h2>
                        <p>Our Partners provide expert immigration assistance to help individuals and families relocate smoothly.</p>
                        <div class="arrow-buttons mt-4">
                            <button id="prev-partner"></button>
                            <button id="next-partner"></button>
                        </div>
                    </div>
                    <div id="partner-image-wrapper" class="col-lg-7 partner-image-wrapper">
                        <div id="partner-image-content" class="partner-image-content"></div>
                    </div>
                </div>
            </section>

            <section id="exams" class="py-5 position-relative"
                style="background-image: url('img/lake.jpg'); background-size: cover; background-attachment: fixed; background-position: center;">
                <div
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(247, 249, 249, 0.9);">
                </div>
                <div class="container position-relative">
                    <h2 class="section-title">Browse Exams</h2>
                    <div class="row align-items-center g-5">
                        <div class="col-lg-5">
                            <div class="exam-text-content">
                                <h2 id="exam-title" class="mb-3"></h2>
                                <p id="exam-description"></p>
                                <div class="mt-4">
                                    <a id="exam-learn-more-btn" href="#" class="btn btn-lg text-white fw-bold btn-green">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div id="examCarousel" class="carousel slide exam-carousel" data-bs-ride="carousel"
                                data-bs-interval="10000">
                                <div class="carousel-indicators">
                                    <?php foreach ($exams as $index => $exam) : ?>
                                        <button type="button" data-bs-target="#examCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"
                                            aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
                                    <?php endforeach; ?>
                                </div>
                                <div class="carousel-inner">
                                    <?php foreach ($exams as $index => $exam) : ?>
                                        <div class="carousel-item exam-carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                            <img src="<?php echo htmlspecialchars($exam['image']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($exam['alt']); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#examCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#examCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
        <?php include 'footer.php'; ?>
    </div>

    <button class="back-to-top position-fixed bottom-0 end-0 mb-4 me-4 btn btn-success rounded-circle d-none"
        onclick="scrollToTop()" style="width: 50px; height: 50px; z-index: 999;">
        <i class="bi bi-arrow-up fs-4"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Pass PHP data to JavaScript
        const locations = <?php echo json_encode($locations); ?>;
        const partners = <?php echo json_encode($partners); ?>;
        const exams = <?php echo json_encode($exams); ?>;

        document.addEventListener("DOMContentLoaded", function () {
            const splashScreen = document.getElementById('splash-screen');
            const mainContent = document.getElementById('main-content');
            const animationVideo = document.getElementById('animation-video');
            const skipButton = document.getElementById('skip-animation-btn');
            
            let animationSkipped = false;

            function showMainContent() {
                if (splashScreen) {
                    splashScreen.style.display = 'none';
                }
                if(mainContent) {
                    mainContent.style.display = 'flex';
                }
                document.body.classList.remove('splash-visible');
                document.body.classList.add('splash-hidden');
            }
            
            // This function is now the single point for ending the animation
            const endAnimation = () => {
                // Prevent this from running multiple times (e.g., if skipped then video ends)
                if (animationSkipped) return;
                animationSkipped = true;

                if (splashScreen) {
                    splashScreen.classList.add('fade-out');
                }
                // Wait for the fade-out to finish
                setTimeout(showMainContent, 1500); 
            };

            function playAnimation() {
                if (animationVideo) {
                    animationVideo.addEventListener('ended', endAnimation);
                    animationVideo.onerror = () => {
                        console.error("Video could not be loaded or played.");
                        endAnimation(); // Also end if there's an error
                    };
                } else {
                     endAnimation(); // End immediately if no video
                }
            }

            // Add click listener for the skip button
            if (skipButton) {
                skipButton.addEventListener('click', endAnimation);
            }
            
            // Always play the animation on page load
            playAnimation();

            // --- Back to Top Button ---
            const backToTopBtn = document.querySelector('.back-to-top');
            if (backToTopBtn) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 200) {
                        backToTopBtn.classList.remove('d-none');
                    } else {
                        backToTopBtn.classList.add('d-none');
                    }
                });
            }
             // --- Learn More Toggle ---
            const learnMoreBtn = document.getElementById('learnMoreBtn');
            if(learnMoreBtn) {
                learnMoreBtn.addEventListener('click', function () { document.getElementById('expandedAboutWrapper').classList.toggle('is-open'); });
            }

            // --- Expanded Nav Tabs ---
            const navLinks = document.querySelectorAll('.expanded-nav a');
            const contentSections = document.querySelectorAll('.content-section');
            navLinks.forEach(link => { link.addEventListener('click', (e) => { e.preventDefault(); navLinks.forEach(l => l.classList.remove('active')); e.currentTarget.classList.add('active'); contentSections.forEach(s => s.classList.remove('active')); const targetId = e.currentTarget.getAttribute('data-target'); document.getElementById(targetId).classList.add('active'); }); });

            // --- Services Card Stack Animation ---
            const serviceCards = document.querySelectorAll('#services .card-link');
            let cardIndex = 0;

            function updateCards() {
                serviceCards.forEach((card, i) => {
                    const pos = (i - cardIndex + serviceCards.length) % serviceCards.length;
                    card.style.setProperty('--i', pos);
                });
            }

            function isMobile() {
                return window.innerWidth <= 768;
            }

            if (!isMobile() && serviceCards.length > 0) {
                updateCards();
                setInterval(() => {
                    cardIndex = (cardIndex + 1) % serviceCards.length;
                    updateCards();
                }, 2500);
            }

            // --- Leaflet Map for Blogs ---
            if (typeof L !== 'undefined' && document.getElementById('map')) {
                const map = L.map("map", {
                    maxBounds: [
                        [4.0, 116.0],
                        [21.5, 127.5]
                    ],
                    maxBoundsViscosity: 1.0
                }).setView([12.8797, 121.7740], 6);

                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: "© OpenStreetMap contributors",
                    minZoom: 6,
                    maxZoom: 18
                }).addTo(map);

                locations.forEach(location => {
                    const marker = L.marker(location.coordinates).addTo(map);
                    marker.bindPopup(`<h5>${location.title}</h5><p>${location.summary}</p><a href="${location.url}" target="_blank">Read Blog →</a>`);
                    marker.on('click', () => {
                        map.setView(location.coordinates, 13);
                    });
                });
            }

            // --- Partners Section Slider ---
            let currentPartnerIndex = 0;
            const partnerImageWrapper = document.getElementById('partner-image-wrapper');
            const partnerImageContent = document.getElementById('partner-image-content');
            const prevPartnerBtn = document.getElementById('prev-partner');
            const nextPartnerBtn = document.getElementById('next-partner');

            function showPartner(index) {
                if (partners && partners.length > 0 && partnerImageWrapper && partnerImageContent) {
                    const partner = partners[index];
                    partnerImageWrapper.style.backgroundImage = `url('${partner.backgroundImage}')`;
                    partnerImageContent.innerHTML = `<img src="${partner.logo}" alt="${partner.name} logo"><p class="mb-2">Official Test Centre</p><p class="h5 mb-3 fw-bold">${partner.name}</p><a href="${partner.url}" target="_blank">Visit Page</a>`;
                }
            }

            function slidePartner(direction) {
                if (!partnerImageContent) return;
                partnerImageContent.style.opacity = 0;
                setTimeout(() => {
                    if (direction === 'next') {
                        currentPartnerIndex = (currentPartnerIndex + 1) % partners.length;
                    } else {
                        currentPartnerIndex = (currentPartnerIndex - 1 + partners.length) % partners.length;
                    }
                    showPartner(currentPartnerIndex);
                    partnerImageContent.style.opacity = 1;
                }, 400);
            }

            if (prevPartnerBtn && nextPartnerBtn) {
                prevPartnerBtn.addEventListener('click', () => slidePartner('prev'));
                nextPartnerBtn.addEventListener('click', () => slidePartner('next'));
            }
            showPartner(currentPartnerIndex);

            // --- Exams Carousel Content Update ---
            const examCarousel = document.getElementById('examCarousel');
            const examTitle = document.getElementById('exam-title');
            const examDescription = document.getElementById('exam-description');
            const examLearnMoreBtn = document.getElementById('exam-learn-more-btn');

            function updateExamContent(index) {
                if (exams && exams.length > index && examTitle && examDescription && examLearnMoreBtn) {
                    const exam = exams[index];
                    examTitle.textContent = exam.name;
                    examDescription.textContent = exam.description;
                    examLearnMoreBtn.href = exam.url;
                }
            }

            if (examCarousel) {
                examCarousel.addEventListener('slide.bs.carousel', event => {
                    updateExamContent(event.to);
                });
                updateExamContent(0);
            }
        });
        
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</body>
</html>

