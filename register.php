<?php
// Page title
$page_title = "Register - RAIS Create";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="img/logoulit.png" />
  <style>
    /* --- General & Background Styles --- */
    body {
      font-family: 'Poppins', sans-serif;
      animation: fadeIn 1s ease-in-out;
    }

    #bg-video {
      position: fixed;
      top: 0;
      left: 0;
      min-width: 100%;
      min-height: 100%;
      object-fit: cover;
      z-index: -1;
      filter: blur(2px) brightness(0.9);
    }

    /* --- Keyframe Animations --- */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes popIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    /* --- Main Register Card Style --- */
    .register-card {
      background: rgba(0, 4, 4, 0.25);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-radius: 20px;
      max-width: 1000px;
      z-index: 1;
      border: 1px solid rgba(255, 255, 255, 0.18);
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
      animation: popIn 0.6s ease-out forwards;
      opacity: 0; /* Initially hidden for animation */
      animation-delay: 0.3s;
    }

    /* --- Form Input Styles --- */
    .form-control {
      background-color: rgba(255, 255, 255, 0.2);
      border: 1px solid transparent;
      color: white;
      height: 45px;
      border-radius: 10px;
      padding-left: 15px;
      transition: all 0.3s ease;
    }

    .form-control::placeholder {
      color: #ddd;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.3);
      box-shadow: 0 0 0 0.25rem rgba(12, 71, 12, 0.5); /* Green glow effect */
      border-color: #106210;
      outline: none;
      color: white;
    }
    
    /* --- Custom Checkbox Style --- */
    .form-check-input {
      background-color: rgba(255, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.3);
      transition: all 0.3s ease;
    }
    
    .form-check-input:checked {
        background-color: #0C470C;
        border-color: #106210;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(12, 71, 12, 0.5);
    }
    
    .form-check-label {
        cursor: pointer;
    }

    /* --- Button Styles --- */
    .btn-register {
      background-color: #0C470C;
      color: white;
      border-radius: 10px;
      height: 45px;
      transition: all 0.3s ease;
      border: none;
    }

    .btn-register:hover {
      background-color: #106210;
      transform: translateY(-3px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .btn-register:active {
      transform: translateY(0);
      box-shadow: none;
    }

    .btn-home {
      background-color: #0C470C;
      padding: 7px 25px;
      border-radius: 30px;
      z-index: 1;
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-home:hover {
      background-color: #106210;
      transform: scale(1.1);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* --- Link Styles --- */
    .register-form a {
      color: #f0f0f0;
      transition: all 0.3s ease;
    }

    .register-form a:hover {
      color: #fff;
    }

    /* --- Logo Style & Animation --- */
    .logo-img {
      max-width: 80%;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
    }

    .logo-img:hover {
      transform: scale(1.05) rotate(-2deg); /* Rotates the other way */
    }
  </style>
</head>

<body class="bg-dark">

  <video autoplay muted loop playsinline id="bg-video">
    <source src="vids/canadaaa.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100 p-3">
    <div class="card text-white w-100 register-card">
      <div class="card-body p-5">
        <div class="row align-items-center">
          <div class="col-md-6 text-center mb-4 mb-md-0 d-none d-md-block">
            <img src="img/logo.png" alt="RAIS Logo" class="img-fluid logo-img" />
          </div>
          <div class="col-md-6 register-form">
            <h4 class="fw-bold fs-3 mb-2">Register Now</h4>
            <p class="mb-4 fs-6">Please enter the following information</p>

            <div class="row">
              <div class="col-md-6">
                <form method="post" action="signup.php">
                <input type="text" name="fName"class="form-control mb-3" placeholder="First Name" required/>
              </div>
              <div class="col-md-6">
                <input type="text"  name="lName" class="form-control mb-3" placeholder="Last Name" required/>
              </div>
            </div>

            <input type="text"  name="address" class="form-control mb-3" placeholder="Address" required/>
            <input type="text"  name="phone" class="form-control mb-3" placeholder="Phone Number" required />
            <input type="email"  name="email"class="form-control mb-3" placeholder="Email" required/>
            <input type="password"  name="password" class="form-control mb-3" placeholder="Password" required />
            
            
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="termsCheck">
              <label class="form-check-label" for="termsCheck">I agree to the Terms & Conditions</label>
            </div>
            
            <button class="btn w-100 fw-bold btn-register" type="submit" name="create">Create Account</button>
            </form>
            <div class="mt-3 text-center">
              <a href="login.php" class="text-white text-decoration-none fs-6">Already have an account? Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <a href="index.php" class="btn mt-4 text-white fs-6 btn-home">Home</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
