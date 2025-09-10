<?php
// Start the session if it's not already started to access session variables
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="style.css">
<!-- Add custom styles for the modal in dark mode -->
<style>
    body.dark-mode .modal-content {
        background-color: #212529;
        color: #fff;
    }
    body.dark-mode .modal-header .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>
<header class="header">
    <div class="header-brand d-flex align-items-center">
        <img src="../img/logoulit.png" alt="RAIS Logo Light" class="header-logo-img light-mode-logo">
        <img src="../img/logowhite.png" alt="RAIS Logo Dark" class="header-logo-img dark-mode-logo">
        <span class="header-title d-none d-sm-block">Roman & Associates Immigration Services</span>
    </div>
    <div class="user-status d-flex align-items-center gap-2">
        <div class="theme-switch-wrapper">
            <i class="bi bi-sun-fill"></i>
            <label class="theme-switch" for="theme-checkbox">
                <input type="checkbox" id="theme-checkbox" />
                <div class="slider round"></div>
            </label>
            <i class="bi bi-moon-fill"></i>
        </div>
        <span class="badge">
            ADMIN_<?php 
                // Check if the user's first name is stored in the session
                if (isset($_SESSION['firstName'])) {
                    // Display the first name, using htmlspecialchars for security
                    echo htmlspecialchars($_SESSION['firstName']);
                } else {
                    // If the name isn't set, display a default value
                    echo 'User';
                }
            ?>
        </span>
        <!-- Button to trigger logout modal -->
        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
            <i class="bi bi-power"></i>
        </button>
    </div>
</header>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutConfirmModalLabel">Confirm Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to log out?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="../logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

