<?php
// Page title
$page_title = "Application Form";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="icon" href="img/logoulit.png">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    html {
      min-height: 100%;
    }
    body {
      font-family: 'Open Sans', sans-serif;
      background-image: url('img/logoulit.png');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      color: #333;
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-size: 16px;
    }

    .body-wrapper {
        background-color: rgba(247, 249, 249, 0.9);
        padding: 2rem;
        flex-grow: 1;
        position: relative;
    }

    .header-bg {
      background-color: #8b233a;
    }

    .header-bg span {
      font-family: 'Poppins', sans-serif;
      font-size: 2.25rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      text-align: center;
    }

    .form-section {
      border: 1px solid #e2e8f0;
      border-radius: 0.5rem;
      padding: 2rem;
      background-color: #f8fafc;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .form-section .form-label {
      font-family: 'Poppins', sans-serif;
      font-size: 1.25rem;
      font-weight: 600;
      color: #8b233a;
      margin-bottom: 0.75rem;
    }

    .form-control,
    .form-select {
      border-radius: 0.375rem;
      border: 1px solid #d1d5db;
      padding: 0.75rem 1rem;
      font-size: 1rem;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 2px #a9aaff;
    }

    .btn-custom {
      background-color: #8b233a;
      color: #fff;
      border: none;
      border-radius: 2rem;
      padding: 0.75rem 2rem;
      transition: background-color 0.3s ease, transform 0.3s ease;
      font-size: 1.1rem;
      font-weight: 600;
    }

    .btn-custom:hover {
      background-color: #a62b42;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-back {
      position: absolute;
      top: 2.5rem;
      left: 2.5rem;
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
      background-color: #023621;
      transform: scale(1.1);
    }

    .btn-back i {
      font-size: 1.2rem;
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

    .required-indicator {
        color: #dc3545;
        font-weight: bold;
    }
    
    .intro-text-container {
        margin-bottom: 2.5rem;
    }

    .intro-text {
        font-size: 1.4rem;
        line-height: 1.8;
        color: #3d4757;
    }
    
    .required-note {
        font-style: italic;
        color: #6c757d;
        font-size: 1rem;
    }

    .form-check {
      margin-bottom: 0.75rem;
    }

    .form-check-label {
        font-size: 1.1rem;
        padding-left: 0.5rem;
    }

    .form-check-input {
        width: 1.25em;
        height: 1.25em;
    }

    @media (max-width: 767.98px) {
      .header-bg span {
        font-size: 1.5rem;
      }
      .header-bg {
        padding-left: 1rem;
        padding-right: 1rem;
      }
    }
  </style>
</head>

<body>
<div class="body-wrapper">
  <a href="index.php" class="btn-back" aria-label="Go Back">
    <i class="fas fa-arrow-left"></i>
  </a>
  <div class="text-center mb-3">
    <img src="img/logoulit.png" alt="Company Logo" class="d-inline-block" style="width: 120px; height: 120px;">
  </div>

  <div class="container bg-white rounded-3 shadow-lg overflow-hidden my-5 p-0">

    <div class="header-bg text-white py-4 d-flex justify-content-center">
      <span>Canada? Interest Check</span>
    </div>

    <form class="p-4 p-md-5" id="interestForm">

      <div class="intro-text-container">
        <p class="intro-text">We are licensed Canadian immigration firm with a main office based in Vancouver Island British Columbia, Canada. We provide consultancy visas: temporary resident visa, family sponsorship, caregiver pathway, and LMIA application.</p>
        <p class="intro-text">Since 2012, we have helped many people with different nationalities to successfully move to Canada for better opportunities and brighter futures. Similarly, supporting our clients and encouraging them in times of doubt have enabled us to boost the quality of our services even further.</p>
      </div>
      
      <p class="required-note mb-4">* Indicates required question</p>

      <div class="form-section mb-4">
        <label for="email" class="form-label">Email <span class="required-indicator">*</span></label>
        <input type="email" id="email" name="email" placeholder="Your email" class="form-control" required>
      </div>

      <div class="form-section mb-4">
        <label for="fullName" class="form-label">Name (LAST NAME, First Name, Middle Initial) <span class="required-indicator">*</span></label>
        <input type="text" id="fullName" name="fullName" placeholder="Your answer" class="form-control" required>
      </div>

      <div class="form-section mb-4">
        <label for="phone" class="form-label">Phone Number (09XXXXXXXX) <span class="required-indicator">*</span></label>
        <input type="tel" id="phone" name="phone" placeholder="Your answer" class="form-control" required>
      </div>

      <div class="form-section mb-4">
        <label for="address" class="form-label">Address <span class="required-indicator">*</span></label>
        <input type="text" id="address" name="address" placeholder="Your answer" class="form-control" required>
      </div>

      <div class="form-section mb-4">
        <label class="form-label d-block">Interest Pathway <span class="required-indicator">*</span></label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Student Pathway" id="studentPathway" name="interestPathway[]">
          <label class="form-check-label" for="studentPathway">Student Pathway</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Temporary Foreign Worker Program" id="tfwProgram" name="interestPathway[]">
          <label class="form-check-label" for="tfwProgram">Temporary Foreign Worker Program</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Tourist/ Visitor Visa" id="touristVisa" name="interestPathway[]">
          <label class="form-check-label" for="touristVisa">Tourist/ Visitor Visa</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Caregiver Pathway" id="caregiverPathway" name="interestPathway[]">
          <label class="form-check-label" for="caregiverPathway">Caregiver Pathway</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Family Sponsorship" id="familySponsorship" name="interestPathway[]">
            <label class="form-check-label" for="familySponsorship">Family Sponsorship</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="LMIA Application" id="lmiaApplication" name="interestPathway[]">
            <label class="form-check-label" for="lmiaApplication">LMIA Application</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Express Entry" id="expressEntry" name="interestPathway[]">
            <label class="form-check-label" for="expressEntry">Express Entry</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Home & Inst-Caregiver Services Profile Creation" id="caregiverProfile" name="interestPathway[]">
            <label class="form-check-label" for="caregiverProfile">Home & Inst-Caregiver Services Profile Creation</label>
        </div>
      </div>

      <div class="form-section mb-4">
        <label class="form-label d-block">Where did you find us? <span class="required-indicator">*</span></label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Facebook" id="findUsFacebook" name="findUs[]">
          <label class="form-check-label" for="findUsFacebook">Facebook</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Tiktok" id="findUsTiktok" name="findUs[]">
          <label class="form-check-label" for="findUsTiktok">Tiktok</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Instagram" id="findUsInstagram" name="findUs[]">
          <label class="form-check-label" for="findUsInstagram">Instagram</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="Linkedin" id="findUsLinkedin" name="findUs[]">
          <label class="form-check-label" for="findUsLinkedin">Linkedin</label>
        </div>
      </div>

      <div class="form-section mb-4">
        <label for="facebookLink" class="form-label">Facebook Account Link <span class="required-indicator">*</span></label>
        <input type="url" id="facebookLink" name="facebookLink" placeholder="Your answer" class="form-control" required>
      </div>

      <div class="d-flex justify-content-center align-items-center gap-3 mt-5">
        <button type="button" class="btn btn-custom" id="submitBtn">
          Submit
        </button>
      </div>

    </form>
  </div>
</div>

<!-- Validation Alert Modal -->
<div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="validationModalLabel">Incomplete Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="validationModalBody">
        <!-- Error message will be inserted here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<div id="footer-placeholder">
    <?php include 'footer.php'; ?>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
        const validationModalTitle = document.getElementById('validationModalLabel');
        const validationModalBody = document.getElementById('validationModalBody');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('interestForm');

        function showValidationModal(title, body) {
            validationModalTitle.textContent = title;
            validationModalBody.innerHTML = body; // Use innerHTML to render list items
            validationModal.show();
        }

        submitBtn.addEventListener('click', () => {
            const requiredInputs = form.querySelectorAll('input[required]');
            let unfilledFields = [];

            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    const label = form.querySelector(`label[for="${input.id}"]`);
                    unfilledFields.push(label ? label.innerText.replace('*', '').trim() : 'A required field');
                }
            });
            
            const interestPathwayChecked = form.querySelectorAll('input[name="interestPathway[]"]:checked').length > 0;
            if (!interestPathwayChecked) {
                unfilledFields.push('Interest Pathway');
            }

            const findUsChecked = form.querySelectorAll('input[name="findUs[]"]:checked').length > 0;
            if (!findUsChecked) {
                unfilledFields.push('Where did you find us?');
            }

            if (unfilledFields.length > 0) {
                let errorList = '<ul>';
                unfilledFields.forEach(field => {
                    errorList += `<li>${field}</li>`;
                });
                errorList += '</ul>';
                showValidationModal('Missing Information', 'Please fill out the following required fields:<br>' + errorList);
            } else {
                console.log('Form submitted!');
                // You can add your form submission logic here, e.g., using fetch() or form.submit()
                // form.submit(); 
                alert('Form submitted successfully!'); // Placeholder for actual submission
            }
        });
    });
  </script>
</body>

</html>

