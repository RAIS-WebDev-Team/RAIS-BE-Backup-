<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cookie Policy - Roman & Associates Immigration Services LTD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="icon" href="../img/logoulit.png">
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
         /* Scrollbar */
    ::-webkit-scrollbar { width: 12px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #3BA43B, #0C470C); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #45b945, #0a3a0a); }

        html {
            height: 100%;
        }

        body {
            font-family: var(--font-family);
            line-height: 1.7;
            margin: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            display: grid;
            grid-template-rows: auto 1fr auto;
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
        }

        .content-card {
            background: var(--surface-color);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(16, 42, 67, 0.1);
            border-left: 6px solid var(--primary-color);
            overflow: hidden;
            padding: 2.5rem 3rem;
        }

        .content-card h1 {
            font-size: 2.5rem;
            color: var(--heading-color);
            margin-bottom: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 0.5rem;
            display: inline-block;
        }
        
        .content-card h2 {
            font-size: 1.8rem;
            color: var(--heading-color);
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .content-card p, .content-card li {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .content-card ul {
            padding-left: 20px;
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

        /* --- Responsive Adjustments --- */
        @media (max-width: 768px) {
            main {
                width: 95%;
                margin: 2rem auto;
            }
            .content-card {
                padding: 1.5rem;
            }
            .content-card h1 {
                font-size: 2rem;
            }
            .content-card h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo-container">
            <img src="../img/logo.png" alt="RAIS Logo">
        </div>
        <nav>
            <a href="../index.php">Home</a>
            <a href="#footer-placeholder">Contact</a>
        </nav>
    </header>

    <main>
        <a href="../index.php" class="btn-back" aria-label="Go Back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="content-card" id="cookies">
            <h1>Cookie Policy</h1>
            <p>Last updated: August 29, 2025</p>

            <p>This Cookie Policy explains what cookies are and how we use them. You should read this policy to understand what cookies are, how we use them, the types of cookies we use, the information we collect using cookies and how that information is used, and how to control the cookie preferences.</p>

            <h2>What Are Cookies?</h2>
            <p>Cookies are small text files that are stored on your browser or the hard drive of your computer or other device when you visit a website. This allows the site to recognize you as a user either for the duration of your visit (using a ‘session cookie’) or for repeat visits (a ‘persistent cookie’).</p>

            <h2>How We Use Cookies</h2>
            <p>We use cookies for a variety of reasons detailed below. Unfortunately, in most cases, there are no industry standard options for disabling cookies without completely disabling the functionality and features they add to this site. It is recommended that you leave on all cookies if you are not sure whether you need them or not in case they are used to provide a service that you use.</p>
            
            <h2>Types of Cookies We Use</h2>
            <ul>
                <li><strong>Strictly Necessary Cookies:</strong> These cookies are essential for you to browse the website and use its features, such as accessing secure areas of the site.</li>
                <li><strong>Performance Cookies:</strong> These cookies collect information about how you use our website, e.g., which pages you visit, and if you experience any errors. These cookies do not collect any information that could identify you and are only used to help us improve how our website works.</li>
                <li><strong>Functionality Cookies:</strong> These cookies are used to provide services or to remember settings to improve your visit. For example, they may be used to remember your login details or language preference.</li>
            </ul>

            <h2>Managing Cookies</h2>
            <p>You can control and/or delete cookies as you wish. You can delete all cookies that are already on your computer and you can set most browsers to prevent them from being placed. If you do this, however, you may have to manually adjust some preferences every time you visit a site and some services and functionalities may not work.</p>

            <h2>Contact Us</h2>
            <p>If you have any questions about our use of cookies, please contact us.</p>
        </div>
    </main>

    <div id="footer-placeholder">
        <?php include '../footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
