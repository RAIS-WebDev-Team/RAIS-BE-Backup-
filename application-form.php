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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    html {
      min-height: 100%;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('img/logoulit.png');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      color: #333;
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
      font-size: 1.5rem;
      letter-spacing: 0.2em;
    }

    .form-section {
      border: 1px solid #e2e8f0;
      border-radius: 0.5rem;
      padding: 1.5rem;
      background-color: #f8fafc;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .form-control,
    .form-select {
      border-radius: 0.375rem;
      border: 1px solid #d1d5db;
      padding: 0.5rem 0.75rem;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 1px #6366f1;
    }

    .btn-custom {
      background-color: #8b233a;
      color: #fff;
      border: none;
      border-radius: 2rem;
      padding: 0.75rem 2rem;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #a62b42;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-cancel {
        background-color: transparent;
        color: #8b233a;
        border: 2px solid #8b233a;
    }

    .btn-cancel:hover {
        background-color: #8b233a;
        color: #fff;
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

    .highlight {
      color: #3BA43B;
      font-weight: bold;
      text-decoration: underline;
      text-underline-offset: 8px;
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

  <div class="container bg-white rounded-lg shadow-lg overflow-hidden my-5">

    <div class="header-bg text-white py-4 d-flex justify-content-center rounded-top-2">
      <span class="text-sm font-weight-bold text-uppercase tracking-widest">Application Form</span>
    </div>

    <form class="p-4 p-md-5" id="applicationForm">

      <div class="form-section mb-4">
        <h2 class="h5 mb-4 text-secondary">Employer Information</h2>
        <div class="row g-3">
          <div class="col-12 col-md-6 col-lg-4">
            <label for="companyName" class="form-label text-secondary">Company Name</label>
            <input type="text" id="companyName" name="companyName" placeholder="Company Name" class="form-control"
              list="companyNames" required>
            <datalist id="companyNames">
              <option value="Tech Solutions Inc.">
              <option value="Global Innovations Ltd.">
              <option value="Creative Marketing Agency">
            </datalist>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="businessNumber" class="form-label text-secondary">Business Number (BN)</label>
            <input type="text" id="businessNumber" name="businessNumber" placeholder="Business Number (BN)"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="passportContactName" class="form-label text-secondary">Passport Contact Name</label>
            <input type="text" id="passportContactName" name="passportContactName" placeholder="Passport Contact Name"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="province" class="form-label text-secondary">Province</label>
            <select id="province" name="province" class="form-select" required>
              <option value="" selected>Select Province</option>
              <option>Ontario</option>
              <option>Quebec</option>
              <option>British Columbia</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="streetAddress" class="form-label text-secondary">Street Address</label>
            <input type="text" id="streetAddress" name="streetAddress" placeholder="Street Address"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="economicAddress" class="form-label text-secondary">Economic Address</label>
            <input type="text" id="economicAddress" name="economicAddress" placeholder="Economic Address"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="businessUnit" class="form-label text-secondary">Business Unit #</label>
            <input type="text" id="businessUnit" name="businessUnit" placeholder="Business Unit #" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="addressLine2" class="form-label text-secondary">Address Line 2</label>
            <input type="text" id="addressLine2" name="addressLine2" placeholder="Address Line 2" class="form-control">
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="economicLocation" class="form-label text-secondary">Economic Location</label>
            <input type="text" id="economicLocation" name="economicLocation" placeholder="Economic Location"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="state" class="form-label text-secondary">State</label>
            <select id="state" name="state" class="form-select" required>
              <option value="" selected>State</option>
              <option>California</option>
              <option>New York</option>
              <option>Texas</option>
            </select>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="city" class="form-label text-secondary">City</label>
            <input type="text" id="city" name="city" placeholder="City" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="zipCode" class="form-label text-secondary">ZIP Code</label>
            <input type="text" id="zipCode" name="zipCode" placeholder="ZIP Code" class="form-control" required>
          </div>
        </div>
      </div>

      <div class="form-section mb-4">
        <h2 class="h5 mb-4 text-secondary">Passport Information</h2>
        <div class="row g-3">
          <div class="col-12 col-md-6 col-lg-4">
            <label for="passportNumber" class="form-label text-secondary">Passport Number</label>
            <input type="text" id="passportNumber" name="passportNumber" placeholder="Passport Number"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="countryOfIssue" class="form-label text-secondary">Country of Issue</label>
            <input type="text" id="countryOfIssue" name="countryOfIssue" placeholder="Country of Issue"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="passportExpiry" class="form-label text-secondary">Passport Expiry</label>
            <input type="date" id="passportExpiry" name="passportExpiry" class="form-control" required>
          </div>
        </div>
      </div>

      <div class="form-section mb-4">
        <h2 class="h5 mb-4 text-secondary">Job Offer Details</h2>
        <div class="row g-3">
          <div class="col-12 col-md-6 col-lg-4">
            <label for="jobTitle" class="form-label text-secondary">Job Title</label>
            <input type="text" id="jobTitle" name="jobTitle" placeholder="Job Title" class="form-control"
              list="jobTitles" required>
            <datalist id="jobTitles">
              <option value="Software Engineer">
              <option value="Project Manager">
              <option value="Data Analyst">
            </datalist>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="numberOfPositions" class="form-label text-secondary">Number of Positions Required</label>
            <input type="number" id="numberOfPositions" name="numberOfPositions"
              placeholder="Number of Positions Required" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="jobLocation" class="form-label text-secondary">Job Location</label>
            <input type="text" id="jobLocation" name="jobLocation" placeholder="Job Location" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="recruitmentBank" class="form-label text-secondary">Recruitment Bank</label>
            <input type="text" id="recruitmentBank" name="recruitmentBank" placeholder="Recruitment Bank"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="economicHardship" class="form-label text-secondary">Economic Hardship</label>
            <input type="text" id="economicHardship" name="economicHardship" placeholder="Economic Hardship"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="labourMarket" class="form-label text-secondary">Labour Market</label>
            <input type="text" id="labourMarket" name="labourMarket" placeholder="Labour Market" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="newJobBank" class="form-label text-secondary">New Job Bank</label>
            <input type="text" id="newJobBank" name="newJobBank" placeholder="New Job Bank" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="hourlyWage" class="form-label text-secondary">Hourly Wage/Salary</label>
            <input type="text" id="hourlyWage" name="hourlyWage" placeholder="Hourly Wage/Salary" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="whatIsThis" class="form-label text-secondary">What is this</label>
            <input type="text" id="whatIsThis" name="whatIsThis" placeholder="What is this" class="form-control" required>
          </div>
        </div>
      </div>

      <div class="form-section mb-4">
        <h2 class="h5 mb-4 text-secondary">Temporary Foreign Worker (TFW) Information</h2>
        <div class="row g-3">
          <div class="col-12 col-md-6 col-lg-4">
            <label for="applicantForeignWorker" class="form-label text-secondary">Applicant Foreign Worker</label>
            <input type="text" id="applicantForeignWorker" name="applicantForeignWorker"
              placeholder="Applicant Foreign Worker" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="countryOfCitizenship" class="form-label text-secondary">Country of Citizenship</label>
            <input type="text" id="countryOfCitizenship" name="countryOfCitizenship"
              placeholder="Country of Citizenship" class="form-control" list="countries" required>
            <datalist id="countries">
              <option value="Canada">
              <option value="United States">
              <option value="Mexico">
            </datalist>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="anticipatedArrivalDate" class="form-label text-secondary">Anticipated Arrival Date</label>
            <input type="date" id="anticipatedArrivalDate" name="anticipatedArrivalDate" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="jobExperience" class="form-label text-secondary">Job Experience & Qualification</label>
            <input type="text" id="jobExperience" name="jobExperience" placeholder="Job Experience & Qualification"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="otherDocuments" class="form-label text-secondary">Other Documents (Certificates, etc.)</label>
            <input type="text" id="otherDocuments" name="otherDocuments"
              placeholder="Other Documents (Certificates, etc.)" class="form-control" required>
          </div>
        </div>
      </div>

      <div class="form-section mb-4">
        <h2 class="h5 mb-4 text-secondary">Business Information</h2>
        <div class="row g-3">
          <div class="col-12 col-md-6 col-lg-4">
            <label for="descriptionOfBusinessOperations" class="form-label text-secondary">Description of Business
              Operations</label>
            <input type="text" id="descriptionOfBusinessOperations" name="descriptionOfBusinessOperations"
              placeholder="Description of Business Operations" class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="numberOfEmployees" class="form-label text-secondary">Number of Employees</label>
            <input type="number" id="numberOfEmployees" name="numberOfEmployees" placeholder="Number of Employees"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <label for="annualRevenue" class="form-label text-secondary">Annual Revenue</label>
            <input type="text" id="annualRevenue" name="annualRevenue" placeholder="Annual Revenue"
              class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="businessRegistration" class="form-label text-secondary">Business Registration and Financial
              Documents</label>
            <input type="text" id="businessRegistration" name="businessRegistration"
              placeholder="Business Registration and Financial Documents" class="form-control" required>
          </div>
        </div>
      </div>

      <div class="form-section mb-4">
        <h2 class="h5 mb-4 text-secondary">Declaration</h2>
        <div class="form-text text-secondary mb-3">
          I certify that all the information provided is accurate, confidential, and will be handled according to
          established guidelines. I also acknowledge that the admin ensures these standards are upheld.
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="agree" name="agree">
          <label class="form-check-label text-secondary" for="agree">I agree with the terms stated above.</label>
        </div>
      </div>

      <div class="d-flex justify-content-center align-items-center gap-3 mt-5">
        <button type="button" class="btn btn-custom btn-cancel" id="cancelBtn">
          Cancel Application
        </button>
        <button type="button" class="btn btn-custom" id="saveBtn">
          Save Application
        </button>
      </div>

    </form>
  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="confirmationModalBody">
        Are you sure you want to proceed?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
      </div>
    </div>
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
        // --- MODAL SCRIPT ---
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
        const modalTitle = document.getElementById('confirmationModalLabel');
        const modalBody = document.getElementById('confirmationModalBody');
        const validationModalTitle = document.getElementById('validationModalLabel');
        const validationModalBody = document.getElementById('validationModalBody');
        const confirmBtn = document.getElementById('confirmBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const form = document.getElementById('applicationForm');

        let confirmAction = null;

        function showConfirmationModal(title, body, onConfirm) {
            modalTitle.textContent = title;
            modalBody.textContent = body;
            confirmAction = onConfirm;
            confirmationModal.show();
        }
        
        function showValidationModal(title, body) {
            validationModalTitle.textContent = title;
            validationModalBody.textContent = body;
            validationModal.show();
        }

        confirmBtn.addEventListener('click', () => {
            if (typeof confirmAction === 'function') {
                confirmAction();
            }
            confirmationModal.hide();
        });

        saveBtn.addEventListener('click', () => {
            const inputs = form.querySelectorAll('input[required], select[required]');
            let allFieldsFilled = true;

            for (const input of inputs) {
                if (!input.value.trim()) {
                    allFieldsFilled = false;
                    break;
                }
            }

            const agreeCheckbox = document.getElementById('agree');

            if (!allFieldsFilled) {
                showValidationModal('Missing Information', 'Please fill out all the required fields before saving.');
            } else if (!agreeCheckbox.checked) {
                showValidationModal('Terms and Policy', 'You must agree to the terms and policy before saving.');
            } else {
                showConfirmationModal(
                    'Save Application', 
                    'Are you sure you want to save your application?', 
                    () => {
                        console.log('Application saved!');
                        form.submit(); 
                    }
                );
            }
        });

        cancelBtn.addEventListener('click', () => {
            showConfirmationModal(
                'Cancel Application', 
                'Are you sure you want to cancel? All unsaved changes will be lost.', 
                () => {
                    console.log('Application cancelled.');
                    form.reset();
                }
            );
        });
    });
  </script>
</body>

</html>
