<?php
session_start();
require_once '../config.php'; // Ensure this path is correct

// Security Check: Ensure user is logged in and is an Admin
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    header("Location: ../login.php");
    exit;
}

// Page-specific data
$page_title = "RAIS Admin - My Profile";
$active_page = "profile"; 

// Fetch the currently logged-in admin's data from the database
$admin_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT firstName, lastName, role, email, phone, profileImage, address FROM users WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$dbAdminData = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$dbAdminData) {
    die("Error: Admin profile data could not be found.");
}

// Format the data for the frontend
$adminProfileData = [
    "firstName" => $dbAdminData['firstName'],
    "lastName" => $dbAdminData['lastName'],
    "title" => $dbAdminData['role'],
    "work" => "Works at RAIS", // Static value
    "location" => $dbAdminData['address'] ? 'Lives in ' . htmlspecialchars($dbAdminData['address']) : 'Location not set',
    "email" => $dbAdminData['email'],
    "phone" => $dbAdminData['phone'] ?? 'Phone not set',
    "picture" => $dbAdminData['profileImage'] ? '../' . $dbAdminData['profileImage'] : null,
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img/logoulit.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* This style block ensures the profile picture is always a circle. */
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            /* This is the key property to clip the inner image into a circle */
            overflow: hidden; 
            position: relative;
            background-color: #e9ecef;
            border: 5px solid #fff;
            margin-top: -75px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            /* Flex properties to center the default icon */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Styles for the image tag when it's present */
        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Styles for the default icon when no image is present */
        .profile-picture .bi-person-circle {
            font-size: 8rem; /* Large icon size */
            color: #adb5bd;
        }
    </style>
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
                        <div id="profilePictureContainer" class="profile-picture">
                            <!-- Profile picture or icon will be rendered here by JS -->
                        </div>
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
                            <div id="modalProfilePicturePreviewContainer" class="rounded-circle mb-3" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; border: 2px solid #dee2e6; background-color: #f8f9fa; font-size: 5rem; color: #6c757d; overflow: hidden;">
                                <!-- Profile picture preview or icon will be rendered here by JS -->
                           </div>
                            <div>
                                <label for="profilePictureInput" class="btn btn-primary btn-sm">Upload a Photo</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="inputFirstName" name="firstName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="inputLastName" name="lastName" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="inputTitle" name="title" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="inputWork" class="form-label">Works at</label>
                            <input type="text" class="form-control" id="inputWork" value="RAIS" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="inputLocation" class="form-label">Address</label>
                            <input type="text" class="form-control" id="inputLocation" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputPhone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="inputPhone" name="phone">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>

    <!-- Page-specific script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adminProfile = <?php echo json_encode($adminProfileData); ?>;
            let newPictureFile = null;

            const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));

            function updateProfileDisplay() {
                document.getElementById('profileName').textContent = `${adminProfile.firstName} ${adminProfile.lastName}`;
                document.getElementById('profileTitle').textContent = adminProfile.title;
                document.getElementById('profileWork').innerHTML = `<i class="bi bi-briefcase-fill"></i> ${adminProfile.work}`;
                document.getElementById('profileLocation').innerHTML = `<i class="bi bi-geo-alt-fill"></i> ${adminProfile.location}`;
                document.getElementById('profileEmail').innerHTML = `<i class="bi bi-envelope-fill"></i> ${adminProfile.email}`;
                document.getElementById('profilePhone').innerHTML = `<i class="bi bi-telephone-fill"></i> ${adminProfile.phone}`;
                
                const profilePictureContainer = document.getElementById('profilePictureContainer');
                profilePictureContainer.innerHTML = ''; // Clear previous content
                if (adminProfile.picture) {
                    profilePictureContainer.innerHTML = `<img src="${adminProfile.picture}" alt="Profile Picture">`;
                } else {
                    profilePictureContainer.innerHTML = `<i class="bi bi-person-circle"></i>`;
                }
            }

            document.getElementById('editProfileModal').addEventListener('show.bs.modal', function() {
                document.getElementById('inputFirstName').value = adminProfile.firstName;
                document.getElementById('inputLastName').value = adminProfile.lastName;
                document.getElementById('inputTitle').value = adminProfile.title;
                document.getElementById('inputLocation').value = adminProfile.location.startsWith('Lives in') ? adminProfile.location.replace('Lives in ', '') : '';
                document.getElementById('inputEmail').value = adminProfile.email;
                document.getElementById('inputPhone').value = adminProfile.phone.startsWith('Phone not set') ? '' : adminProfile.phone;
                
                const modalPreviewContainer = document.getElementById('modalProfilePicturePreviewContainer');
                modalPreviewContainer.innerHTML = ''; // Clear previous
                if (adminProfile.picture) {
                     modalPreviewContainer.innerHTML = `<img src="${adminProfile.picture}" alt="Profile Preview" style="width: 100%; height: 100%; object-fit: cover;">`;
                } else {
                     modalPreviewContainer.innerHTML = '<i class="bi bi-person-circle"></i>';
                }

                newPictureFile = null;
                document.getElementById('profilePictureInput').value = '';
            });

            document.getElementById('profilePictureInput').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    newPictureFile = file;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const modalPreviewContainer = document.getElementById('modalProfilePicturePreviewContainer');
                        modalPreviewContainer.innerHTML = `<img src="${e.target.result}" alt="Profile Preview" style="width: 100%; height: 100%; object-fit: cover;">`;
                    }
                    reader.readAsDataURL(file);
                }
            });

            document.getElementById('saveProfileChanges').addEventListener('click', async function() {
                const form = document.getElementById('editProfileForm');
                const formData = new FormData(form);
                formData.append('action', 'update_profile');

                if (newPictureFile) {
                    formData.append('profileImage', newPictureFile);
                }
                
                try {
                    const response = await fetch('profile_handler.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();

                    if (result.status === 'success') {
                        editProfileModal.hide();
                        alert('Profile updated successfully!');
                        window.location.reload();
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error submitting form:', error);
                    alert('An unexpected error occurred. Please try again.');
                }
            });

            updateProfileDisplay();
        });
    </script>
</body>
</html>
