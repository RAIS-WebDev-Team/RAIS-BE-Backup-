<?php
// This PHP script generates the entire HTML page for the Work Permit information.
// It uses HEREDOC syntax for outputting large blocks of HTML.

// Output the head and main content of the HTML document.
echo <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Work Permit</title>
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
      background: url('../img/Fwork.jpg')no-repeat center center/cover;
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
        padding-right: 0;
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

      .text-content, #info li, #documents ul, #info p {
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
        <img src="../img/logo1.png" alt="Company Logo" />
      </a>
    </div>
    <div class="hero-content text-white text-center px-3">
      <h1>Work Permit</h1>
      <p>A work permit allows individuals to work legally in a specific country, often requiring employer
        sponsorship or meeting eligibility criteria. For caregivers, additional requirements may include
        qualifications and a positive Labour Market Impact Assessment (LMIA).</p>
      <a href="../form.html" class="btn hero-btn">Apply Now</a>
    </div>
  </header>

  <main>
    <section class="py-5 my-5" id="info">
      <div class="container-fluid fixed-container px-4 px-md-5">
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
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#faq" type="button" role="tab">FAQs</button>
          </li>
        </ul>

        <div class="tab-content tab-section-content fs-6">
          <div class="tab-pane fade show active" id="about" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-6 px-md-4">
                <p class="lh-lg ps-4 text-content" style="text-align: justify;">A work permit is
                  required for foreign
                  skilled workers wishing to work temporarily in Canada. To qualify, a person must
                  have a temporary offer of employment from a Canadian employer. Certain positions may
                  require knowledge of the National Occupation Classification (NOC) Code, which
                  classifies employment types by Canadian standards. Individuals applying for a
                  Permanent Resident (PR) card may also apply for an open work permit.</p>
              </div>
              <div class="col-lg-6 text-center">
                <img src="../img/work.png" alt="Work Image" class="img-fluid rounded tab-image" />
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="criteria" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-4 text-center">
                <img src="../img/criteria.jpg" alt="Criteria Image" class="img-fluid rounded tab-image" />
              </div>
              <div class="col-lg-8 px-md-4 text-content">
                <h4 class="fw-bold mb-3">Criteria:</h4>
                <p class="mb-4 fw-bold">There are two main types of work permits in Canada:</p>
                <ul class="lh-lg ps-0 px-5 custom-list">
                  <li class="pb-3 mb-3 border-bottom">
                    <strong>1. Open Work Permit (OWP):</strong>
                    <ul class="ps-4" style="list-style-type: circle;">
                      <li>This permit is not job-specific.</li>
                      <li>Applicants do not need to specify an employer when applying.</li>
                      <li>Includes permits for spouses, post-graduation work, youth programs, and
                        more.</li>
                    </ul>
                  </li>
                  <li class="pb-3 mb-3 border-bottom">
                    <strong>2. Employer-Specific Work Permit:</strong>
                    <ul class="ps-4" style="list-style-type: circle;">
                      <li>The work permit specifies the employer, job duration, and work location
                        (if applicable).</li>
                      <li>Conditions must be followed as per the permit details.</li>
                    </ul>
                  </li>
                </ul>
                <p class="pe-5">The specific criteria you need to meet depends on which type of work
                  permit you are applying for, your qualifications, job offer, and other individual
                  circumstances.</p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="process" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-8 px-md-4 ps-4 text-content">
                <h4 class="fw-bold mb-3" style="padding-left: 2rem;">Process:</h4>
                <ol class="lh-base" style="font-size: 18px; padding-left: 3rem;">
                  <li class="mb-3">
                    <strong>Employer Applies for Labour Market Opinion (if necessary):</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>The employer may need to apply for a Labour Market Impact Assessment
                        (LMIA) to prove there is a need for a foreign worker.</li>
                    </ul>
                  </li>
                  <hr class="my-4" />
                  <li class="mb-3">
                    <strong>Employer Extends a Temporary Job Offer:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Once the employer receives the LMIA (if needed), they can extend a
                        temporary job offer to the foreign worker.</li>
                    </ul>
                  </li>
                  <hr class="my-4" />
                  <li class="mb-3">
                    <strong>Foreign Skilled Worker Applies for Work Permit:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>After receiving the job offer, the foreign worker applies for a work
                        permit.</li>
                    </ul>
                  </li>
                  <hr class="my-4" />
                  <li>
                    <strong>Work Permit Is Issued:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>If all the criteria are met, the work permit is issued to the foreign
                        worker, and they can begin their employment in Canada.</li>
                    </ul>
                  </li>
                </ol>
              </div>
              <div class="col-lg-4 text-center">
                <img src="../img/proc.png" alt="Process Image" class="img-fluid rounded tab-image" />
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="documents" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-4 text-center">
                <img src="../img/documents.png" alt="A collection of important documents"
                  class="img-fluid rounded tab-image" />
              </div>
              <div class="col-lg-8 p-4 text-content">
                <h4 class="fw-bold mb-3">Required Documents:</h4>
                <ul class="list-group list-group-flush lh-lg">
                  <li class="list-group-item">
                    <strong>For Employer-Specific Work Permits:</strong>
                    <ul class="mt-2 ps-4" style="list-style-type: circle;">
                      <li>Valid job offer from a Canadian employer.</li>
                      <li>LMIA (if applicable).</li>
                      <li>Proof of qualifications (educational certificates, work experience).
                      </li>
                      <li>Passport and travel documents.</li>
                    </ul>
                  </li>
                  <li class="list-group-item">
                    <strong>For Open Work Permits:</strong>
                    <ul class="mt-2 ps-4" style="list-style-type: circle;">
                      <li>Proof of relationship (for spouse permits).</li>
                      <li>Post-graduation certificate (for Post-Graduation Work Permit).</li>
                      <li>Temporary Resident Visa or status documents (if applicable).</li>
                      <li>Passport and other identity documents.</li>
                    </ul>
                  </li>
                  <li class="list-group-item">
                    <strong>Note:</strong>
                    <div class="mt-2 ps-3">
                      Always check the specific requirements for the work permit category you are
                      applying for, as requirements may vary.
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="faq" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-8 ps-4 text-content">
                <h4 class="fw-bold mb-3">Frequently Asked:</h4>
                <div class="ps-4">
                  <div class="faq-item">
                    <p><strong>Q1:</strong> Can I apply for a work permit without a job offer?</p>
                    <p><strong>A:</strong> No, in most cases, you need a job offer from a Canadian
                      employer to apply for a work permit unless you are applying under an open
                      work permit category.</p>
                  </div>
                  <hr class="my-3">

                  <div class="faq-item">
                    <p><strong>Q2:</strong> What is the difference between an open work permit and
                      an employer-specific work permit?</p>
                    <p><strong>A:</strong> An open work permit is not tied to a specific employer or
                      job and allows flexibility in employment. An employer-specific work permit
                      is tied to a particular employer, job, and location.</p>
                  </div>
                  <hr class="my-3">

                  <div class="faq-item">
                    <p><strong>Q3:</strong> How long can I stay in Canada on a work permit?</p>
                    <p><strong>A:</strong> The duration of your work permit depends on the terms of
                      your job offer and the specific type of work permit you have received.</p>
                  </div>
                  <hr class="my-3">

                  <div class="faq-item">
                    <p><strong>Q4:</strong> Can my family come with me to Canada?</p>
                    <p><strong>A:</strong> Yes, if you hold an open work permit, your spouse or
                      common-law partner may be eligible for an open work permit, and dependent
                      children may be allowed to study in Canada.</p>
                  </div>
                  <hr class="my-3">

                  <div class="faq-item">
                    <p><strong>Q5:</strong> How can I ensure my work permit application is
                      successful?</p>
                    <p><strong>A:</strong> Ensure that all required documents are submitted and meet
                      the criteria for the work permit. Consulting with an immigration consultant
                      may increase the chances of a successful application.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 text-center">
                <img src="../img/faq.jpg" alt="FAQS Image" class="img-fluid rounded tab-image" />
              </div>
            </div>
          </div>
        </div>
        <div class="tab-navigation-buttons d-lg-none d-flex justify-content-center gap-3 mt-3">
          <button id="prevBtn" class="btn rounded-circle shadow-sm nav-btn">
            <i class="bi bi-chevron-left fs-4"></i>
          </button>
          <button id="nextBtn" class="btn rounded-circle shadow-sm nav-btn">
            <i class="bi bi-chevron-right fs-4"></i>
          </button>
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
