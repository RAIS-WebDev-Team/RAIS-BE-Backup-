<?php
// Page-specific data
$page_title = "RAIS Admin - Profile";
$active_page = "profile"; // For highlighting the active link in the sidebar

// In a real application, you would fetch this data from the database
// based on the currently logged-in user's session.
$adminProfileData = [
    "firstName" => "John",
    "lastName" => "Doe",
    "title" => "Super Admin",
    "work" => "Works at RAIS",
    "location" => "Lives in Toronto, Canada",
    "email" => "john.doe@rais.com",
    "phone" => "+1 234 567 8900",
    "picture" => "https://placehold.co/150/004d40/FFFFFF?text=JD",
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img/logoulit.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="style.css"> <!-- Assuming a shared style.css -->
</head>

<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php'; ?>

        <div class="content-area">
            <?php require_once 'header.php'; ?>

            <main class="main-content">
                <div class="profile-header">
                    <div class="cover-photo"></div>
                    <div class="profile-info">
                        <img src="" alt="Profile Picture" class="profile-picture" id="profilePicture">
                        <!-- Hidden input is now inside the modal, but this works fine -->
                        <input type="file" id="profilePictureInput" style="display: none;" accept="image/*">
                        <div class="profile-name">
                            <h2 id="profileName"></h2>
                            <p id="profileTitle"></p>
                        </div>
                        <button class="btn btn-outline-secondary edit-profile-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="bi bi-pencil-fill"></i> Edit Profile</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="content-card">
                            <h5>About</h5>
                            <ul class="list-unstyled info-list mt-3">
                                <li id="profileWork"></li>
                                <li id="profileLocation"></li>
                                <li id="profileEmail"></li>
                                <li id="profilePhone"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="content-card">
                            <h5>Activity Feed</h5>
                            <p>Recent activities and updates will be shown here.</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="mb-4 text-center">
                            <img src="" alt="Profile Preview" id="modalProfilePicturePreview" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                            <div>
                                <!-- The actual file input is linked to this button -->
                                <label for="profilePictureInput" class="btn btn-primary btn-sm">Upload a Photo</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="inputFirstName">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="inputLastName">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="inputTitle">
                        </div>
                        <div class="mb-3">
                            <label for="inputWork" class="form-label">Works at</label>
                            <input type="text" class="form-control" id="inputWork">
                        </div>
                        <div class="mb-3">
                            <label for="inputLocation" class="form-label">Location</label>
                            <input type="text" class="form-control" id="inputLocation">
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail">
                        </div>
                        <div class="mb-3">
                            <label for="inputPhone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="inputPhone">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveProfileChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Bundles -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="togglemodeScript.js"></script> <!-- Handles the theme switcher -->

    <!-- Page-specific script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- DATA INJECTION & SETUP ---
            let adminProfile = <?php echo json_encode($adminProfileData, JSON_PRETTY_PRINT); ?>;
            let newPictureDataUrl = null;

            // --- ELEMENTS ---
            const profileName = document.getElementById('profileName');
            const profileTitle = document.getElementById('profileTitle');
            const profileWork = document.getElementById('profileWork');
            const profileLocation = document.getElementById('profileLocation');
            const profileEmail = document.getElementById('profileEmail');
            const profilePhone = document.getElementById('profilePhone');
            const profilePicture = document.getElementById('profilePicture');
            const profilePictureInput = document.getElementById('profilePictureInput');
            const modalProfilePicturePreview = document.getElementById('modalProfilePicturePreview');
            const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            const saveProfileChangesBtn = document.getElementById('saveProfileChanges');

            // --- FUNCTIONS ---
            function updateProfileDisplay() {
                profileName.textContent = `${adminProfile.firstName} ${adminProfile.lastName}`;
                profileTitle.textContent = adminProfile.title;
                profileWork.innerHTML = `<i class="bi bi-briefcase-fill"></i> ${adminProfile.work}`;
                profileLocation.innerHTML = `<i class="bi bi-geo-alt-fill"></i> ${adminProfile.location}`;
                profileEmail.innerHTML = `<i class="bi bi-envelope-fill"></i> ${adminProfile.email}`;
                profilePhone.innerHTML = `<i class="bi bi-telephone-fill"></i> ${adminProfile.phone}`;
                profilePicture.src = adminProfile.picture;
            }

            // --- EVENT LISTENERS ---
            document.getElementById('editProfileModal').addEventListener('show.bs.modal', function() {
                document.getElementById('inputFirstName').value = adminProfile.firstName;
                document.getElementById('inputLastName').value = adminProfile.lastName;
                document.getElementById('inputTitle').value = adminProfile.title;
                document.getElementById('inputWork').value = adminProfile.work.replace('Works at ', '');
                document.getElementById('inputLocation').value = adminProfile.location.replace('Lives in ', '');
                document.getElementById('inputEmail').value = adminProfile.email;
                document.getElementById('inputPhone').value = adminProfile.phone;
                modalProfilePicturePreview.src = adminProfile.picture;
                newPictureDataUrl = null;
            });

            profilePictureInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        newPictureDataUrl = e.target.result;
                        modalProfilePicturePreview.src = newPictureDataUrl;
                    }
                    reader.readAsDataURL(file);
                }
            });

            saveProfileChangesBtn.addEventListener('click', function() {
                adminProfile.firstName = document.getElementById('inputFirstName').value;
                adminProfile.lastName = document.getElementById('inputLastName').value;
                adminProfile.title = document.getElementById('inputTitle').value;
                adminProfile.work = 'Works at ' + document.getElementById('inputWork').value;
                adminProfile.location = 'Lives in ' + document.getElementById('inputLocation').value;
                adminProfile.email = document.getElementById('inputEmail').value;
                adminProfile.phone = document.getElementById('inputPhone').value;
                if (newPictureDataUrl) {
                    adminProfile.picture = newPictureDataUrl;
                }
                updateProfileDisplay();
                editProfileModal.hide();
            });

            // --- INITIAL LOAD ---
            updateProfileDisplay();
        });
    </script>
</body>
</html>