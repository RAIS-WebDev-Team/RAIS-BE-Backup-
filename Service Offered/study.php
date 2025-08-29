<?php
// This PHP script generates the entire HTML page for the Study Permit information.
// It uses HEREDOC syntax for outputting large blocks of HTML.

// Output the head and main content of the HTML document.
echo <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Study Permit</title>
  <link rel="icon" href="../img/logoulit.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
      background: url('../img/Fstudy.jpg')no-repeat center center/cover;
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
      margin-top: 30px;
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
      margin-top: 30px;
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

      .text-content, #process li, #documents ul, #faq p {
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
  <main>
    <header>
      <div class="overlay-box"></div>
      <div class="logo">
        <a href="../index.php">
          <img src="../img/logo1.png" alt="logo" />
        </a>
      </div>
      <div class="hero-content text-white text-center">
        <h1>Study Permit</h1>
        <p>A study permit allows individuals to study legally in a country, requiring proof of enrollment and
          financial stability. In some countries, like the Philippines, it is also necessary for obtaining a
          driver’s license.</p>
        <a href="../form.html" class="btn hero-btn">Apply Now</a>
      </div>
    </header>
    <section class="py-5 my-5 mt-5" id="info">
      <div class="container fixed-container px-4 px-md-5">
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
        <div class="tab-content">
          <div class="tab-pane fade show active" id="about" role="tabpanel">
            <div class="container-lg">
              <div class="row align-items-center g-4">
                <div class="col-md-6">
                  <p class="lh-lg ps-md-5" style="font-size: 16px;line-height: 1.5; text-align: justify;">
                    Canada's education system is renowned worldwide for its quality, and it attracts
                    thousands of international students every year. The Canadian government and
                    institutions prioritize academic excellence, making Canada one of the top
                    choices
                    for students seeking world-class education. Students who graduate from Canadian
                    institutions often find that their credentials are highly valued globally,
                    enhancing
                    their job prospects and career growth.
                    <br><br>
                    Studying in Canada offers not only access to top-notch education but also an
                    unparalleled cultural and living experience. The country's vibrant,
                    multicultural
                    environment makes it a great place to live and learn, with a high quality of
                    life
                    and excellent safety standards. Furthermore, Canada offers opportunities for
                    international students to work during their studies and even stay on after
                    graduation through programs such as the Post-Graduation Work Permit Program
                    (PGWPP).
                  </p>
                </div>
                <div class="col-md-6 text-center">
                  <img src="../img/study.png" alt="Study Image" class="img-fluid rounded tab-image" />
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="criteria" role="tabpanel">
            <div class="container-lg">
              <div class="row align-items-center g-4">
                <div class="col-md-3 text-center">
                  <img src="../img/criteria.jpg" class="img-fluid rounded tab-image"
                    alt="Checklist">
                </div>
                <div class="col-md-9 px-md-5" style="font-size: 16px;line-height: 1.8;">
                  <h5 class="fw-bold mb-3">Criteria:</h5>
                  <div class="mb-4">
                    <p class="fw-bold">1. Eligibility for International Students:</p>
                    <ul class="ps-3" style="list-style-type: circle;">
                      <li>You must have accepted admission to a Designated Learning Institution
                        (DLI)
                        in Canada.</li>
                      <li>You must prove that you have enough funds to cover tuition fees, living
                        expenses, and return travel to your home country.</li>
                      <li>You must have no criminal record and provide a police certificate, if
                        necessary.</li>
                      <li>You must be in good health and may need a medical exam.</li>
                      <li>You must satisfy the visa officer that you will leave Canada at the end
                        of
                        your authorized stay.</li>
                    </ul>
                  </div>
                  <hr class="my-4" />
                  <div class="mb-4">
                    <p class="fw-bold">2. Admission Requirements for Schools:</p>
                    <ul class="ps-3" style="list-style-type: circle;">
                      <li>Schools may have different requirements based on the program and
                        institution.</li>
                      <li>Most Canadian institutions require that applicants provide academic
                        transcripts, language proficiency test scores (e.g., IELTS or TOEFL),
                        and
                        sometimes letters of recommendation.</li>
                      <li>Each school and program may have specific documents or prerequisites, so
                        always check with the institution for detailed information.</li>
                    </ul>
                  </div>
                  <hr class="my-4" />
                  <div class="mb-4">
                    <p class="fw-bold">3. English/French Language Proficiency:</p>
                    <ul class="ps-3" style="list-style-type: circle;">
                      <li>As most programs in Canada are offered in English or French, you will
                        likely
                        need to prove your language proficiency through a recognized test (such
                        as
                        IELTS, TOEFL, or TEF).</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="process" role="tabpanel">
            <div class="container-lg">
              <div class="row align-items-center g-4">
                <div class="col-md-9 px-md-5">
                  <h5 class="fw-bold mb-3">Process:</h5>
                  <ol class="lh-base" style="font-size: 15px; line-height: 1.6; padding-left: 1rem;">
                    <li class="mb-3 pb-3 border-bottom">
                      <strong>Choose Your Course and School</strong>
                      <ul class="mt-2 ps-4" style="list-style-type: circle;">
                        <li>Research and select a Designated Learning Institution (DLI) that
                          offers
                          the program of your choice. Only DLIs can accept international
                          students.
                        </li>
                        <li>Make sure the school you apply to offers the program that matches
                          your
                          academic and career interests.</li>
                      </ul>
                    </li>
                    <li class="mb-3 pb-3 border-bottom">
                      <strong>Understand School Requirements</strong>
                      <ul class="mt-2 ps-4" style="list-style-type: circle;">
                        <li>Check the admission requirements of the school or program. These can
                          include academic transcripts, test scores (IELTS/TOEFL), letters of
                          recommendation, and more.</li>
                        <li>Different institutions may have varying admission deadlines, so
                          ensure
                          you are well aware of them.</li>
                      </ul>
                    </li>
                    <li class="mb-3 pb-3 border-bottom">
                      <strong>Submit Your Application</strong>
                      <ul class="mt-2 ps-4" style="list-style-type: circle;">
                        <li>Apply to schools in Canada through their online application systems.
                          Most schools allow you to apply to multiple institutions.</li>
                        <li>Prepare to pay an administration fee, which can range from CAD 100
                          to
                          CAD 2,500, depending on the school.</li>
                      </ul>
                    </li>
                    <li class="mb-3 pb-3 border-bottom">
                      <strong>Wait for Admission Results</strong>
                      <ul class="mt-2 ps-4" style="list-style-type: circle;">
                        <li>Admission results are typically released within 2-3 weeks.</li>
                        <li>If admitted, you will be required to pay the tuition fees for the
                          first
                          semester.</li>
                        <li>The school will send you an official letter of admission (Letter of
                          Acceptance, LOA), which you will need for your study permit
                          application.
                        </li>
                      </ul>
                    </li>
                    <li class="mb-3 pb-3 border-bottom">
                      <strong>Apply for a Study Permit</strong>
                      <ul class="mt-2 ps-4" style="list-style-type: circle;">
                        <li>After receiving your Letter of Acceptance (LOA), apply for a study
                          permit. The application process can take 20-70 days.</li>
                        <li>Submit required documents such as proof of financial support,
                          medical
                          exam results (if required), and police clearance (if applicable).
                        </li>
                      </ul>
                    </li>
                    <li class="mb-3 pb-3 border-bottom">
                      <strong>Travel to Canada</strong>
                      <ul class="mt-2 ps-4" style="list-style-type: circle;">
                        <li>Once your study permit is approved, begin planning your travel to
                          Canada. Ensure you travel after the start date mentioned on your
                          study
                          permit.</li>
                      </ul>
                    </li>
                    <li>
                      <strong>Begin Your Studies in Canada</strong>
                      <ul class="mt-2 ps-4" style="list-style-type: circle;">
                        <li>Upon arrival, ensure you follow all the conditions of your study
                          permit,
                          including the ability to work part-time (up to 20 hours per week
                          during
                          the semester and full-time during breaks).</li>
                        <li>Build connections and gain Canadian work experience, which could
                          later
                          help in applying for permanent residency through the Post-Graduation
                          Work Permit Program (PGWPP).</li>
                      </ul>
                    </li>
                  </ol>
                </div>
                <div class="col-md-3 text-center">
                  <img src="../img/proc.png" alt="Process" class="img-fluid rounded tab-image" />
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="documents" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-md-3 text-center">
                <img src="../img/documents.png" alt="Documents" class="img-fluid rounded tab-image" />
              </div>
              <div class="col-md-9 px-5">
                <h5 class="fw-bold mb-3" style="font-size: 16px; line-height: 1.0;">Required Documents:
                </h5>
                <ol class="lh-lg" style="font-size: 16px;">
                  <li>
                    <strong>Documents for Study Permit Application:</strong>
                    <ul class="mt-2 ps-4">
                      <li>Proof of citizenship or permanent residency.</li>
                      <li>Letter of Acceptance (LOA) from a Designated Learning Institution (DLI).
                      </li>
                      <li>Proof of Funds to show financial support for yourself and any
                        accompanying family.</li>
                      <li>Valid Passport.</li>
                      <li>Proof of Language Proficiency (e.g., IELTS, TOEFL).</li>
                      <li>Medical Examination (if required).</li>
                      <li>Police Certificate (if required).</li>
                      <li>Digital Photo for your application.</li>
                      <li>Statement of Purpose outlining your goals and plans after study.</li>
                    </ul>
                  </li>
                  <hr class="my-4" />
                  <li>
                    <strong>Documents for Admission to Canadian Schools:</strong>
                    <ul class="mt-2 ps-4">
                      <li>Academic Transcripts from previous education.</li>
                      <li>Language Proficiency Test Results (e.g., IELTS or TOEFL).</li>
                      <li>Medical exam results (if required).</li>
                      <li>Letters of Recommendation.</li>
                      <li>Statement of Purpose for some programs.</li>
                    </ul>
                  </li>
                  <hr class="my-4" />
                  <li>
                    <strong>Documents for Family Members:</strong>
                    <ul class="mt-2 ps-4">
                      <li>If bringing a spouse or children, submit supporting documents for their
                        visitor visa or work/study permits.</li>
                    </ul>
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="faq" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-md-9 px-5">
                <h5 class="fw-bold mb-3" style="font-size: 16px; line-height: 1.8;">Frequently Asked:
                </h5>
                <ul class="list-group list-group-flush lh-lg text-justify" style="font-size: 16px;">
                  <li class="list-group-item">
                    <strong>Q1:</strong> Can I work while studying in Canada?<br>
                    <strong>A:</strong>Yes, international students can work up to 20 hours per week
                    during the academic
                    session and full-time during scheduled breaks (like summer holidays).
                  </li>
                  <li class="list-group-item">
                    <strong>Q2:</strong> Can I bring my family with me while I study in Canada?<br>
                    <strong>A:</strong>Yes, your spouse or common-law partner can apply for a work
                    permit and your
                    dependent children can apply for a study permit to attend school in Canada.
                  </li>
                  <li class="list-group-item">
                    <strong>Q3:</strong> What is the Post-Graduation Work Permit Program
                    (PGWPP)?<br>
                    <strong>A:</strong>The PGWPP allows students who have graduated from eligible
                    Designated Learning
                    Institutions (DLIs) to apply for an open work permit, giving them the
                    opportunity to
                    gain Canadian work experience. This work experience may help qualify them for
                    permanent residency through the Canadian Experience Class within the Express
                    Entry
                    system.
                  </li>
                  <li class="list-group-item">
                    <strong>Q4:</strong> How long does it take to get a study permit?<br>
                    <strong>A:</strong>The processing time for a study permit can vary, typically
                    taking
                    20 to 70 days,
                    depending on the country of application and other factors.
                  </li>
                  <li class="list-group-item">
                    <strong>Q5:</strong> Can I apply to multiple schools in Canada?<br>
                    <strong>A:</strong>Yes, you can apply to multiple schools in Canada. However,
                    you
                    must carefully manage
                    application fees, as they can range from CAD 100 to CAD 2,500 per institution.
                  </li>
                  <li class="list-group-item">
                    <strong>Q6:</strong> Can I extend my study permit if my course duration is
                    longer
                    than
                    expected?<br>
                    <strong>A:</strong>Yes, you can apply for an extension of your study permit
                    while
                    you are still in
                    Canada, as long as your program is ongoing.
                  </li>
                  <li class="list-group-item">
                    <strong>Q7:</strong> What happens after I graduate from a Canadian
                    institution?<br>
                    <strong>A:</strong>After graduation, you may be eligible to apply for a
                    Post-Graduation Work Permit
                    (PGWP), which allows you to work in Canada and gain Canadian work experience
                    that
                    can help in your application for permanent residency.
                  </li>
                </ul>
              </div>
              <div class="col-md-3 text-center">
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
