<?php
// This PHP script generates the entire HTML page for the Caregiver Permit information.
// It uses HEREDOC syntax for outputting large blocks of HTML.

// Output the head and main content of the HTML document.
echo <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Caregiver Permit</title>
  <link rel="icon" href="../img/logoulit.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html {
      min-height: 100%;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      flex-grow: 1;
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
      background: url('../img/Fcaregiver.jpg') no-repeat center center/cover;
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
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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

      .text-content,
      #process li,
      #documents ul,
      #faq p {
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

      .tab-content h4 {
        font-size: 18px;
      }
    }

    /* Center container */
    .button-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 10vh;
      padding: 1rem;
      box-sizing: border-box;
      padding-top: 50px;
    }

    /* Button styling */
    .backbutton {
      font-size: 14px;
      padding: 0.7em 1.5em;
      font-weight: 500;
      background: #0C470C;
      color: white;
      border: none;
      position: relative;
      overflow: hidden;
      border-radius: 0.6em;
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    /* Gradient overlay */
    .gradient {
      position: absolute;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      border-radius: 0.6em;
      margin-top: -0.25em;
      background-image: linear-gradient(rgba(0, 0, 0, 0),
          rgba(0, 0, 0, 0),
          rgba(0, 0, 0, 0.3));
    }

    /* Label */
    .label {
      position: relative;
      top: -1px;
      z-index: 1;
    }

    .transition {
      transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
      transition-duration: 500ms;
      background-color: rgba(51, 153, 51, 0.6);
      border-radius: 9999px;
      width: 0;
      height: 0;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
    }

    .backbutton:hover .transition {
      width: 10em;
      height: 10em;
    }

    .backbutton:active {
      transform: scale(0.97);
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
      <h1>Caregiver Permit</h1>
      <p>A caregiver provides personal care and support to individuals in need, such as the elderly or those with
        disabilities. They assist with daily activities while promoting dignity and independence.</p>
      <a href="../application-form.php" class="btn hero-btn">Apply Now</a>
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
                <p class="lh-lg ps-4 text-content" style="text-align: justify;">
                  The <strong>Caregiver Pilot Program</strong> is designed for individuals who wish to
                  migrate to Canada
                  and work as caregivers. This program provides two pathways for prospective
                  applicants:
                  the <strong>Home Child Care Provider Pilot (HCCP)</strong> and the <strong>Home
                    Support Worker Pilot
                    (HSWP)</strong>.
                  <br><br>
                  These programs were introduced in 2019 following the closure of the Interim Pathway
                  for Caregivers,
                  offering more flexibility and options for caregivers interested in immigrating to
                  Canada.
                  <br><br>
                  Caregivers under this program must have a valid job offer from a Canadian employer,
                  meet the standard
                  criteria for economic immigration, and work in Canada to gain the required
                  experience needed to apply
                  for permanent residence.
                </p>
              </div>
              <div class="col-lg-6 text-center">
                <img src="../img/care.png" alt="Family Image" class="img-fluid rounded tab-image" />
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="criteria" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-4 text-center">
                <img src="../img/criteria.jpg" alt="Checklist" class="img-fluid rounded tab-image" />
              </div>
              <div class="col-lg-8 px-md-4 text-content">
                <h4 class="fw-bold mb-3">Criteria:</h4>
                <ol class="lh-lg ps-0 custom-list">
                  <li>
                    <strong>Basic Immigration Criteria (for Employees):</strong>
                    <ul class="ps-4 list-group-flush" style="list-style-type: circle;">
                      <li><strong>Work Experience:</strong> Must have at least 2 years of experience
                        in NOC 4411 (Home Child Care Provider) or NOC 4412 (Home Support Worker).
                      </li>
                      <li><strong>Job Offer:</strong> Must have a valid, genuine job offer from a
                        Canadian employer.</li>
                      <li><strong>Language Skills:</strong> Minimum CLB 5 in English or French.</li>
                      <li><strong>Education:</strong> At least 1 year of post-secondary education
                        or equivalent recognized in Canada.</li>
                    </ul>
                  </li>
                  <hr class="my-3">
                  <li>
                    <strong>Job Offer Criteria (for Employers):</strong>
                    <ul class="ps-4 list-group-flush" style="list-style-type: circle;">
                      <li>Must use the Offer of Employment IMM 5983 form.</li>
                      <li>Job must be full-time and located outside Quebec.</li>
                      <li>Must fall under NOC 4411 or 4412 categories.</li>
                      <li>Employer must prove no Canadian/permanent resident was available for the
                        job.</li>
                    </ul>
                  </li>
                </ol>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="process" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-8 px-md-4 ps-4 text-content">
                <h4 class="fw-bold mb-3" style="padding-left: 2rem;">Process:</h4>
                <ol class="lh-base" style="font-size: 16px; padding-left: 3rem;">
                  <li class="mb-3">
                    <strong>Employer Extends a Job Offer:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>The employer must provide a genuine, full-time job offer to the
                        caregiver.</li>
                      <li>The offer must meet criteria for NOC 4411 or 4412 and use form IMM 5983.
                      </li>
                    </ul>
                  </li>
                  <li class="mb-3">
                    <strong>Employee Applies for a Work Permit:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>After receiving the job offer, the caregiver applies online for a work
                        permit.</li>
                    </ul>
                  </li>
                  <li class="mb-3">
                    <strong>Work Permit Approval:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Once approved, the caregiver is authorized to work in Canada.</li>
                    </ul>
                  </li>
                  <li class="mb-3">
                    <strong>Gaining Work Experience:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>The caregiver must work for at least 2 years in their designated role.
                      </li>
                    </ul>
                  </li>
                  <li>
                    <strong>Apply for Permanent Residence:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Once 2 years of Canadian experience is completed, the caregiver can apply
                        for PR.</li>
                      <li>Applications may be submitted through Express Entry or other immigration
                        pathways.</li>
                    </ul>
                  </li>
                </ol>
              </div>
              <div class="col-lg-4 text-center">
                <img src="../img/proc.png" alt="Process" class="img-fluid rounded tab-image" />
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="documents" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-4 text-center">
                <img src="../img/documents.png" alt="Documents" class="img-fluid rounded tab-image" />
              </div>
              <div class="col-lg-8 p-4 text-content">
                <h4 class="fw-bold mb-3">Documents:</h4>
                <div style="font-size: 16px; line-height: 1.8;">
                  <p class="fw-bold mb-1">For Employees:</p>
                  <ul class="lh-lg" style="list-style-type: circle; padding-left: 20px;">
                    <li><strong>Valid Job Offer:</strong> A full-time, permanent job offer from a Canadian employer.
                    </li>
                    <li><strong>Work Experience:</strong> Evidence of at least 2 years of experience as a Home Child
                      Care
                      Provider (NOC 4411) or Home Support Worker (NOC 4412).</li>
                    <li><strong>Language Proficiency:</strong> Proof of language skills (CLB 5) in English or French.
                    </li>
                    <li><strong>Education:</strong> Educational credentials or proof of post-secondary education
                      equivalent to Canadian standards.</li>
                    <li><strong>Passport:</strong> Valid passport and other travel documents.</li>
                    <li><strong>Proof of Relationship (if applicable):</strong> For spouses or dependents who may
                      accompany the applicant.</li>
                  </ul>
                  <hr class="my-3">
                  <p class="fw-bold mb-1">For Employers:</p>
                  <ul class="lh-lg" style="list-style-type: circle; padding-left: 20px;">
                    <li><strong>Offer of Employment IMM 5983:</strong> This form must be used to extend the job offer to
                      the caregiver.</li>
                    <li><strong>Employer’s Evidence:</strong> Proof that the employer was unable to fill the position
                      with
                      a Canadian citizen or permanent resident.</li>
                    <li><strong>Job Description:</strong> The job description must match the relevant NOC (4411 or
                      4412).</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="faq" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-8 ps-4 pt-4 text-content">
                <h4 class="fw-bold mb-3">Frequently Asked:</h4>
                <div class="faq ps-4" style="font-size: 16px">
                  <div class="faq-item">
                    <p><strong>Q1:</strong> What is the difference between the Home Child Care Provider Pilot (HCCP) and
                      the Home Support Worker Pilot (HSWP)?</p>
                    <p><strong>A:</strong> HCCP is for individuals who provide child care in a private home, while HSWP
                      is for individuals providing support services to individuals with disabilities, elderly people, or
                      others requiring assistance.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q2:</strong> Can I apply if I don’t have a job offer yet?</p>
                    <p><strong>A:</strong> No, you must have a valid job offer from a Canadian employer before applying
                      for the work permit under this program.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q3:</strong> How can my employer prove they were unable to hire a Canadian citizen or
                      permanent resident?</p>
                    <p><strong>A:</strong> The employer must provide evidence of recruitment efforts to hire a Canadian
                      citizen or permanent resident, showing that they were unable to find a suitable candidate for the
                      position.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q4:</strong> Is there a minimum duration for my job offer?</p>
                    <p><strong>A:</strong> Yes, the job offer must be full-time and permanent, not temporary.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q5:</strong> How long do I need to work in Canada before applying for Permanent
                      Residency?</p>
                    <p><strong>A:</strong> You must work for at least 2 years in your designated role in Canada to
                      qualify for permanent residency.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q6:</strong> Can my family come with me?</p>
                    <p><strong>A:</strong> Yes, under the Caregiver Pilot Program, your spouse and dependent children
                      may be eligible to join you in Canada during your stay.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 text-center">
                <img src="../img/faq.jpg" alt="FAQs Image" class="img-fluid rounded tab-image" />
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
