<?php
// Page title
$page_title = "RAIS Blog | The Visitation";
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <link rel="icon" href="../img/logoulit.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary-color: #0C470C;
      --secondary-color: #FFC107;
      --background-color: #F7F9F9;
      --surface-color: #FFFFFF;
      --text-color: #333333;
      --heading-color: #023621;
      --light-gray: #E0E0E0;
      --font-family: 'Poppins', sans-serif;
      --heading-font: 'Archivo Black', sans-serif;
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

    .highlight {
      color: #3BA43B;
      font-weight: bold;
      text-decoration: underline;
      text-underline-offset: 8px;
    }

    body {
      font-family: var(--font-family);
      line-height: 1.7;
      margin: 0;
      padding: 0;
      background-color: var(--background-color);
      color: var(--text-color);
      display: grid;
      grid-template-rows: auto 1fr auto;
      min-height: 100vh;
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
      background-color: var(--primary-color);
      color: white;
      border-radius: 50%;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .btn-back:hover {
      background-color: var(--heading-color);
      transform: scale(1.1);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .btn-back i {
      font-size: 1.2rem;
    }

    header {
      background: var(--surface-color);
      padding: 1rem 5%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--light-gray);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
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
    
    .menu-toggle {
        display: none;
    }

    main {
      width: 90%;
      max-width: 800px;
      margin: 2rem auto;
    }

    .blog-post {
      background: var(--surface-color);
      padding: 2rem 3rem;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(16, 42, 67, 0.1);
      border-left: 5px solid var(--primary-color);
    }

    .blog-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .blog-title {
      font-size: 2.8rem;
      color: var(--heading-color);
      margin-bottom: 0.5rem;
      font-weight: 700;
      line-height: 1.2;
    }

    .author {
      color: #757575;
      margin-bottom: 1.5rem;
      font-style: italic;
    }

    .main-image {
      width: 100%;
      height: auto;
      aspect-ratio: 16 / 9;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 2rem;
    }

    .blog-post h2 {
      font-family: var(--heading-font);
      font-size: 1.8rem;
      color: var(--primary-color);
      font-weight: 600;
      margin-top: 3rem;
      border-bottom: 2px solid var(--primary-color);
      padding-bottom: 0.5rem;
      margin-bottom: 1.5rem;
    }

    .blog-post p {
      font-size: 1rem;
      margin-bottom: 1rem;
    }

    .highlight-text {
      color: var(--primary-color);
      font-weight: 600;
    }

    .event-card {
      background-color: var(--background-color);
      border: 1px solid var(--light-gray);
      border-radius: 12px;
      margin-top: 1.5rem;
      padding: 2rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-left: 5px solid var(--primary-color);
    }

    .event-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .event-card img {
      width: 100%;
      height: auto;
      aspect-ratio: 16 / 9;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 1.5rem;
    }

    .event-card h3 {
      font-family: var(--heading-font);
      font-size: 1.5rem;
      color: var(--heading-color);
      margin-top: 0;
      margin-bottom: 1rem;
    }
    @media (max-width: 768px) {
      header {
          flex-wrap: wrap;
      }
      header nav {
          display: none;
          width: 100%;
          flex-direction: column;
          text-align: center;
      }
      header nav.active {
          display: flex;
      }
      header nav a {
          padding: 0.5rem 0;
          border-top: 1px solid var(--light-gray);
      }
      .menu-toggle {
          display: block;
          cursor: pointer;
      }
      .blog-post {
        padding: 1.5rem;
      }
      .blog-title {
        font-size: 2.2rem;
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
  <a href="../blogs.php" class="btn-back" aria-label="Go Back">
    <i class="fas fa-arrow-left"></i>
  </a>

  <header>
    <div class="logo-container">
      <a href="../index.php"><img src="../img/logo.png" alt="RCIS Logo"></a>
    </div>
    <nav id="nav-menu">
      <a href="#about">About</a>
      <a href="#events">Events</a>
      <a href="#footer-placeholder">Contact</a>
    </nav>
    <div class="menu-toggle" id="menu-toggle">
        <i class="fas fa-bars fa-lg"></i>
    </div>
  </header>

  <main>
    <article class="blog-post">
      <div class="blog-header">
        <h1 class="blog-title">Bridging Education and Industry</h1>
        <p class="author">Written By: Imnil Benmarc A. Jolo</p>
      </div>

      <img class="main-image" src="img/Sti.png"
        alt="Ms. Aboilo from STI College Lipa visits interns at Roman & Associates Immigration Services">

      <section id="introduction">
        <div class="event-card">
          <p>
            On February 28, 2025, Ms. Annie Rose Aboilo, internship adviser from <span class="highlight-text">STI
              College Lipa</span>,
            visited Roman & Associates Immigration Services to check on her students and ensure they
            were gaining practical, real-world experience. Her visit, along with that of Dr. Maria
            Delia Miraña Poot and Ms. Dorie G. Gatus from <span class="highlight-text">De La Salle
              Lipa</span> on March 27, highlighted
            the strong collaboration between academic institutions and RAIS in supporting student
            development through meaningful internships.
          </p>
        </div>
      </section>

      <section id="events">
        <h2>Academic Partner Visits</h2>
        <div class="event-card">
          <h3>MISS ABOILO OF STI LIPA GOES TO RAIS</h3>
          <img src="img/Sti.png" alt="STI College Lipa Campus">
          <p>On the 28th of February 2025, Ms. Annie Rose Aboilo, the internship adviser from STI College
            Lipa, paid a meaningful visit to the office of Roman & Associates Immigration Services. Her
            visit was an important opportunity for her to check in on her students currently interning at
            the company. Ms. Aboilo took the time to engage with the interns, asking them about their
            experiences and how they’ve been applying their academic knowledge in a real-world setting. This
            hands-on approach ensured that the students were gaining valuable insights and contributing
            meaningfully to the company’s operations.</p>
        </div>

        <div class="event-card">
          <h3>THE TWO LIPASALYANO ADVISERS PAY A VISIT</h3>
          <img src="img/lasalle.png" alt="De La Salle Lipa Campus facade">
          <p>On the 27th of March 2025, Roman & Associates Immigration Services also had the pleasure of
            welcoming two distinguished guests from De La Salle Lipa’s Financial Management program—Ms.
            Maria Delia Miraña Poot, PhD, and Ms. Dorie G. Gatus, MBA. Their visit marked an important step
            in strengthening the partnership between RAIS and De La Salle Lipa, further solidifying the
            collaboration between the institution and the company.</p>
        </div>

        <div class="event-card">
          <h3>Conclusion</h3>
          <img src="img/conclusion.png" alt="Students and advisers in a collaborative meeting">
          <p>As we reflect on these enriching visits, we look forward to future collaborations with De La
            Salle Lipa, STI College Lipa, and other esteemed educational institutions. These partnerships
            serve as a cornerstone for bridging the gap between academic learning and real-world
            professional experience. By fostering these connections, we not only contribute to the personal
            growth of students but also support the development of skilled professionals who will excel in
            their future careers.</p>
        </div>
      </section>
    </article>
  </main>
  <div id="footer-placeholder">
      <?php include '../footer.php'; ?>
  </div>

  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
