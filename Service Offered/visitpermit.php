<?php
// This PHP script generates the entire HTML page for the Visit Permit information.
// It uses HEREDOC syntax for outputting large blocks of HTML.

// Output the head and main content of the HTML document.
echo <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Visit Permit</title>
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
      background: url('../img/fvisit.jpg')no-repeat center center/cover;
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
        <img src="../img/logo1.png" alt="logo" />
      </a>
    </div>
    <div class="hero-content text-white text-center">
      <h1>Visit Permit</h1>
      <p>A tourist visa lets individuals visit a country for leisure or family visits, typically requiring a valid
        passport, financial proof, and return tickets. It does not permit work during the stay.</p>
      <a href="../form.html" class="btn hero-btn">Apply Now</a>
    </div>
  </header>
  <main>
    <section class="py-5 my-5" id="info">
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

        <div class="tab-content" style="font-size: 18px; line-height: 1.8; text-align: justify;">
          <div class="tab-pane fade show active" id="about" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-md-6 ps-4">
                <p>
                  A Visitor Visa, also known as a Temporary Resident Visa (TRV) or tourist visa, is an
                  official document
                  placed in your passport by a Canadian visa office to show that you meet the requirements
                  to enter Canada
                  as a temporary resident. Visitors can enter Canada for various purposes, such as
                  tourism, family visits,
                  or business activities. Most visitors can stay in Canada for up to 6 months.
                  <br><br>
                  Visitors are not Canadian citizens or permanent residents, but they are legally
                  authorized to enter
                  Canada temporarily. The length of stay is typically 6 months, but the border services
                  officer at the
                  port of entry may adjust this duration based on individual circumstances. Visitors may
                  also receive a
                  visitor record, which outlines the date they are required to leave.
                </p>
              </div>
              <div class="col-md-6 text-center">
                <img src="../img/visa1.png" alt="Visa Image" class="img-fluid rounded tab-image" />
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="criteria" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-md-3 text-center">
                <img src="../img/criteria.jpg" class="img-fluid rounded tab-image"
                  alt="Checklist">
              </div>
              <div class="col-md-9 px-5">
                <h4 class="fw-bold mb-3">Criteria:</h4>
                <p class="fw-bold">You may need a Visitor Visa if you meet the following criteria:</p>
                <p><strong>1. Purpose of Visit:</strong>
                  <li style="list-style-type: circle; padding-left: 1.5rem;">You are traveling to Canada for tourism,
                    business,
                    or to visit
                    family members.</li>
                </p>
                <p><strong>2. Travel Document:</strong>
                  <li style="list-style-type: circle; padding-left: 1.5rem;">You are traveling with a valid passport or
                    travel
                    document.</li>
                </p>
                <p><strong>3. Nationality:</strong>
                  <li style="list-style-type: circle; padding-left: 1.5rem;">Your nationality determines whether you need
                    a Visitor
                    Visa or an
                    Electronic Travel Authorization (eTA).</li>
                </p>
                <p><strong>4. Eligibility:</strong> You must be able to demonstrate that you:</p>
                <ul style="list-style-type: circle; padding-left: 1.5rem;">
                  <li>Have enough money for your stay and return.</li>
                  <li>Have strong ties to your home country (such as a job, family, or property) to prove
                    that you will
                    leave Canada at the end of your visit.</li>
                  <li>Will obey the conditions of your visa and leave Canada at the end of your authorized
                    stay.</li>
                </ul>
                <p>If you are unsure whether you qualify for a Visitor Visa, you can speak to an immigration
                  specialist
                  for further guidance.</p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="process" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-md-9 px-5" style="font-size: 18px;">
                <h4 class="fw-bold mb-3">Process:</h4>
                <ol class="lh-base">
                  <li>
                    <strong>Check Visa Requirements</strong>
                    <ul style="list-style-type: circle; margin: 0; padding-left: 1rem;">
                      <li>Verify if you need a Visitor Visa or an Electronic Travel Authorization
                        (eTA) based on your
                        nationality, travel document, and method of travel.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Prepare Your Application</strong>
                    <ul style="list-style-type: circle; margin: 0; padding-left: 1rem;">
                      <li>Gather all necessary documents, including proof of financial support, travel
                        history, and ties
                        to your home country.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Submit Your Application</strong>
                    <ul style="list-style-type: circle; margin: 0; padding-left: 1rem;">
                      <li>Complete the online or paper application for a Visitor Visa and submit it
                        along with required
                        documents.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Wait for Decision</strong>
                    <ul style="list-style-type: circle; margin: 0; padding-left: 1rem;">
                      <li>Once your application is submitted, the Canadian visa office will review it.
                        Processing times
                        can vary, so check the estimated timeframes.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Receive a Decision</strong>
                    <ul style="list-style-type: circle; margin: 0; padding-left: 1rem;">
                      <li>If your application is approved, you will receive a <strong>Visitor
                          Visa</strong> in your
                        passport. If additional documents are required, you will be contacted.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Travel to Canada</strong>
                    <ul style="list-style-type: circle; margin: 0; padding-left: 1rem;">
                      <li>After receiving your Visitor Visa, you can travel to Canada. Upon arrival,
                        the border services
                        officer will determine your exact length of stay.</li>
                    </ul>
                  </li>
                </ol>
              </div>
              <div class="col-md-3 text-center">
                <img src="../img/proc.png" alt="Process" class="img-fluid rounded tab-image" />
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="documents" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-md-3 text-center">
                <img src="../img/documents.png" alt="Documents" class="img-fluid rounded tab-image" />
              </div>
              <div class="col-md-9 ps-md-5" style="font-size: 18px;">
                <h4 class="fw-bold">Required Documents:</h4>
                <ol class="lh-base px-5">
                  <li>
                    <strong>Valid Passport</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Your passport should be valid for the duration of your stay in Canada.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Completed Application Form</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>The official application for a Visitor Visa (available online or in paper
                        form).</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Proof of Financial Support</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Documents showing you have enough money to support yourself during your stay
                        in Canada.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Travel Itinerary</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>A detailed plan of your travel in Canada (e.g., flight bookings,
                        accommodation arrangements).
                      </li>
                    </ul>
                  </li>
                  <li>
                    <strong>Ties to Home Country</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Evidence of ties to your home country (e.g., employment letter, property
                        ownership, family).
                      </li>
                    </ul>
                  </li>
                  <li>
                    <strong>Photographs</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Passport-sized photos that meet Canada’s visa photo requirements.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Application Fees</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Payment of the visa application fee.</li>
                    </ul>
                  </li>
                  <li>
                    <strong>Additional Documents (if applicable)</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Depending on your case, additional documents may be required, such as an
                        invitation letter from
                        family or business partners in Canada.</li>
                    </ul>
                  </li>
                </ol>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="faq" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-md-9">
                <h5 class="fw-bold mb-3">Frequently Asked:</h5>
                <ul class="list-group list-group-flush" style="font-size: 16px; line-height: 1.4;">
                  <li class="list-group-item">
                    <p class="mb-1"><strong>Q1:</strong> How long can I stay in Canada with a Visitor
                      Visa?</p>
                    <p class="mb-0"><strong>A:</strong> Most visitors are allowed to stay for up to 6
                      months. However,
                      the
                      border services officer may allow a shorter or longer stay based on individual
                      circumstances.</p>
                  </li>
                  <li class="list-group-item">
                    <p class="mb-1"><strong>Q2:</strong> Do I need a Visitor Visa to visit Canada?</p>
                    <p class="mb-0"><strong>A:</strong> Not everyone needs a Visitor Visa. Depending on
                      your nationality
                      and travel document, you may need either a Visitor Visa or an Electronic Travel
                      Authorization
                      (eTA).
                      Check with the Canadian authorities or consult an immigration specialist.</p>
                  </li>
                  <li class="list-group-item">
                    <p class="mb-1"><strong>Q3:</strong> Can I work or study while on a Visitor Visa?
                    </p>
                    <p class="mb-0"><strong>A:</strong> No, a Visitor Visa does not allow you to work or
                      study in
                      Canada.
                      If you wish to work or study, you will need to apply for the appropriate visa or
                      permit.</p>
                  </li>
                  <li class="list-group-item">
                    <p class="mb-1"><strong>Q4:</strong> What happens if I stay longer than the allowed
                      time?</p>
                    <p class="mb-0"><strong>A:</strong> If you overstay your visa, you may be subject to
                      penalties,
                      including removal from Canada or a ban from entering in the future. It’s crucial
                      to comply with
                      the
                      conditions of your visa.</p>
                  </li>
                  <li class="list-group-item">
                    <p class="mb-1"><strong>Q5:</strong> Can I extend my stay in Canada with a Visitor
                      Visa?</p>
                    <p class="mb-0"><strong>A:</strong> Yes, you can apply to extend your stay while in
                      Canada if you
                      want
                      to remain longer. You must apply for an extension before your current visitor
                      status expires.</p>
                  </li>
                  <li class="list-group-item">
                    <p class="mb-1"><strong>Q6:</strong> Do I need to provide biometrics for my Visitor
                      Visa application?
                    </p>
                    <p class="mb-0"><strong>A:</strong> Some applicants are required to provide
                      biometrics (fingerprints
                      and a photo) as part of the application process. You will be notified if you
                      need to provide
                      biometrics.</p>
                  </li>
                  <li class="list-group-item">
                    <p class="mb-1"><strong>Q7:</strong> Can I visit Canada multiple times with the same
                      Visitor Visa?
                    </p>
                    <p class="mb-0"><strong>A:</strong> A Visitor Visa is typically valid for a single
                      entry or multiple
                      entries, depending on the visa issued. You can apply for multiple-entry visas if
                      you plan to visit
                      Canada more than once.</p>
                  </li>
                </ul>
              </div>
              <div class="col-md-3 text-center">
                <img src="../img/faq.jpg" alt="Process" class="img-fluid rounded tab-image" />
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
