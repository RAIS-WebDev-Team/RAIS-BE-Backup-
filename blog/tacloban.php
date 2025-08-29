<?php
// Page title
$page_title = "RAIS Blog | Visit to Tacloban";
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
      margin-bottom: 1.5rem;
    }

    .highlight-text {
      color: var(--primary-color);
      font-weight: 600;
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
      <a href="../index.php"><img src="../img/logo.png" alt="RAIS Logo"></a>
    </div>
    <nav id="nav-menu">
      <a href="#about">About</a>
      <a href="#footer-placeholder">Contact</a>
    </nav>
    <div class="menu-toggle" id="menu-toggle">
        <i class="fas fa-bars fa-lg"></i>
    </div>
  </header>

  <main>
    <article class="blog-post">
      <div class="blog-header">
        <h1 class="blog-title">MAUPAY NGA ADLAW, LEYTE</h1>
        <p class="author">Written By: Imnil Benmarc A. Jolo</p>
      </div>

      <img class="main-image" src="img/leyte.png" alt="RCIS team at the English Language Academy in Tacloban City">

      <section id="about">
        <h2>A Visit to the English Language Academy</h2>
        <p>
          In Tacloban City, Leyte, the largest city in the Eastern Visayas region, the RCIS team visited the
          <span class="highlight-text">English Language Academy</span>. This visit was an opportunity to
          connect with aspiring students and offer them guidance on both language proficiency and the pathways
          available for studying or working abroad.
        </p>
        <p>
          The team provided valuable insights into how enhancing English skills through the IELTS exam can
          open doors to global opportunities, especially in Canada, where language proficiency plays a key
          role in immigration processes.
        </p>
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
