<?php
// Page title
$page_title = "Login - RAIS Create";
// Start the session to access session variables
session_start();
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
      filter: blur(2px) brightness(0.9); /* Adds a subtle blur and darkens the video */
    }

    /* --- Keyframe Animations --- */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
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

    /* --- Main Login Card Style --- */
    .login-card {
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
      color: #ddd; /* Lighter placeholder text */
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.3);
      box-shadow: 0 0 0 0.25rem rgba(12, 71, 12, 0.5); /* Green glow effect */
      border-color: #106210;
      outline: none;
      color: white;
    }

    /* --- Button Styles --- */
    .btn-login {
      background-color: #0C470C;
      color: white;
      border-radius: 10px;
      height: 45px;
      transition: all 0.3s ease;
      border: none;
    }

    .btn-login:hover {
      background-color: #106210; /* A slightly lighter green */
      transform: translateY(-3px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .btn-login:active {
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
    .form-links a {
      color: #f0f0f0;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .form-links a:hover {
      color: #fff;
      text-decoration: underline !important;
    }

    /* --- Logo Style & Animation --- */
    .logo-img {
      max-width: 80%;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Bouncy transition */
      filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
    }

    .logo-img:hover {
      transform: scale(1.05) rotate(2deg);
    }
  </style>
</head>

<body class="d-flex flex-column align-items-center justify-content-center vh-100 overflow-hidden">

  <video autoplay muted loop id="bg-video">
    <source src="vids/niagara22.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <div class="card text-white w-100 login-card">
    <div class="card-body p-5">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="login-form">
            <h4 class="fw-bold mb-3 fs-3">Login to your Account</h4>
            <p class="mb-4 fs-6">Welcome! Please enter your email address</p>
            
            <?php
            // Check if there is a login error message in the session
            if (isset($_SESSION['login_error'])) {
                // Display the error message in a Bootstrap alert
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
                // Unset the session variable so the message doesn't show again
                unset($_SESSION['login_error']);
            }
            ?>

            <form method="post" action="signin.php">
                <input type="email"  name="email" class="form-control mb-3" placeholder="Email" required />
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required/>
                
                <button class="btn w-100 fw-bold btn-login" type="submit" name="login">Login</button>

                <div class="d-flex justify-content-between mt-3 form-links">
                  <a href="register.php" class="fs-6">Don't have an account?</a>
                  <a href="forgot-pass.php" class="fs-6">Forgot Password?</a>
                </div>
            </form>
          </div>
        </div>
        
        <div class="col-md-6 text-center d-none d-md-block">
            <img src="img/logo.png" alt="RAIS Logo" class="img-fluid logo-img" />
        </div>
      </div>
    </div>
  </div>

  <a href="index.php" class="btn mt-4 text-white fs-6 btn-home">Home</a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
