<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Roman & Associates Immigration Services LTD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #0C470C;
            --heading-color: #023621;
            --background-color: #F7F9F9;
            --surface-color: #FFFFFF;
            --text-color: #333333;
            --light-gray: #E0E0E0;
            --font-family: 'Poppins', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #3BA43B, #0C470C);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #45b945, #0a3a0a);
        }

        @media (max-width: 991px) {
            header {
                flex-wrap: wrap;
                position: relative;
            }

            header nav {
                display: none;
                flex-direction: column;
                width: 100%;
                text-align: center;
                background-color: var(--surface-color);
                padding: 1rem 0;
                position: absolute;
                top: 100%;
                left: 0;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                z-index: 999;
            }

            header nav.active {
                display: flex;
            }

            header nav a {
                padding: 0.5rem 0;
                margin: 0;
                border-bottom: 1px solid var(--light-gray);
            }

            header nav a:last-child {
                border-bottom: none;
            }

            .menu-toggle {
                display: flex;
            }
        }

        @media (max-width: 768px) {
            .blog-card {
                flex-direction: column;
                align-items: stretch;
            }

            .blog-card .card-content {
                padding: 1.5rem 0.5rem;
                text-align: center;
            }

            .card-content h5 {
                min-height: 0;
                justify-content: center;
            }

            .blog-card img {
                height: 220px;
            }

            .btn-back {
                top: 15px;
                left: 15px;
                width: 40px;
                height: 40px;
            }

            .btn-back i {
                font-size: 1rem;
            }
        }

        /* Set the box-sizing and ensure full height */
        html {
            height: 100%;
        }

        body {
            font-family: var(--font-family);
            line-height: 1.7;
            margin: 0;
            background-color: var(--background-color);
            color: var(--text-color);

            /* --- Sticky Footer Solution using CSS Grid --- */
            display: grid;
            grid-template-rows: auto 1fr auto;
            /* Header, Main, Footer */
            min-height: 100vh;
        }

        /* --- Header --- */
        header {
            background: var(--surface-color);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--light-gray);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        header .logo-container img {
            max-height: 45px;
        }

        header nav a {
            margin: 0 1rem;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 600;
            transition: color 0.3s ease;
        }

        header nav a:hover {
            color: var(--heading-color);
        }

        /* --- Main Content Section --- */
        main {
            width: 90%;
            max-width: 1200px;
            margin: 3rem auto;
            /* No flex-grow needed with Grid layout */
        }


        .about-us-card {
            background: var(--surface-color);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(16, 42, 67, 0.1);
            border-left: 6px solid var(--primary-color);
            overflow: hidden;
        }

        .about-us-card .card-section {
            padding: 2.5rem 3rem;
        }

        .about-intro {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .about-intro .video-container {
            flex: 1 1 50%;
        }

        .about-intro video {
            width: 100%;
            border-radius: 8px;
        }

        .about-intro .text-content {
            flex: 1 1 50%;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--heading-color);
            margin-bottom: 1rem;
            font-weight: 700;
            line-height: 1.2;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .learn-more-button {
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 400;
            color: white;
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .learn-more-button:hover {
            background-color: var(--heading-color);
        }

        .expanded-about-wrapper {
            background-color: #fafcfa;
            max-height: 0;
            overflow: hidden;
            transition: max-height 1.2s ease-in-out;
            border-top: 1px solid var(--light-gray);
        }

        .expanded-about-wrapper.is-open {
            max-height: 2500px;
            /* Adjust if content exceeds this height */
        }

        .expanded-about-wrapper .card-section p {
            font-size: 1rem;
        }

        .general-info {
            padding-bottom: 0 !important;
        }

        .expanded-nav {
            background: #f0f5f0;
            padding: 1rem 3rem;
            border-top: 1px solid var(--light-gray);
            border-bottom: 1px solid var(--light-gray);
        }

        .expanded-nav a {
            margin-right: 1rem;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 600;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }


        .expanded-nav a.active {
            background-color: var(--primary-color);
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
            border-left: 5px solid var(--primary-color);
        }

        .expanded-content h3 {
            color: var(--heading-color);
            margin-top: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
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

        .btn-back {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: #0C470C;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: var(--heading-color);
            transform: scale(1.1);
        }

        .btn-back i {
            font-size: 1.2rem;
        }


        /* --- Media Queries --- */
        @media (max-width: 992px) {
            .about-intro {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .about-us-card .card-section {
                padding: 1.5rem;
            }

            .expanded-nav {
                padding: 1rem 1.5rem;
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .expanded-nav a {
                margin-right: 0;
            }

            .content-box {
                padding: 1rem;
            }

            .btn-back {
                top: 15px;
                left: 15px;
                width: 40px;
                height: 40px;
            }

            .btn-back i {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo-container">
            <img src="img/logo.png" alt="RAIS Logo">
        </div>
        <nav>
            <a href="index.php">Home</a>
            <a href="#footer-placeholder">Contact</a>
        </nav>
    </header>

    <main>
        <a href="index.php" class="btn-back" aria-label="Go Back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="about-us-card" id="about">
            <div class="card-section about-intro">
                <div class="video-container">
                    <video src="vids/about_vid.mov" loop="true"
                        poster="https://play.teleporthq.io/static/svg/videoposter.svg" autoplay="true" controls="true"
                        muted></video>
                </div>
                <div class="text-content">
                    <h1>About Roman & Associates Immigration Services LTD</h1>
                    <p>We are a licensed Canadian immigration firm based in Vancouver Island BC, providing expert advice
                        on visas, permits, and sponsorships to help people achieve a brighter future in Canada.</p>
                    <button class="learn-more-button" id="learnMoreBtn">Learn More</button>
                </div>
            </div>

            <div class="expanded-about-wrapper" id="expandedAboutWrapper">
                <div class="card-section general-info">
                    <p>Canadian Immigration Consultants are able to help and support with the processing and
                        documentation needed to work, study or immigrate to Canada. This process may seem overwhelming
                        and confusing. We at Roman & Associates Immigration Services Ltd are here to provide support and
                        services for your immigration needs and make it simple.</p>
                    <p>We are registered Canadian Immigration consultants with active good standing with ICCRC. Book an
                        appointment now to see how your life can change.</p>
                    <p>We offer Immigration Services to clients across British Columbia including cities: Nanaimo,
                        Ladysmith, Duncan, Parksville, Vancouver, Victoria, Richmond, Surrey, and the rest of Canada
                        except Quebec.</p>
                    <p>We also serve across China, Japan, Philippines, Korea, Hong Kong, Saudi Arabia, UAE, Singapore,
                        and the rest of the world.</p>
                </div>

                <nav class="expanded-nav">
                    <a data-target="mission" class="active">Mission</a>
                    <a data-target="vision">Vision</a>
                    <a data-target="objectives">Objectives</a>
                    <a data-target="background">Background</a>
                </nav>

                <div class="card-section expanded-content">
                    <div class="content-box">
                        <section id="mission" class="content-section active">
                            <h3>Mission Statement</h3>
                            <p>To provide honest, transparent, and expert Canadian immigration consulting services,
                                empowering individuals and families worldwide to achieve better opportunities and a
                                brighter future in Canada.</p>
                        </section>
                        <section id="vision" class="content-section">
                            <h3>Vision Statement</h3>
                            <p>To be a trusted global leader in Canadian immigration consultancy—known for our
                                integrity, personalized service, and commitment to helping clients successfully build a
                                new life in Canada.</p>
                        </section>
                        <section id="objectives" class="content-section">
                            <h3>Company Objectives</h3>
                            <ul>
                                <li><strong>Deliver Expert Guidance:</strong> Continuously provide up-to-date,
                                    professional immigration advice on Canadian visas including study permits, work
                                    permits, visit visas, and family sponsorships.</li>
                                <li><strong>Uphold Integrity and Transparency:</strong> Maintain 100% honesty in all
                                    client interactions, fostering long-term trust and confidence in our services.</li>
                                <li><strong>Stay Informed and Compliant:</strong> Attend regular industry seminars,
                                    training, and regulatory updates to ensure compliance with the latest Canadian
                                    immigration laws and policies.</li>
                                <li><strong>Expand Global Reach:</strong> Serve clients not only across Canada (except
                                    Quebec) but also in Asia, the Middle East, and beyond, helping more individuals
                                    access life-changing opportunities.</li>
                                <li><strong>Enhance Client Support:</strong> Offer personalized, compassionate support
                                    that motivates and encourages clients throughout their immigration journey.</li>
                                <li><strong>Ensure Affordable Excellence:</strong> Provide high-quality services at
                                    reasonable fees, reflecting the care, diligence, and dedication poured into every
                                    application.</li>
                                <li><strong>Promote Responsible Immigration:</strong> Actively contribute to Canada’s
                                    values by supporting qualified, deserving applicants and helping them integrate
                                    successfully into Canadian society.</li>
                            </ul>
                        </section>
                        <section id="background" class="content-section">
                            <h3>Company Background</h3>
                            <p>Roman Canadian Immigration Services is a licensed Canadian immigration consultancy firm
                                founded on December 1, 2016, and proudly based on Vancouver Island, British Columbia,
                                Canada. We specialize in providing professional, transparent, and client-focused
                                immigration services for individuals and families aiming to visit, study, work, or
                                settle in Canada.</p>
                            <p>Our firm is led by a Regulated Canadian Immigration Consultant (RCIC) and operates in
                                full compliance with the Immigration Consultants of Canada Regulatory Council
                                (ICCRC)—ensuring that all our services meet the highest standards of ethical and legal
                                practice.</p>
                            <p>With nearly a decade of experience in the immigration industry, we have successfully
                                guided clients from various parts of the world—including the Philippines, Japan, China,
                                Korea, Saudi Arabia, UAE, Singapore, and Hong Kong—through the complex immigration
                                process. We also serve clients across British Columbia and other Canadian provinces,
                                excluding Quebec.</p>
                            <p>At Roman Canadian Immigration Services, we pride ourselves on our integrity,
                                transparency, and dedication. We believe that each client deserves personalized
                                attention, honest advice, and unwavering support throughout their immigration journey.
                                Our commitment to lifelong learning and adaptation allows us to stay updated with the
                                latest policies and pathways introduced by the Canadian government.</p>
                            <p>Over the years, we have helped hundreds of clients realize their dream of starting a new
                                life in Canada. Whether it's pursuing higher education, reuniting with loved ones, or
                                securing a better job opportunity, we’re here to support our clients every step of the
                                way.</p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="footer-placeholder">
        <?php include 'footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('learnMoreBtn').addEventListener('click', function () {
            document.getElementById('expandedAboutWrapper').classList.toggle('is-open');
        });

        const navLinks = document.querySelectorAll('.expanded-nav a');
        const contentSections = document.querySelectorAll('.content-section');

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                // Prevent the default anchor link behavior
                e.preventDefault();

                navLinks.forEach(l => l.classList.remove('active'));
                contentSections.forEach(s => s.classList.remove('active'));

                const clickedLink = e.currentTarget; // Use currentTarget for reliability
                clickedLink.classList.add('active');

                const target = clickedLink.getAttribute('data-target');
                document.getElementById(target).classList.add('active');
            });
        });
    </script>
</body>

</html>
