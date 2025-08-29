<?php
// Page title
$page_title = "RAIS Blogs & Events";

// Centralized data for blogs and map events
$events = [
    [
        "id" => "event1",
        "title" => "RCIS AT THE IELTS MINI FAIR",
        "author" => "Imnil Benmarc A. Jolo",
        "image" => "blog/img/minifair2.png",
        "alt" => "IELTS Mini Fair",
        "url" => "blog/mini-fair.php",
        "mapInfo" => [
            "title" => "IELTS Prep at 9.0 Niner Calamba",
            "summary" => "Reviewing English with proven techniques.",
            "coordinates" => [14.2133, 121.1658]
        ]
    ],
    [
        "id" => "event2",
        "title" => "THE VISITATION: BRIDGING ACADEMIA AND INDUSTRY",
        "author" => "Imnil Benmarc A. Jolo",
        "image" => "blog/img/lasalle.png",
        "alt" => "Visitation from academic partners",
        "url" => "blog/visitation.php",
        "mapInfo" => [
            "title" => "Student Life at La Salle Lipa",
            "summary" => "Experience education and values at La Salle.",
            "coordinates" => [13.9412, 121.1621]
        ]
    ],
    [
        "id" => "event3",
        "title" => "A LONG ROAD FOR “A CALLING TO CANADA”",
        "author" => "Imnil Benmarc A. Jolo",
        "image" => "blog/img/canada.png",
        "alt" => "A Calling to Canada event",
        "url" => "blog/canada.php",
        "mapInfo" => null // No specific map point for this one
    ],
    [
        "id" => "event4",
        "title" => "CONNECTING WITH STUDENTS: LAGUNA ALL THE WAY",
        "author" => "Imnil Benmarc A. Jolo",
        "image" => "blog/img/calamba.png",
        "alt" => "Laguna event",
        "url" => "blog/calamba.php",
        "mapInfo" => null // You can add map info if needed
    ],
    [
        "id" => "event5",
        "title" => "STI LIPA & RAIS: BRIDGING EDUCATION AND INDUSTRY",
        "author" => "Published on: February 28, 2025",
        "image" => "blog/img/Sti.png",
        "alt" => "STI Lipa event",
        "url" => "blog/sti-lipa.php",
        "mapInfo" => [
            "title" => "Tech & Training at STI Lipa",
            "summary" => "A look into STI Lipa’s modern curriculum.",
            "coordinates" => [13.9416, 121.1628]
        ]
    ],
    [
        "id" => "event6",
        "title" => "MAUPAY NGA ADLAW LEYTE",
        "author" => "Imnil Benmarc A. Jolo",
        "image" => "blog/img/tacloban.png",
        "alt" => "Leyte event",
        "url" => "blog/tacloban.php",
        "mapInfo" => [
            "title" => "Learning English in Tacloban",
            "summary" => "ELA helps students master the language.",
            "coordinates" => [11.2410, 125.0016]
        ]
    ],
    [
        "id" => "event7",
        "title" => "DLSL LIPA & RAIS: FOSTERING FUTURE LEADERS",
        "author" => "Published on: March 27, 2025",
        "image" => "blog/img/dlsl.jpg",
        "alt" => "DLSL Lipa event",
        "url" => "blog/la-salle.php",
        "mapInfo" => null // Already covered by event2's map point
    ]
];

$map_locations = [];
foreach ($events as $event) {
    if ($event['mapInfo']) {
        $map_locations[] = [
            "title" => $event['mapInfo']['title'],
            "summary" => $event['mapInfo']['summary'],
            "coordinates" => $event['mapInfo']['coordinates'],
            "url" => $event['url'],
            "cardId" => $event['id']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $page_title; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="img/logoulit.png" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #0C470C;
      --background-color: #FFFFFF;
      --surface-color: #FFFFFF;
      --text-color: #333333;
      --heading-color: #023621;
      --light-gray: #E0E0E0;
      --font-family: 'Poppins', sans-serif;
    }

    html {
      scroll-behavior: smooth;
      min-height: 100%;
    }

    body {
      margin: 0;
      font-family: var(--font-family);
      background-color: var(--background-color);
      color: var(--text-color);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    
    main {
        flex-grow: 1;
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

    .logo-image {
      max-height: 65px; /* Increased from 55px */
      width: auto;
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
      flex-direction: column;
      cursor: pointer;
    }

    .menu-toggle .bar {
      width: 25px;
      height: 3px;
      background-color: var(--primary-color);
      margin: 4px 0;
      transition: 0.4s;
    }

    .section-container {
      padding: 4rem 2rem;
    }

    .section-title {
      text-align: center;
      margin-bottom: 2.5rem;
      font-weight: 600;
      color: var(--heading-color);
      font-size: 2rem;
    }

    #map {
      height: 650px;
      max-width: 1200px;
      margin: 0 auto;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      border: 3px solid var(--primary-color);
    }

    .blog-section .col-lg-6 {
      display: flex;
      align-items: stretch;
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

    .blog-card {
      width: 100%;
      display: flex;
      text-decoration: none;
      color: var(--text-color);
      transition: opacity 0.3s ease;
    }

    .blog-card:hover,
    .blog-card.hovered {
        opacity: 0.8;
    }
    
    .blog-card:hover h5 {
        color: var(--primary-color);
    }

    .blog-card .img-wrapper {
      flex: 0 0 40%;
    }

    .blog-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .blog-card .card-content {
      padding: 1rem 1.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .card-content .title-area {
      flex-grow: 1;
    }

    .card-content h5 {
        font-weight: 600;
        line-height: 1.4;
        font-size: 1.15rem;
        margin-bottom: 1rem;
        transition: color 0.3s ease;
        min-height: 3.25rem; 
        display: flex;
        align-items: center;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 12px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #3BA43B, #0C470C); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #45b945, #0a3a0a); }
    
    @media (max-width: 991px) {
      header { flex-wrap: wrap; position: relative; }
      header nav { display: none; flex-direction: column; width: 100%; text-align: center; background-color: var(--surface-color); padding: 1rem 0; position: absolute; top: 100%; left: 0; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); z-index: 999; }
      header nav.active { display: flex; }
      header nav a { padding: 0.5rem 0; margin: 0; border-bottom: 1px solid var(--light-gray); }
      header nav a:last-child { border-bottom: none; }
      .menu-toggle { display: flex; }
    }

    @media (max-width: 768px) {
      .blog-card { flex-direction: column; align-items: stretch; }
      .blog-card .card-content { padding: 1.5rem 0.5rem; text-align: center; }
      .card-content h5 { min-height: 0; justify-content: center; }
      .blog-card img { height: 220px; }
      .btn-back { top: 15px; left: 15px; width: 40px; height: 40px; }
      .btn-back i { font-size: 1rem; }
    }
  </style>
</head>

<body>
  <header>
    <div>
      <img src="img/logo.png" alt="RAIS Events Logo" class="logo-image">
    </div>
    <div class="menu-toggle" id="mobile-menu">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>
    <nav id="nav-links">
      <a href="#map">Event</a>
      <a href="#blogs">Blogs</a>
      <a href="#footer-placeholder">Contact</a>
    </nav>
  </header>

  <main>
    <a href="index.php" class="btn-back" aria-label="Go Back">
      <i class="fas fa-arrow-left"></i>
    </a>
    <section class="section-container">
      <h2 class="section-title">Event Locations</h2>
      <div id="map"></div>
    </section>

    <section class="section-container blog-section" id="blogs">
      <h2 class="section-title">Recent Events</h2>
      <div class="container">
        <div class="row g-4">

          <?php 
            // By using array_slice, we only show the first 3 events in this section
            $blogs_to_display = array_slice($events, 0, 3);
            foreach ($blogs_to_display as $event): 
          ?>
          <div class="col-lg-6">
            <a href="<?php echo htmlspecialchars($event['url']); ?>" class="blog-card" id="<?php echo htmlspecialchars($event['id']); ?>">
              <div class="img-wrapper">
                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['alt']); ?>">
              </div>
              <div class="card-content">
                <div class="title-area">
                  <h5><?php echo htmlspecialchars($event['title']); ?></h5>
                </div>
                <p class="text-muted mb-0">Written By: <?php echo htmlspecialchars($event['author']); ?></p>
              </div>
            </a>
          </div>
          <?php endforeach; ?>

        </div>
      </div>
    </section>
  </main>

<div id="footer-placeholder">
    <?php include 'footer.php'; ?>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    // Mobile menu toggle
    const mobileMenu = document.getElementById('mobile-menu');
    const navLinks = document.getElementById('nav-links');
    mobileMenu.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });

    const locations = <?php echo json_encode($map_locations); ?>;

    const map = L.map("map", {
      maxBounds: [[4.0, 116.0], [21.5, 127.5]],
      maxBoundsViscosity: 1.0
    }).setView([12.8797, 121.7740], 6);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "© OpenStreetMap contributors", minZoom: 6, maxZoom: 18
    }).addTo(map);

    locations.forEach(location => {
      const marker = L.marker(location.coordinates).addTo(map);
      marker.bindPopup(`<h5>${location.title}</h5><p>${location.summary}</p><a href="${location.url}" target="_blank">Read Blog →</a>`);
      marker.on('click', () => {
        map.setView(location.coordinates, 13);
        document.querySelectorAll('.blog-card').forEach(card => card.classList.remove('hovered'));
        if (location.cardId) {
          const card = document.getElementById(location.cardId);
          if (card) {
            card.classList.add('hovered');
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        }
      });
    });
  </script>
</body>

</html>
