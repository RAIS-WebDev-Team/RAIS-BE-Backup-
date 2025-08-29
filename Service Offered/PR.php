<?php
// This PHP script generates the entire HTML page for the Permanent Residency information.
// It uses HEREDOC syntax for outputting large blocks of HTML.

// Output the head and main content of the HTML document.
echo <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PR</title>
  <link rel="icon" href="../img/logoulit.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    /* Custom Scrollbar Styles */
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

    header {
      position: relative;
      height: 100vh;
      background: url('../img/Fpr.jpg')no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
    }

    .overlay-box {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background-color: rgba(0, 0, 0, 0.4);
      z-index: 1;
    }

    .logo {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 2;
    }

    .logo img {
      width: 150px;
      transition: transform 0.3s ease;
    }
    
    .logo a:hover img {
        transform: scale(1.1);
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 750px;
      padding: 20px;
    }

    .hero-content h1 {
      font-size: 3.2rem;
      font-weight: 700;
      margin-bottom: 20px;
      text-shadow: 2px 2px 5px #000;
    }

    .hero-content p {
      font-size: 1.2rem;
      line-height: 1.7;
      margin-bottom: 30px;
    }

    .hero-btn {
      background-color: #0C470C;
      color: white;
      padding: 10px 28px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.3s ease-in-out;
    }

    .hero-btn:hover {
      background-color: #167e16;
      transform: scale(1.05) translateY(-2px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .nav-tabs {
        border-bottom: none;
    }

    .nav-tabs .nav-link {
      color: #444;
      font-weight: 600;
      border-radius: 0;
      border: 0;
      transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:not(.active):hover {
        color: #0C470C;
        transform: translateY(-3px);
    }

    .nav-tabs .nav-link.active {
      background-color: #0C470C;
      color: white;
    }

    .tab-content {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }

    .tab-pane .row {
      min-height: 655px;
    }

    .tab-image {
      max-height: 400px;
      width: 100%;
      object-fit: contain;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }


    .text-content {
      font-size: 1.125rem;
      line-height: 1.3;
    }


    .custom-list {
      list-style: none;
      padding-left: 1rem !important;
    }

    .fixed-container {
      min-height: 800px;
      max-width: 1500px;
      width: 100%;
      margin: 0 auto;
      padding: 0 15px;
    }

    .nav-btn {
      width: 50px;
      height: 50px;
      background-color: #d3d3d3;
      color: #555;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      transition: all 0.3s ease;
    }

    .nav-btn:hover {
      background-color: #0C470C;
      color: #fff;
      box-shadow: 0 4px 12px rgba(1, 62, 33, 0.5);
      transform: scale(1.1);
    }

    .nav-btn:active {
      transform: scale(0.95);
    }

    .nav-btn.active,
    .nav-btn:disabled {
      background-color: #167e16;
      color: #fff;
      cursor: not-allowed;
      transform: none;
    }

    @media (min-width: 769px) {
      .tab-navigation-buttons {
        display: none;
      }
    }

    @media (max-width: 1024px) {
      .hero-content h1 {
        font-size: 30px;
      }

      .hero-content p {
        font-size: 16px;
      }

      .tab-pane .row {
        min-height: auto;
      }

      .tab-image {
        max-height: 300px;
        margin-top: 20px;
      }
    }

    @media (max-width: 768px) {
      .tab-pane .row {
        flex-direction: column-reverse;
      }

      .tab-pane#criteria .row,
      .tab-pane#documents .row,
      .tab-pane#faq .row {
        flex-direction: column;
      }

      .text-content, #info li, #documents ul, #faq p {
        font-size: 14px;
      }

      .ps-4,
      .px-5 {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
      }

      .hero-btn {
        font-size: 12px;
        padding: 10px 15px;
      }

      #info h4, #info h5 {
        font-size: 18px;
      }
    }
  </style>
</head>

<body>
  <header>
    <div class="overlay-box"></div>
    <div class="logo">
      <a href="../index.php">
        <img src="../img/logo1.png" alt="logo" />
      </a>
    </div>
    <div class="hero-content text-white text-center">
      <h1>Permanent Residency</h1>
      <p>Permanent Residency allows foreign nationals to live, work, and study in Canada indefinitely,
        with access to most social benefits enjoyed by citizens. It is a step toward becoming a Canadian citizen
        and provides stability for you and your family.</p>
      <a href="../form.html" class="btn hero-btn">Apply Now</a>
    </div>
  </header>

  <main>
    <section class="py-3 mt-5" id="info">
      <div class="container fixed-container px-4 p-5 px-md-5">
        <div class="tab-container">
          <ul class="nav nav-tabs mb-5 justify-content-center border-0" id="tabMenu" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#about" type="button"
                role="tab">About</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#criteria" type="button"
                role="tab">Criteria</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#process" type="button"
                role="tab">Process</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documents" type="button"
                role="tab">Documents</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#faq" type="button"
                role="tab">FAQs</button>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-pane fade show active" id="about" role="tabpanel">
              <div class="row align-items-center g-4">
                <div class="col-md-6">
                  <p class="lh-lg px-md-4" style="text-align: justify; line-height: 1.5;">
                    Permanent Residency (PR) in Canada grants foreign nationals the right to live,
                    work,
                    and
                    study anywhere in the
                    country without time limits. PR holders enjoy many of the same benefits as
                    Canadian
                    citizens, such as access to
                    publicly funded healthcare, social services, and legal protections under
                    Canadian
                    law.
                    They can freely move between
                    provinces, work for almost any employer, and pursue educational opportunities at
                    domestic tuition rates. PR status
                    also allows individuals to sponsor eligible family members, making it a key step
                    in
                    reuniting loved ones in Canada.
                  </p>
                  <p class="lh-lg text-justify px-md-4">
                    Obtaining PR is also a pathway to citizenship. After meeting residency
                    requirements
                    —
                    typically living in Canada for
                    at least 1,095 days within a five-year period — PR holders can apply for
                    Canadian
                    citizenship and enjoy full voting
                    rights and passports. However, PR comes with responsibilities, such as
                    maintaining
                    residency obligations, paying
                    taxes, and abiding by Canadian laws. For many, securing PR status represents not
                    just
                    legal stability but also the
                    opportunity to thrive in one of the world’s most diverse, prosperous, and
                    welcoming
                    countries.
                  </p>
                </div>
                <div class="col-md-6 text-center">
                  <img src="../img/pr.png" alt="About Permanent Residency" class="img-fluid rounded tab-image" />
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="criteria" role="tabpanel">
              <div class="row align-items-center g-4">
                <div class="col-md-3 text-center">
                  <img src="../img/criteria.jpg" alt="Criteria" class="img-fluid rounded tab-image" />
                </div>
                <div class="col-md-9 px-5">
                  <h4 class="fw-bold mb-3" style="line-height: 1.8;">Criteria:</h4>
                  <ul
                    style="list-style-type: circle; padding-left: 1.5rem; line-height: 1.8; font-size: 18px;">
                    <li>Meet eligibility requirements of one of the immigration programs (e.g.,
                      Express
                      Entry, Provincial Nominee Program, Family Sponsorship, or Refugee programs).
                    </li>
                    <li>Minimum language proficiency in English or French (CLB requirements vary by
                      program).</li>
                    <li>Proof of sufficient settlement funds (unless exempt).</li>
                    <li>Relevant work experience or education credentials (Canadian equivalency may
                      be
                      required and assessed through an Educational Credential Assessment).</li>
                    <li>Must not be inadmissible to Canada for reasons of security, criminal
                      record, or
                      health.</li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="process" role="tabpanel">
              <div class="row align-items-center g-4">
                <div class="col-md-9 px-5">
                  <h4 class="fw-bold mb-3" style="line-height: 1.8;">Process:</h4>
                  <ul
                    style="list-style-type: decimal; padding-left: 1.5rem; line-height: 1.8; font-size: 18px;">
                    <li>
                      <strong>Choose the right program:</strong> Identify the immigration pathway
                      that best fits your profile (e.g., Express Entry, PNP).
                    </li>
                    <li>
                      <strong>Gather documents:</strong> Collect all required documents, including
                      proof of language proficiency, educational assessments, and work experience
                      letters.
                    </li>
                    <li>
                      <strong>Submit application:</strong> Create a profile and submit your
                      application to Immigration, Refugees and Citizenship Canada (IRCC) through
                      the
                      appropriate online portal.
                    </li>
                    <li>
                      <strong>Receive invitation:</strong> If your profile meets the criteria, you
                      may receive an Invitation to Apply (ITA) for permanent residence.
                    </li>
                    <li>
                      <strong>Medical and security checks:</strong> Complete required medical
                      exams
                      and provide police certificates from every country you've lived in for more
                      than six months since age 18.
                    </li>
                    <li>
                      <strong>Confirmation of Permanent Residence:</strong> Once your application
                      is approved, you will receive a Confirmation of Permanent Residence (COPR)
                      and
                      a permanent resident visa.
                    </li>
                    <li>
                      <strong>Arrival in Canada:</strong> Upon arrival, your PR status is
                      officially
                      granted, and your PR card will be mailed to you.
                    </li>
                  </ul>
                </div>
                <div class="col-md-3 text-center">
                  <img src="../img/proc.png" alt="Permanent Residency Process"
                    class="img-fluid rounded tab-image" />
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="documents" role="tabpanel">
              <div class="row align-items-center g-4">
                <div class="col-md-4 text-center">
                  <img src="../img/documents.png" alt="Documents" class="img-fluid rounded tab-image" />
                </div>
                <div class="col-md-8 p-4">
                  <h4 class="fw-bold mb-3">Required Documents:</h4>
                  <ul
                    style="list-style-type: circle; padding-left: 1.5rem; line-height: 1.8; font-size: 18px;">
                    <li>Valid passport or travel document.</li>
                    <li>Language test results (e.g., IELTS, CELPIP, TEF Canada).</li>
                    <li>Educational Credential Assessment (ECA) report for foreign education.</li>
                    <li>Proof of work experience (letters from employers, pay stubs).</li>
                    <li>Proof of funds (bank statements or other financial documents).</li>
                    <li>Police certificates from all countries where you have lived for more than
                      six
                      months since age 18.</li>
                    <li>Medical examination results.</li>
                    <li>Birth certificates and marriage certificates, if applicable.</li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="faq" role="tabpanel">
              <div class="row align-items-center g-4">
                <div class="col-md-9 p-4">
                  <h4 class="fw-bold mb-3">Frequently Asked:</h4>
                  <div class="faq-container">
                    <div class="faq-item">
                      <p><strong>Q1:</strong> What is the difference between a permanent resident
                        and a
                        citizen?</p>
                      <p><strong>A:</strong> A permanent resident is a foreign national who has
                        been
                        granted the right to live in Canada. They can live, work, and study
                        anywhere in
                        Canada. A citizen has the added benefits of holding a Canadian passport,
                        the
                        right to vote, and not being subject to removal from Canada.</p>
                    </div>
                    <hr class="my-3">
                    <div class="faq-item">
                      <p><strong>Q2:</strong> How do I maintain my permanent resident status?</p>
                      <p><strong>A:</strong> To maintain your PR status, you must be physically
                        present
                        in Canada for at least 730 days within a five-year period. These 730
                        days
                        do
                        not have to be continuous.</p>
                    </div>
                    <hr class="my-3">
                    <div class="faq-item">
                      <p><strong>Q3:</strong> Can a permanent resident lose their status?</p>
                      <p><strong>A:</strong> Yes, a permanent resident can lose their status if
                        they
                        fail to meet the residency obligation, are found to be inadmissible for
                        security or criminal reasons, or become a Canadian citizen.</p>
                    </div>
                    <hr class="my-3">
                    <div class="faq-item">
                      <p><strong>Q4:</strong> Can I travel outside Canada as a permanent
                        resident?</p>
                      <p><strong>A:</strong> Yes, you can travel outside of Canada, but you need a
                        valid Permanent Resident Card to re-enter the country. It is important
                        to
                        meet the residency obligations to maintain your status.</p>
                    </div>
                    <hr class="my-3">
                    <div class="faq-item">
                      <p><strong>Q5:</strong> What is the Express Entry system?</p>
                      <p><strong>A:</strong> Express Entry is an online system used to manage
                        applications for permanent residence under three economic immigration
                        programs: the Federal Skilled Worker Program, the Federal Skilled Trades
                        Program, and the Canadian Experience Class.</p>
                    </div>
                    <hr class="my-3">
                    <div class="faq-item">
                      <p><strong>Q6:</strong> How much does it cost to apply for Permanent
                        Residency?</p>
                      <p><strong>A:</strong> The cost varies by program, but it typically includes
                        processing fees for the principal applicant, spouse or partner, and any
                        dependent children, as well as the right of permanent residence fee.
                        Additional costs may include language tests, educational assessments,
                        and
                        medical exams.</p>
                    </div>
                    <hr class="my-3">
                  </div>
                </div>
                <div class="col-md-3 text-center">
                  <img src="../img/faq.jpg" alt="FAQs" class="img-fluid rounded tab-image" />
                </div>
              </div>
            </div>
          </div>
          <div class="tab-navigation-buttons d-lg-none d-flex justify-content-center gap-3 pt-3">
            <button id="prevBtn" class="btn rounded-circle shadow-sm nav-btn">
              <i class="bi bi-chevron-left fs-4"></i>
            </button>
            <button id="nextBtn" class="btn rounded-circle shadow-sm nav-btn">
              <i class="bi bi-chevron-right fs-4"></i>
            </button>
          </div>
        </div>
      </div>
    </section>
  </main>
HTML;

// Include the footer file using a server-side PHP include.
include '../footer.php';

// Output the closing script tags and HTML structure.
echo <<<HTML
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const tabs = document.querySelectorAll('#tabMenu .nav-link');
      const tabList = Array.from(tabs);
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const navButtons = document.querySelectorAll('.nav-btn');

      function updateButtons() {
        const activeTab = document.querySelector('#tabMenu .nav-link.active');
        const activeIndex = tabList.indexOf(activeTab);

        prevBtn.disabled = activeIndex === 0;
        nextBtn.disabled = activeIndex === tabList.length - 1;

        navButtons.forEach((btn, index) => {
          btn.classList.remove('active');
          if (index === activeIndex) {
            btn.classList.add('active');
          }
        });
      }

      prevBtn.addEventListener('click', () => {
        const activeTab = document.querySelector('#tabMenu .nav-link.active');
        const activeIndex = tabList.indexOf(activeTab);
        if (activeIndex > 0) {
          tabList[activeIndex - 1].click();
        }
      });

      nextBtn.addEventListener('click', () => {
        const activeTab = document.querySelector('#tabMenu .nav-link.active');
        const activeIndex = tabList.indexOf(activeTab);
        if (activeIndex < tabList.length - 1) {
          tabList[activeIndex + 1].click();
        }
      });

      tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', updateButtons);
      });

      updateButtons();
    });
  </script>
</body>

</html>
HTML;

?>
