<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FAQ - Roman & Associates Immigration Services LTD</title>
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
            --footer-bg: #0a3a0a;
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
            margin-bottom: 2rem;
            font-weight: 700;
            line-height: 1.2;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 0.5rem;
            display: inline-block;
        }
        
        /* --- Accordion Styles for FAQ --- */
        .accordion-item {
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        .accordion-header {
            background-color: #fdfdfd;
            padding: 1rem 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: var(--heading-color);
            transition: background-color 0.3s ease;
        }
        .accordion-header:hover {
            background-color: #f5f5f5;
        }
        .accordion-header::after {
            content: '\f078'; /* Font Awesome down arrow */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            transition: transform 0.3s ease;
        }
        .accordion-item.active .accordion-header::after {
            transform: rotate(180deg);
        }
        .accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-in-out, padding 0.5s ease-in-out;
            background-color: var(--surface-color);
        }
        .accordion-content {
            padding: 1.5rem;
            border-top: 1px solid var(--light-gray);
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
        <div class="content-card" id="faq">
            <h1>Frequently Asked Questions</h1>

            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">What types of Canadian immigration services do you offer?</div>
                    <div class="accordion-body">
                        <div class="accordion-content">
                            <p>We offer a comprehensive range of services, including assistance with study permits, work permits, visitor visas, family sponsorships, and permanent residency applications. We guide you through the entire process, from initial assessment to final submission.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">Are you a licensed immigration firm?</div>
                    <div class="accordion-body">
                        <div class="accordion-content">
                            <p>Yes, we are a licensed Canadian immigration firm. Our consultants are Regulated Canadian Immigration Consultants (RCICs) in good standing with the Immigration Consultants of Canada Regulatory Council (ICCRC), ensuring our services meet the highest ethical and professional standards.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">How do I start the immigration process with you?</div>
                    <div class="accordion-body">
                        <div class="accordion-content">
                            <p>The first step is to book a consultation with one of our experts. During this session, we will assess your eligibility, discuss your goals, and recommend the best immigration pathway for you. You can book an appointment through our website or by contacting our office directly.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header">What are your fees?</div>
                    <div class="accordion-body">
                        <div class="accordion-content">
                            <p>Our fees vary depending on the complexity of the case and the type of application. We believe in transparency and will provide you with a detailed breakdown of all costs, including our professional fees and government processing fees, before we begin any work.</p>
                        </div>
                    </div>
                </div>
                 <div class="accordion-item">
                    <div class="accordion-header">Do you serve clients outside of Canada?</div>
                    <div class="accordion-body">
                        <div class="accordion-content">
                            <p>Absolutely. We serve clients from all over the world. We have successfully assisted individuals and families from Asia, the Middle East, and many other regions in their journey to Canada. We use modern communication tools to provide seamless service regardless of your location.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="footer-placeholder">
        <?php include '../footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const accordionItems = document.querySelectorAll('.accordion-item');

            accordionItems.forEach(item => {
                const header = item.querySelector('.accordion-header');
                header.addEventListener('click', () => {
                    const currentlyActive = document.querySelector('.accordion-item.active');
                    if (currentlyActive && currentlyActive !== item) {
                        currentlyActive.classList.remove('active');
                        currentlyActive.querySelector('.accordion-body').style.maxHeight = 0;
                    }

                    item.classList.toggle('active');
                    const body = item.querySelector('.accordion-body');
                    if (item.classList.contains('active')) {
                        body.style.maxHeight = body.scrollHeight + 'px';
                    } else {
                        body.style.maxHeight = 0;
                    }
                });
            });
        });
    </script>
</body>

</html>
