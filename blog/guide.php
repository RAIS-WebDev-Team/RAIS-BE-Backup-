<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Immigration Guide - Roman & Associates Immigration Services LTD</title>
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

        html {
            height: 100%;
        }
         /* Scrollbar */
    ::-webkit-scrollbar { width: 12px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #3BA43B, #0C470C); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #45b945, #0a3a0a); }

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
        }

        /* --- Main Content Section --- */
        main {
            width: 90%;
            max-width: 1200px;
            margin: 3rem auto;
        }

        .guide-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .guide-header h1 {
            font-size: 2.8rem;
            color: var(--heading-color);
            font-weight: 700;
        }

        .guide-header p {
            font-size: 1.1rem;
            color: var(--text-color);
            max-width: 700px;
            margin: 0.5rem auto 0;
        }

        .timeline {
            position: relative;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .timeline::after {
            content: '';
            position: absolute;
            width: 4px;
            background-color: var(--primary-color);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -2px;
            opacity: 0.3;
        }

        .step-container {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }

        .step-container.left {
            left: 0;
        }

        .step-container.right {
            left: 50%;
        }
        
        .step-container::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -12.5px;
            background-color: white;
            border: 4px solid var(--primary-color);
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }

        .step-container.right::after {
            left: -12.5px;
        }

        .step-content {
            padding: 20px 30px;
            background-color: var(--surface-color);
            position: relative;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-left: 4px solid var(--primary-color);
        }
        
        .step-content h2 {
            color: var(--heading-color);
            font-weight: 600;
            font-size: 1.5rem;
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
            .timeline::after {
                left: 31px;
            }
            .step-container {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            .step-container.left, .step-container.right {
                left: 0%;
            }
            .step-container::after {
                left: 18px;
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
        <div class="guide-header">
            <h1>Your Journey to Canada</h1>
            <p>Navigating the immigration process can be complex. Here is a step-by-step guide to help you understand the key stages of your journey with us.</p>
        </div>

        <div class="timeline">
            <div class="step-container left">
                <div class="step-content">
                    <h2>Step 1: Initial Consultation</h2>
                    <p>Your journey begins with a one-on-one consultation with a Regulated Canadian Immigration Consultant (RCIC). We'll discuss your goals, assess your qualifications, and outline the best immigration pathways for you.</p>
                </div>
            </div>
            <div class="step-container right">
                <div class="step-content">
                    <h2>Step 2: Strategy & Documentation</h2>
                    <p>Once a pathway is chosen, we develop a detailed strategy. We provide you with a comprehensive checklist of all required documents and guide you in gathering and preparing them to meet Canadian immigration standards.</p>
                </div>
            </div>
            <div class="step-container left">
                <div class="step-content">
                    <h2>Step 3: Application Submission</h2>
                    <p>Our team meticulously reviews your application and supporting documents to ensure accuracy and completeness. We then professionally submit your application to the appropriate Canadian immigration authorities on your behalf.</p>
                </div>
            </div>
             <div class="step-container right">
                <div class="step-content">
                    <h2>Step 4: Follow-Up & Communication</h2>
                    <p>We act as your official representative, handling all communication with the government. We keep you informed of your application's progress and promptly respond to any requests for additional information.</p>
                </div>
            </div>
             <div class="step-container left">
                <div class="step-content">
                    <h2>Step 5: Decision & Pre-Arrival</h2>
                    <p>Once a decision is made, we notify you immediately. If your application is approved, we provide pre-arrival guidance and resources to help you prepare for your new life in Canada.</p>
                </div>
            </div>
        </div>

    </main>

    <div id="footer-placeholder">
        <?php include '../footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
