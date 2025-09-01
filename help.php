<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Help Center - Roman & Associates Immigration Services LTD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="icon" href="img/logoulit.png">
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
         /* Scrollbar */
    ::-webkit-scrollbar { width: 12px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #3BA43B, #0C470C); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #45b945, #0a3a0a); }

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
        }

        /* --- Main Content Section --- */
        main {
            width: 90%;
            max-width: 1200px;
            margin: 3rem auto;
        }

        .help-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .help-header h1 {
            font-size: 2.8rem;
            color: var(--heading-color);
            font-weight: 700;
        }

        .help-header p {
            font-size: 1.1rem;
            color: var(--text-color);
            max-width: 600px;
            margin: 0.5rem auto 0;
        }

        .help-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .help-card {
            background: var(--surface-color);
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 8px 24px rgba(16, 42, 67, 0.08);
            border-top: 4px solid var(--primary-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .help-card .icon {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .help-card h3 {
            font-size: 1.6rem;
            color: var(--heading-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .btn-help {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 1.5rem;
        }
        .btn-help:hover {
            background-color: var(--heading-color);
            color: white;
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
        <div class="help-header">
            <h1>Need Help?</h1>
            <p>We're here to assist you. Choose one of the options below to get in touch with our team or find the answers you need.</p>
        </div>

        <div class="help-options">
            <div class="help-card">
                <div>
                    <div class="icon"><i class="fas fa-comments"></i></div>
                    <h3>Chat With Us</h3>
                    <p>For existing clients, the fastest way to get help is by using the live chat feature in your dashboard.</p>
                </div>
                <a href="login.php" class="btn-help">Login Now</a>
            </div>

            <div class="help-card">
                <div>
                    <div class="icon"><i class="fas fa-book-open"></i></div>
                    <h3>View Guides</h3>
                    <p>Explore our step-by-step guides to better understand the immigration process and requirements.</p>
                </div>
                <a href="guide.php" class="btn-help">View Guides</a>
            </div>

            <div class="help-card">
                <div>
                    <div class="icon"><i class="fas fa-question-circle"></i></div>
                    <h3>Visit our FAQ</h3>
                    <p>Find answers to common questions about our services and the immigration process in our FAQ section.</p>
                </div>
                <a href="faq.php" class="btn-help">View FAQ</a>
            </div>
        </div>
    </main>

    <div id="footer-placeholder">
        <?php include 'footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
