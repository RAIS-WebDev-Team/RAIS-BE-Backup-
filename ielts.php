<?php
// Start of PHP file
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IELTS - International English Language Testing System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="img/logoulit.png">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
      /* Prevent horizontal scroll */
    }

    /* Header Styling */
    .header-bg-img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    .header-logo {
      max-height: 100px;
    }

    .header-text-shadow {
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
    }

    /* Back Button Styling */
    .btn-back {
      position: absolute;
      top: 1rem;
      left: 1rem;
      z-index: 1001;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 45px;
      height: 45px;
      background-color: #0C470C;
      color: white;
      border-radius: 50%;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .btn-back:hover {
      background-color: #023621;
      transform: scale(1.1);
    }

    .btn-back i {
      font-size: 1.2rem;
    }

    /* Responsive Card Images */
    .card-img-top {
      object-fit: cover;
      height: 200px;
      /* Default height for mobile */
    }

    /* Custom Accordion Styling */
    .accordion-button:focus {
      box-shadow: none;
      border-color: rgba(0, 0, 0, .10);
    }

    .accordion-button:not(.collapsed) {
      background-color: #e7f1ff;
      color: #0c4128;
    }

    /* Custom Scrollbar */
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

    /* --- Responsive Media Queries --- */
    @media (max-width: 768px) {
      .btn-back {
        top: 0.5rem;
        left: 0.5rem;
        width: 40px;
        height: 40px;
      }

      .header-logo {
        max-height: 60px;
        /* Smaller logo on mobile */
      }
    }

    @media (min-width: 768px) {
      .card-img-top {
        height: 250px;
        /* Taller images on desktop */
      }
    }
  </style>
</head>

<body class="text-black">
  <a href="index.html" class="btn-back" aria-label="Go Back">
    <i class="bi-arrow-left-short"></i>
  </a>

  <header class="position-relative">
    <img src="img/ielts.png" class="header-bg-img" alt="IELTS examination materials">

    <div class="position-absolute top-0 end-0 p-3 p-md-4">
      <img src="img/logo_ielts.png" class="img-fluid header-logo" alt="IELTS Logo">
    </div>

    <div class="container d-flex flex-column justify-content-end" style="min-height: 80vh;">
      <div class="text-start mb-5 pb-4">
        <h1 class="display-4 fw-bold text-white header-text-shadow">International English Language Testing System
          (IELTS)</h1>
        <p class="lead mt-3 text-white header-text-shadow">
          IELTS is the top English proficiency test for study, work, and migration, assessing four key
          language skills and recognized globally.
        </p>
        <a href="https://ieltsregistration.britishcouncil.org/register-for-agent/MDhhNTQ3YjQtYmI2MC00NDRiLWI2MDQtZTQ0MjAzZDE3ZTJlOzE2MDcyOzE2NzMxNzEyMDk="
          class="btn px-4 py-2 text-white" style="background-color: #0C470C;">Book Now</a>
      </div>
    </div>
  </header>

  <main>
    <section id="about" class="py-5">
      <div class="container text-center">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <h2 class="display-5 fw-bold">About Us</h2>
            <p class="mt-4 fs-5">
              IELTS is developed jointly by the British Council, IDP, and Cambridge Assessment English to measure
              proficiency in English through real-life tasks. With two test types available—Academic for university and
              professional registration, and General Training for migration and work—IELTS is designed to suit diverse
              needs.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section id="test-format" class="py-5 bg-light">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="display-5 fw-bold">Test Format</h2>
        </div>
        <div class="row g-4 justify-content-center">
          <div class="col-lg-3 col-md-6">
            <div class="bg-white rounded-4 text-center h-100 p-4 shadow-sm">
              <i class="bi bi-headphones display-3" style="color: #0C470C;"></i>
              <h3 class="fs-4 fw-bold mt-3">Listening</h3>
              <p class="mt-2">30 minutes (plus 10 mins transfer time on paper)</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="bg-white rounded-4 text-center h-100 p-4 shadow-sm">
              <i class="bi bi-pencil-square display-3" style="color: #0C470C;"></i>
              <h3 class="fs-4 fw-bold mt-3">Writing</h3>
              <p class="mt-2">60 minutes (20 mins Task 1, 40 mins Task 2)</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="bg-white rounded-4 text-center h-100 p-4 shadow-sm">
              <i class="bi bi-book-half display-3" style="color: #0C470C;"></i>
              <h3 class="fs-4 fw-bold mt-3">Reading</h3>
              <p class="mt-2">60 minutes (3 passages with 40 questions)</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="bg-white rounded-4 text-center h-100 p-4 shadow-sm">
              <i class="bi bi-mic display-3" style="color: #0C470C;"></i>
              <h3 class="fs-4 fw-bold mt-3">Speaking</h3>
              <p class="mt-2">11-14 minutes (face-to-face interview)</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5">
      <div class="container">
        <h2 class="text-center mb-5 display-5 fw-bold">Why should you choose IELTS?</h2>
        <div class="row g-4">
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
              <img src="img/ielts_p1.jpg" class="card-img-top" alt="Person holding a passport and plane ticket">
              <div class="card-body d-flex flex-column p-4">
                <h4 class="card-title fw-bold">Access New Opportunities</h4>
                <p class="card-text">IELTS is trusted by 12,500 organisations in over 140 countries, meaning you can
                  study abroad at the institutions of your choice.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
              <img src="img/ielts_p2.jpg" class="card-img-top" alt="Professional discussing work at a desk">
              <div class="card-body d-flex flex-column p-4">
                <h4 class="card-title fw-bold">Advance Your Career</h4>
                <p class="card-text">Prove your English proficiency to future employers with secure and
                  easy-to-understand results that highlight your skills.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
              <img src="img/ielts_p3.jpg" class="card-img-top" alt="Diverse group of people in a meeting">
              <div class="card-body d-flex flex-column p-4">
                <h4 class="card-title fw-bold">Work Internationally</h4>
                <p class="card-text">The test includes a range of accents and examines English used by people from
                  different parts of the world.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
              <img src="img/ielts_p4.jpg" class="card-img-top" alt="Globe with international landmarks">
              <div class="card-body d-flex flex-column p-4">
                <h4 class="card-title fw-bold">Migrate with Confidence</h4>
                <p class="card-text">IELTS helps you demonstrate to immigration authorities that your level of English
                  meets the required standards.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
              <img src="img/ielts_p5.jpg" class="card-img-top" alt="Person taking a test on a laptop">
              <div class="card-body d-flex flex-column p-4">
                <h4 class="card-title fw-bold">Choose a Test That Suits You</h4>
                <p class="card-text">Take the test on paper, on a computer, or online from home. With many testing dates
                  available, IELTS fits your schedule.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
              <img src="img/ielts_p6.jpg" class="card-img-top" alt="Examiner and test-taker in an interview">
              <div class="card-body d-flex flex-column p-4">
                <h4 class="card-title fw-bold">Be Confident in Your Results</h4>
                <p class="card-text">IELTS is a fair and accurate test. Examiners are qualified language specialists who
                  focus on practical communication skills.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 bg-light">
      <div class="container my-md-4">
        <div class="text-center mb-5">
          <h2 class="fw-bold display-5">How does IELTS work?</h2>
          <p class="mx-auto fs-5 my-4 col-lg-9">
            IELTS is aimed at people who want to study, work, or emigrate to English-speaking countries. There are two
            test types:
          </p>
        </div>
        <div class="row g-4 justify-content-center mb-5 pb-4">
          <div class="col-lg-5 col-md-8">
            <div class="bg-white p-4 p-md-5 rounded-4 text-center h-100">
              <h3 class="fw-bold fs-4 mb-3">IELTS Academic</h3>
              <p class="mb-0">This test helps with university acceptance, student visas, and proves your English ability
                to professional organisations.</p>
            </div>
          </div>
          <div class="col-lg-5 col-md-8">
            <div class="bg-white p-4 p-md-5 rounded-4 text-center h-100">
              <h3 class="fw-bold fs-4 mb-3">IELTS General Training</h3>
              <p class="mb-0">This test assesses workplace English skills and helps demonstrate your level when applying
                to companies.</p>
            </div>
          </div>
        </div>
        <div class="text-center mb-5">
          <h2 class="fw-bold">Frequently Asked Questions</h2>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="accordion" id="faqAccordion">
              <div class="accordion-item mb-2 border-0 rounded-3">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed p-3 rounded-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    What is the difference between IELTS Academic and General Training?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    IELTS Academic is for higher education or professional registration, while IELTS General Training is
                    for work, training, or migration purposes.
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-2 border-0 rounded-3">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed p-3 rounded-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    How long is the IELTS exam?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    The exam takes approximately 2 hours and 45 minutes. Listening, Reading, and Writing are completed
                    in one sitting, with Speaking scheduled separately.
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-2 border-0 rounded-3">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed p-3 rounded-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    How is the IELTS scored?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Each section is scored on a 9-band scale. The Overall Band Score is the average of the four skills,
                    rounded to the nearest half band.
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-2 border-0 rounded-3">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed p-3 rounded-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    What documents do I need on test day?
                  </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    You must bring the original identification document (passport or national ID) you used during
                    registration, along with your registration confirmation.
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-2 border-0 rounded-3">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed p-3 rounded-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    How do I register for the IELTS exam?
                  </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    You can register online via the official IELTS website or your local test centre’s portal. Complete
                    the application, upload your ID, and pay the fee.
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-2 border-0 rounded-3">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed p-3 rounded-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    What if I need to reschedule or cancel my test?
                  </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Policies vary by centre. Typically, you must request changes several weeks in advance and may incur
                    a fee. Contact your test centre for details.
                  </div>
                </div>
              </div>
              <div class="accordion-item mb-2 border-0 rounded-3">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed p-3 rounded-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    Can I take IELTS online?
                  </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Yes, IELTS Online is available in some regions. It has the same format as the in-person test but can
                    be taken from a private location with a stable internet connection.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>

<script>   // SCRIPT TO FETCH AND LOAD FOOTER
    document.addEventListener("DOMContentLoaded", function () {
      const placeholder = document.getElementById("footer-placeholder");

      // Since this file is in a subfolder, the path is relative to the root
      fetch('footer.php')
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status} - Could not find footer-fragment.php`);
          }
          return response.text();
        })
        .then(data => {
          const parser = new DOMParser();
          const footerDoc = parser.parseFromString(data, 'text/html');

          footerDoc.querySelectorAll('style').forEach(style => document.head.appendChild(style));

          const bodyContent = footerDoc.body.firstElementChild;
          if (bodyContent) {
            placeholder.appendChild(bodyContent);
          }

          const scriptTag = footerDoc.querySelector('script');
          if (scriptTag) {
            const newScript = document.createElement('script');
            newScript.textContent = scriptTag.textContent;
            document.body.appendChild(newScript);
          }
        })
        .catch(error => {
          console.error("Footer loading failed:", error);
          if (placeholder) {
            placeholder.innerHTML = `<p style="text-align:center; color:red; padding: 20px;"><b>Error:</b> Footer could not be loaded. Please check the console for details.</p>`;
          }
        });
    });</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>