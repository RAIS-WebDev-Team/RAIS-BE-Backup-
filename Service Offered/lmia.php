<?php
// This PHP script generates the entire HTML page for the Labor Market Impact Assessment (LMIA) information.
// It uses HEREDOC syntax for outputting large blocks of HTML.

// Output the head and main content of the HTML document.
echo <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Labor Market Impact Assesment</title>
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
      background: url('../img/Flmia.jpg')no-repeat center center/cover;
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

      #info h4,
      #info h5 {
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
      <h1>Labour Market Impact Assessment (LMIA)</h1>
      <p>
        An LMIA is a document in Canada that evaluates the effect of hiring a foreign worker on the local job
        market. A positive LMIA shows a need for a foreign worker because no local candidates are available.
      </p>
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
                <p class="lh-lg ps-4 text-content" style="text-align: justify;">
                  A <strong>Labour Market Impact Assessment (LMIA)</strong> is a crucial document that
                  employers in
                  Canada
                  must obtain before hiring a temporary foreign worker (TFW). The LMIA process allows
                  the
                  Canadian government to assess whether hiring a foreign worker will have a positive
                  or
                  negative impact on the Canadian labor market. A positive LMIA means there is a
                  demonstrated need for a foreign worker to fill the position and that no qualified
                  Canadian citizens or permanent residents are available.
                  <br><br>
                  Additionally, there are high-wage and low-wage categories for LMIA applications,
                  depending on the offered salary compared to the provincial or territorial median
                  wage.
                  Some work permit types are LMIA-exempt and fall under the International Mobility
                  Program.
                </p>
              </div>
              <div class="col-lg-6 text-center">
                <img src="../img/lmia1.png" alt="LMIA Image" class="img-fluid rounded tab-image" />
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
                <div class="mb-4">
                  <h5 class="fw-bold mb-2">Employer Eligibility:</h5>
                  <ul class="ps-3" style="list-style-type: circle;">
                    <li>The employer must be a legitimate Canadian business with the ability to meet
                      the
                      requirements of the LMIA process.</li>
                    <li>The employer must be willing to hire a temporary foreign worker and provide
                      employment conditions that comply with Canadian labor standards.</li>
                  </ul>
                </div>
                <hr class="my-4" />
                <div class="mb-4">
                  <h5 class="fw-bold mb-2">Job Advertisement:</h5>
                  <ul class="ps-3" style="list-style-type: circle;">
                    <li>Employers are generally required to advertise the job position for at least
                      four
                      weeks using recognized platforms (e.g., job boards, newspapers) to prove
                      that no
                      qualified Canadian citizen or permanent resident was available for the job.
                    </li>
                  </ul>
                </div>
                <hr class="my-4" />
                <div class="mb-4">
                  <h5 class="fw-bold mb-2">Salary and Job Type:</h5>
                  <ul class="ps-3" style="list-style-type: circle;">
                    <li>Positions are classified as high-wage or low-wage based on the
                      provincial/territorial median wage.</li>
                  </ul>
                </div>
                <hr class="my-4" />
                <div class="mb-4">
                  <h5 class="fw-bold mb-2">Documentation:</h5>
                  <ul class="ps-3" style="list-style-type: circle;">
                    <li>Employers must provide comprehensive documentation detailing why Canadian
                      applicants were not hired and must prove no qualified citizens or permanent
                      residents applied.</li>
                  </ul>
                </div>
                <div>
                  <h5 class="fw-bold mb-2">Employer’s Ability to Support:</h5>
                  <ul class="ps-3" style="list-style-type: circle;">
                    <li>The employer must demonstrate the ability to support the foreign worker,
                      including providing a safe work environment and complying with labor laws.
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="process" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-8 px-md-4 ps-4 text-content">
                <h4 class="fw-bold mb-3" style="padding-left: 2rem;">LMIA Process:</h4>
                <ol class="lh-base" style="font-size: 18px; padding-left: 3rem;">
                  <li class="mb-3">
                    <strong>Determine the job category:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Identify if it’s a high-wage or low-wage position.</li>
                    </ul>
                  </li>
                  <li class="mb-3">
                    <strong>Advertise the job:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Publish the job ad for a minimum of four weeks using multiple platforms.
                      </li>
                    </ul>
                  </li>
                  <li class="mb-3">
                    <strong>Gather documentation:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Prepare business details, financials, and recruitment efforts.</li>
                    </ul>
                  </li>
                  <li class="mb-3">
                    <strong>Submit LMIA application:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Send the complete application to ESDC for review.</li>
                    </ul>
                  </li>
                  <li class="mb-3">
                    <strong>ESDC assessment:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Government assesses employer's legitimacy and labor market impact.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Receive decision:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Employer gets a positive or negative LMIA decision.</li>
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
                <h4 class="fw-bold mb-3">To apply for an LMIA, employers typically need to submit the
                  following documents:</h4>
                <ol class="px-3" style="font-size: 18px; line-height: 1.8;">
                  <li>
                    <strong>Employer’s Information:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Business license or registration – Proof of the company’s legal status.
                      </li>
                      <li>Financial information or evidence that the business can financially
                        support
                        a foreign worker.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Job Advertisement Records:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Proof of the job advertisement for at least four weeks, including dates,
                        platforms used, and a description of the recruitment efforts made.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Job Description:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Detailed job description outlining duties, responsibilities, salary, and
                        working conditions.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Reasons for Not Hiring Canadians:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Documentation explaining why Canadian candidates were not suitable for
                        the
                        position (e.g., skills mismatch, lack of experience).</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Employee Salary Information:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Proof of the salary offered to the foreign worker and its comparison to
                        the
                        provincial or territorial median wage.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Employer’s Statement:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>A letter or statement from the employer explaining the need for a
                        foreign
                        worker and the terms of employment.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Additional Documents:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Any other documents requested by Employment and Social Development
                        Canada
                        (ESDC) based on the job type or wage category.</li>
                    </ul>
                  </li>
                </ol>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="faq" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-8 ps-4 text-content">
                <h4 class="fw-bold mb-3">Frequently Asked:</h4>
                <div class="ps-4">
                  <div class="faq-item">
                    <p><strong>Q1:</strong> What is the difference between high-wage and low-wage
                      LMIA
                      applications?</p>
                    <p><strong>A:</strong> High-wage LMIA applications are for positions that offer
                      a
                      salary at or above the provincial/territorial median wage, while low-wage
                      applications are for positions paying below that threshold.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q2:</strong> Do I need an LMIA for every type of work permit?</p>
                    <p><strong>A:</strong> No, not all work permits require an LMIA. Some workers
                      may be
                      exempt from needing an LMIA if their position falls under the International
                      Mobility Program.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q3:</strong> How long does it take to get a positive LMIA?</p>
                    <p><strong>A:</strong> The processing time for an LMIA application can take
                      several
                      weeks to a few months, depending on the complexity of the application and
                      the
                      volume of requests being processed.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q4:</strong> Can I hire a foreign worker without advertising the job
                      for
                      four weeks?</p>
                    <p><strong>A:</strong> Generally, the advertisement period is required. However,
                      there
                      may be exceptions in certain cases. It’s essential to check if your specific
                      situation qualifies for an exemption or expedited process.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q5:</strong> What happens if my LMIA is denied?</p>
                    <p><strong>A:</strong> If your LMIA application is denied, you can either
                      reapply with
                      additional documentation or review the reasons for the refusal. You may also
                      need
                      to make adjustments to your recruitment process.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q6:</strong> Is there any way to speed up the LMIA process?</p>
                    <p><strong>A:</strong> The LMIA process can take time, but ensuring your
                      application is
                      complete and well-documented can help avoid delays. Some employers may be
                      eligible
                      for expedited processing under certain circumstances, such as for
                      high-demand jobs
                      or workers in critical sectors.</p>
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
