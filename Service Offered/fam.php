<?php
// This PHP script generates the entire HTML page for the Family Permit information.
// It uses HEREDOC syntax for outputting large blocks of HTML.

// Output the head and main content of the HTML document.
echo <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Family Permit</title>
  <link rel="icon" href="../img/logoulit.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    /* General Styles */
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


    /* Header & Hero Section */
    header {
      position: relative;
      height: 100vh;
      background: url('../img/Ffam.jpg') no-repeat center center/cover;
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
      background-color: rgba(0, 0, 0, 0.5);
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
      padding: 0 15px;
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

    /* Tab Navigation */
    .nav-tabs {
      border-bottom: none;
    }

    .nav-tabs .nav-link {
      color: #444;
      font-weight: 600;
      border-radius: 0;
      border: none;
      transition: all 0.3s ease;
      position: relative;
      padding-bottom: 10px;
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
      min-height: 550px;
      /* Adjusted height slightly */
    }

    .tab-image {
      max-height: 400px;
      width: 100%;
      object-fit: contain;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }



    .tab-content-text {
      font-size: 1.125rem;
      line-height: 1.7;
      text-align: justify;
    }

    .fixed-container {
      max-width: 1500px;
      width: 100%;
      margin: 0 auto;
      padding: 0 15px;
    }

    /* Mobile Nav Buttons */
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

    .nav-btn:disabled {
      background-color: #e9ecef;
      color: #6c757d;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    /* Media Queries */
    @media (min-width: 992px) {
      .tab-navigation-buttons {
        display: none;
      }
    }

    @media (max-width: 1024px) {
      .hero-content h1 {
        font-size: 2.5rem;
      }

      .hero-content p {
        font-size: 1rem;
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
        font-size: 14px;
        padding: 10px 20px;
      }

      #info h4 {
        font-size: 18px;
      }

      #info h5 {
        font-size: 16px;
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
      <h1>Family Permit</h1>
      <p>Family sponsorship allows individuals to bring their family members to live with them in another country,
        requiring proof of financial stability and support commitment. It helps reunite families and provides
        opportunities for a better life.</p>
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
                <p class="lh-lg ps-4 text-content tab-content-text">
                  Family Sponsorship is a Canadian immigration program designed to allow citizens and permanent
                  residents to bring their close family members—such as spouses, partners, dependent children, parents,
                  and grandparents—to live with them in Canada permanently. This initiative plays a crucial role in
                  supporting family unity, offering sponsored individuals the opportunity to settle, thrive, and
                  contribute to Canadian society. The ultimate goal of the program is to help families reunite, foster
                  stronger social bonds, and build a stable life together in Canada.
                </p>
              </div>
              <div class="col-lg-6 text-center">
                <img src="../img/fam.png" alt="Family Image" class="img-fluid rounded tab-image" />
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
                  <h5 class="fw-bold mb-2">Eligibility of the Sponsor:</h5>
                  <ol class="px-3" style="list-style-type: decimal;">
                    <li><strong>Canadian Citizenship or Permanent Residency:</strong>
                      <ul style="list-style-type: circle; padding-left: 1.2rem;">
                        <li>Must be a Canadian citizen or permanent resident.</li>
                      </ul>
                    </li>
                    <li><strong>Age:</strong>
                      <ul style="list-style-type: circle; padding-left: 1.2rem;">
                        <li>At least 18 years old.</li>
                      </ul>
                    </li>
                    <li><strong>Financial Support:</strong>
                      <ul style="list-style-type: circle; padding-left: 1.2rem;">
                        <li>Must demonstrate the ability to financially support their relative and provide basic needs
                          (food, clothing, shelter).</li>
                      </ul>
                    </li>
                    <li><strong>Not Receiving Social Assistance:</strong>
                      <ul style="list-style-type: circle; padding-left: 1.2rem;">
                        <li>Must not be receiving social assistance (except for reasons of disability).</li>
                      </ul>
                    </li>
                  </ol>
                </div>
                <hr class="my-4" />
                <div>
                  <h5 class="fw-bold mb-2">Eligibility of the Sponsored Person:</h5>
                  <ol class="px-3" style="list-style-type: decimal;">
                    <li><strong>Spouse, Common-law Partner, or Conjugal Partner:</strong>
                      <ul style="list-style-type: circle; padding-left: 1.2rem;">
                        <li>They must be in a genuine relationship with the sponsor and meet the legal definition of
                          spouse, common-law, or conjugal partner.</li>
                      </ul>
                    </li>
                    <li><strong>Dependent Children:</strong>
                      <ul style="list-style-type: circle; padding-left: 1.2rem;">
                        <li>Must be under 22 years old and not married or in a common-law relationship. Children over 22
                          may be eligible if they are financially dependent due to a physical or mental condition.</li>
                      </ul>
                    </li>
                    <li><strong>Parents or Grandparents:</strong>
                      <ul style="list-style-type: circle; padding-left: 1.2rem;">
                        <li>Parents and grandparents can be sponsored, but they must meet specific eligibility criteria,
                          including health and security requirements.</li>
                      </ul>
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="process" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-8 px-md-4 ps-4 text-content">
                <h4 class="fw-bold mb-3" style="padding-left: 2rem;">Process:</h4>
                <ol class="lh-base" style="font-size: 18px; padding-left: 3rem;">
                  <li class="mb-3"><strong>Determine eligibility:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Both the sponsor and the sponsored person need to meet eligibility requirements. The sponsor
                        must ensure they can financially support the relative and provide the required documentation.
                      </li>
                    </ul>
                  </li>
                  <li class="mb-3"><strong>Submit Sponsorship Application:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>The sponsor must submit a complete sponsorship application to Immigration, Refugees and
                        Citizenship Canada (IRCC), including both sponsorship and applicant forms.</li>
                    </ul>
                  </li>
                  <li class="mb-3"><strong>IRCC Review:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>The IRCC will assess the eligibility of both the sponsor and the sponsored person to ensure
                        they meet all criteria.</li>
                    </ul>
                  </li>
                  <li class="mb-3"><strong>Approval and Permanent Residency:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>Once approved, the sponsored family member will receive permanent resident status, allowing
                        them to live, work, and study in Canada.</li>
                    </ul>
                  </li>
                  <li><strong>Arrival in Canada:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem; margin-top: 0.3rem;">
                      <li>The sponsored person can then arrive in Canada and begin their life as a permanent resident.
                      </li>
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
                <h4 class="fw-bold mb-3">To apply for Family Sponsorship, the following documents are typically
                  required:</h4>
                <ol class="px-3" style="font-size: 18px; line-height: 1.8;">
                  <li><strong>For the Sponsor:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li>Proof of Canadian citizenship or permanent residency (e.g., passport, PR card).</li>
                      <li><strong>Proof of income:</strong> Demonstrating the ability to financially support the
                        sponsored person.</li>
                      <li><strong>Application for sponsorship:</strong> Completed and signed.</li>
                      <li><strong>Any previous relationships:</strong> Divorce certificates or death certificates if
                        applicable (for spousal sponsorship).</li>
                    </ul>
                  </li>
                  <li><strong>For the Sponsored Person:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li><strong>Proof of relationship:</strong> Evidence of marriage, common-law partnership, or proof
                        of dependency (e.g., marriage certificate, joint financial records).</li>
                      <li><strong>Proof of identity:</strong> Passport, national ID card, or birth certificate.</li>
                      <li><strong>Medical exam results:</strong> To confirm they are medically admissible to Canada.
                      </li>
                      <li><strong>Police certificates:</strong> To show that they have no serious criminal history.</li>
                      <li><strong>Proof of financial dependency:</strong> For children or dependent adults.</li>
                    </ul>
                  </li>
                  <li><strong>For Both:</strong>
                    <ul style="list-style-type: circle; padding-left: 1.2rem;">
                      <li><strong>Application fee:</strong> Payment for processing the sponsorship application.</li>
                    </ul>
                  </li>
                </ol>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="faq" role="tabpanel">
            <div class="row align-items-center g-4">
              <div class="col-lg-8 ps-4 text-content" style="font-size: 16px;">
                <h4 class="fw-bold mb-3">Frequently Asked:</h4>
                <div class="ps-4">
                  <div class="faq-item">
                    <p><strong>Q1:</strong> Can I sponsor someone if I live outside of Canada?</p>
                    <p><strong>A:</strong> No, you must live in Canada to sponsor a relative. However, there are
                      exceptions for Canadian citizens who are living abroad and have a clear intent to return to
                      Canada.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q2:</strong> How long does the Family Sponsorship process take?</p>
                    <p><strong>A:</strong> The processing time for family sponsorship applications can vary, but it
                      generally takes 12 to 24 months. Processing times may vary depending on the specific relationship
                      and whether the application is complete.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q3:</strong> Can I sponsor my siblings or other family members?</p>
                    <p><strong>A:</strong> The Family Sponsorship program is generally limited to spouses, common-law
                      partners, dependent children, parents, and grandparents. Other family members, such as siblings,
                      cannot be sponsored under this program, but there may be other immigration pathways for them.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q4:</strong> What if the sponsored person is already in Canada?</p>
                    <p><strong>A:</strong> If the sponsored person is already in Canada, they may be eligible for inland
                      sponsorship. This allows them to stay in Canada while their sponsorship application is being
                      processed.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q5:</strong> Can the sponsor be responsible for providing financial support indefinitely?
                    </p>
                    <p><strong>A:</strong> The sponsor’s obligation to financially support the sponsored person
                      typically lasts for 3 years for a spouse, common-law partner, or dependent child, and 10 years or
                      until the person becomes a Canadian citizen for parents or grandparents.</p>
                  </div>
                  <hr class="my-3">
                  <div class="faq-item">
                    <p><strong>Q6:</strong> What happens if the sponsor or the sponsored person’s application is
                      refused?</p>
                    <p><strong>A:</strong> If the application is refused, the sponsor can appeal the decision or
                      reapply, depending on the reason for refusal.</p>
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
          <button id="prevBtn" class="btn rounded-circle shadow-sm nav-btn"><i
              class="bi bi-chevron-left fs-4"></i></button>
          <button id="nextBtn" class="btn rounded-circle shadow-sm nav-btn"><i
              class="bi bi-chevron-right fs-4"></i></button>
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
    // SCRIPT FOR TAB NAVIGATION
    document.addEventListener("DOMContentLoaded", function () {
      const tabs = document.querySelectorAll('#tabMenu .nav-link');
      const tabList = Array.from(tabs);
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');

      function updateButtons() {
        const activeTab = document.querySelector('#tabMenu .nav-link.active');
        const activeIndex = tabList.indexOf(activeTab);
        prevBtn.disabled = activeIndex === 0;
        nextBtn.disabled = activeIndex === tabList.length - 1;
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
