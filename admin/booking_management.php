<?php
// admin/booking-management.php

session_start();
include_once '../config.php';

// Check if user is logged in and is an admin.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../login.php");
    exit;
}

// Page-specific data
$page_title = "RAIS Admin - Booking Management";
$active_page = "booking_management";

// --- FETCH ALL CONSULTATION BOOKINGS ---
$consultationBookings = [];
$sql_consultations = "SELECT c.id, u.firstName, u.lastName, u.email, c.consultation_date, c.consultation_time, c.notes, c.status, c.facebook_link
                      FROM consultations c
                      JOIN users u ON c.user_id = u.id
                      ORDER BY c.consultation_date DESC, c.consultation_time DESC";

if ($result_consultations = $conn->query($sql_consultations)) {
    while ($row = $result_consultations->fetch_assoc()) {
        $consultationBookings[] = [
            'id' => 'BK-' . str_pad($row['id'], 3, '0', STR_PAD_LEFT),
            'db_id' => $row['id'],
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'email' => $row['email'],
            'facebookLink' => $row['facebook_link'],
            'service' => '45 Minute Meeting',
            'dateTime' => date('Y-m-d', strtotime($row['consultation_date'])) . ' ' . $row['consultation_time'],
            'status' => $row['status']
        ];
    }
    $result_consultations->free();
}

// --- FETCH PENDING FLIGHT BOOKINGS ---
$flightBookings = [];
$sql_flights = "SELECT f.id, u.firstName, u.lastName, u.email, f.destination, f.departureLocation, f.departure_date
                  FROM flights f
                  JOIN users u ON f.user_id = u.id
                  ORDER BY f.booking_date DESC";

if ($result_flights = $conn->query($sql_flights)) {
    while ($row = $result_flights->fetch_assoc()) {
        $flightBookings[] = [
            'id' => 'FL-' . str_pad($row['id'], 3, '0', STR_PAD_LEFT),
            'db_id' => $row['id'],
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'email' => $row['email'],
            'service' => $row['destination'],
            'departureLocation' => $row['departureLocation'],
            'dateTime' => date('Y-m-d', strtotime($row['departure_date']))
        ];
    }
    $result_flights->free();
}
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img/logoulit.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .nav-tabs-custom .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            color: var(--rais-text-light);
        }
        .nav-tabs-custom .nav-link.active,
        .nav-tabs-custom .nav-item.show .nav-link {
            color: var(--rais-primary-green);
            border-bottom-color: var(--rais-primary-green);
            background-color: transparent;
        }
        body.dark-mode .modal-content { background-color: #1e1e1e; color: #EAEAEA; }
        body.dark-mode .list-group-item { background-color: #2a2a2a; border-color: #3c3c3c; color: #EAEAEA; }
        body.dark-mode .table { color: #EAEAEA; }
        body.dark-mode .table-hover > tbody > tr:hover > td { color: #ffffff !important; background-color: #2a2a2a; }
        body.dark-mode .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        body.dark-mode .nav-tabs-custom .nav-link { color: #aaa; }
        body.dark-mode .nav-tabs-custom .nav-link.active { color: #4db6ac; border-bottom-color: #4db6ac; }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php'; ?>
        <div class="content-area">
            <?php require_once 'header.php'; ?>
            <main class="main-content">
                <h1>Booking Management</h1>

                <!-- Consultation Bookings Card -->
                <div class="content-card mb-4" id="consultationCard">
                    <h2 class="mb-3">Consultation Bookings</h2>
                    <ul class="nav nav-tabs nav-tabs-custom mb-3">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#consult-pending">Pending</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#consult-approved">Approved</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#consult-cancelled">Cancelled</button></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="consult-pending">
                            <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Service</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="consult-pending-tbody"></tbody></table></div>
                        </div>
                        <div class="tab-pane fade" id="consult-approved">
                            <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Service</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="consult-approved-tbody"></tbody></table></div>
                        </div>
                        <div class="tab-pane fade" id="consult-cancelled">
                            <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Service</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="consult-cancelled-tbody"></tbody></table></div>
                        </div>
                    </div>
                </div>

                <!-- Flight Bookings Card -->
                <div class="content-card" id="flightCard">
                    <h2 class="mb-3">Planned Flights</h2>
                    <div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Destination</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="flight-tbody"></tbody></table></div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modals (View Details, Delete Confirmation, Action Confirmation) -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Booking Details</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>First Name:</strong> <span id="modalFirstName"></span></li>
                        <li class="list-group-item"><strong>Last Name:</strong> <span id="modalLastName"></span></li>
                        <li class="list-group-item"><strong>Email:</strong> <span id="modalEmail"></span></li>
                        <li class="list-group-item" id="modalFacebookLinkWrapper" style="display: none;"><strong>Facebook Link:</strong> <a id="modalFacebookLink" href="#" target="_blank" rel="noopener noreferrer">View Profile</a></li>
                        <li class="list-group-item"><strong>Date:</strong> <span id="modalDate"></span></li>
                        <li class="list-group-item" id="modalDepartureLocationWrapper" style="display: none;"><strong>Departure Location:</strong> <span id="modalDepartureLocation"></span></li>
                        <li class="list-group-item"><strong>Destination/Service:</strong> <span id="modalDestination"></span></li>
                    </ul>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="actionConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="actionConfirmTitle"></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body" id="actionConfirmText"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let allConsultations = <?php echo json_encode(array_values($consultationBookings)); ?>;
        let allFlights = <?php echo json_encode(array_values($flightBookings)); ?>;
        
        const detailsModal = new bootstrap.Modal(document.getElementById('viewDetailsModal'));
        const actionConfirmModal = new bootstrap.Modal(document.getElementById('actionConfirmModal'));

        function renderConsultations() {
            const pendingTbody = document.getElementById('consult-pending-tbody');
            const approvedTbody = document.getElementById('consult-approved-tbody');
            const cancelledTbody = document.getElementById('consult-cancelled-tbody');

            [pendingTbody, approvedTbody, cancelledTbody].forEach(tbody => tbody.innerHTML = '');

            allConsultations.forEach(book => {
                let targetTbody;
                let actionsHtml = '';
                const bookingData = htmlEntities(JSON.stringify(book));

                const viewBtn = `<button class="btn btn-sm btn-info view-btn" data-booking='${bookingData}' title="View Details"><i class="bi bi-eye-fill"></i></button>`;
                const deleteBtn = `<button class="btn btn-sm btn-danger delete-btn" data-booking-id="${book.id}" data-booking-name="${book.firstName} ${book.lastName}" title="Delete Booking"><i class="bi bi-trash-fill"></i></button>`;

                switch(book.status) {
                    case 'Pending':
                        targetTbody = pendingTbody;
                        actionsHtml = `
                            <button class="btn btn-sm btn-success approve-btn" data-booking-id="${book.id}" data-booking-name="${book.firstName} ${book.lastName}" title="Approve"><i class="bi bi-check-lg"></i></button>
                            <button class="btn btn-sm btn-warning cancel-btn" data-booking-id="${book.id}" data-booking-name="${book.firstName} ${book.lastName}" title="Cancel"><i class="bi bi-x-lg"></i></button>
                            ${viewBtn} ${deleteBtn}`;
                        break;
                    case 'Approved':
                        targetTbody = approvedTbody;
                        actionsHtml = `<button class="btn btn-sm btn-warning cancel-btn" data-booking-id="${book.id}" data-booking-name="${book.firstName} ${book.lastName}" title="Cancel"><i class="bi bi-x-lg"></i></button> ${viewBtn} ${deleteBtn}`;
                        break;
                    case 'Cancelled':
                        targetTbody = cancelledTbody;
                        actionsHtml = `${viewBtn} ${deleteBtn}`;
                        break;
                }
                
                if (targetTbody) {
                    const row = targetTbody.insertRow();
                    row.innerHTML = `<td>${book.id}</td><td>${book.firstName} ${book.lastName}</td><td>${book.service}</td><td>${book.dateTime}</td><td><div class="d-flex gap-1">${actionsHtml.trim()}</div></td>`;
                }
            });
            
            checkEmptyTables();
        }

        function renderFlights() {
             const tbody = document.getElementById('flight-tbody');
             tbody.innerHTML = '';
             if (allFlights.length === 0) {
                 tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No pending flights.</td></tr>`;
                 return;
             }
             allFlights.forEach(book => {
                 const bookingData = htmlEntities(JSON.stringify(book));
                 const row = tbody.insertRow();
                 row.innerHTML = `
                     <td>${book.id}</td>
                     <td>${book.firstName} ${book.lastName}</td>
                     <td>${book.service}</td>
                     <td>${book.dateTime}</td>
                     <td>
                         <div class="d-flex gap-1">
                             <button class="btn btn-sm btn-info view-btn" data-booking='${bookingData}' title="View Details"><i class="bi bi-eye-fill"></i></button>
                             <button class="btn btn-sm btn-danger delete-btn" data-booking-id="${book.id}" data-booking-name="${book.firstName} ${book.lastName}" title="Delete Booking"><i class="bi bi-trash-fill"></i></button>
                         </div>
                     </td>`;
             });
        }
        
        function checkEmptyTables() {
            ['consult-pending-tbody', 'consult-approved-tbody', 'consult-cancelled-tbody'].forEach(id => {
                const tbody = document.getElementById(id);
                if (tbody && tbody.rows.length === 0) {
                     tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No bookings in this category.</td></tr>`;
                }
            });
        }
        
        function htmlEntities(str) { return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'); }

        document.body.addEventListener('click', function(event) {
            const button = event.target.closest('button');
            if (!button) return;

            if (button.classList.contains('view-btn')) {
                const booking = JSON.parse(button.dataset.booking);
                document.getElementById('modalFirstName').textContent = booking.firstName;
                document.getElementById('modalLastName').textContent = booking.lastName;
                document.getElementById('modalEmail').textContent = booking.email;
                document.getElementById('modalDate').textContent = booking.dateTime;
                document.getElementById('modalDestination').textContent = booking.service;
                
                const departureWrapper = document.getElementById('modalDepartureLocationWrapper');
                const facebookWrapper = document.getElementById('modalFacebookLinkWrapper');
                
                departureWrapper.style.display = booking.departureLocation ? 'list-item' : 'none';
                if(booking.departureLocation) document.getElementById('modalDepartureLocation').textContent = booking.departureLocation;

                facebookWrapper.style.display = booking.facebookLink ? 'list-item' : 'none';
                if(booking.facebookLink) document.getElementById('modalFacebookLink').href = booking.facebookLink;

                detailsModal.show();
            } else if (button.matches('.approve-btn, .cancel-btn, .delete-btn')) {
                const bookingId = button.dataset.bookingId;
                const bookingName = button.dataset.bookingName || 'this booking';
                const confirmBtn = document.getElementById('confirmActionBtn');
                
                let action = '';
                if(button.classList.contains('approve-btn')) action = 'approve';
                if(button.classList.contains('cancel-btn')) action = 'cancel';
                if(button.classList.contains('delete-btn')) action = 'delete';

                confirmBtn.dataset.action = action;
                confirmBtn.dataset.bookingId = bookingId;

                const titles = { approve: 'Confirm Approval', cancel: 'Confirm Cancellation', delete: 'Confirm Deletion' };
                const texts = {
                    approve: `Are you sure you want to approve the consultation for ${bookingName}?`,
                    cancel: `Are you sure you want to cancel the consultation for ${bookingName}?`,
                    delete: `Are you sure you want to permanently delete the booking for ${bookingName}? This cannot be undone.`
                };
                const btnClasses = { approve: 'btn-success', cancel: 'btn-warning', delete: 'btn-danger' };

                document.getElementById('actionConfirmTitle').textContent = titles[action];
                document.getElementById('actionConfirmText').textContent = texts[action];
                confirmBtn.className = `btn ${btnClasses[action]}`;
                confirmBtn.textContent = action.charAt(0).toUpperCase() + action.slice(1);
                
                actionConfirmModal.show();
            }
        });

        document.getElementById('confirmActionBtn').addEventListener('click', function() {
            const action = this.dataset.action;
            const bookingId = this.dataset.bookingId;
            let actionType = '';
            let newStatus = '';
            
            const isConsultation = bookingId.startsWith('BK-');

            if (action === 'approve') { actionType = 'update_status'; newStatus = 'Approved'; }
            if (action === 'cancel') { actionType = 'update_status'; newStatus = 'Cancelled'; }
            if (action === 'delete') { actionType = isConsultation ? 'delete_consultation' : 'delete_flight'; }

            fetch('update-booking-status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: actionType, bookingId: bookingId, newStatus: newStatus }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (isConsultation) {
                        if (action === 'delete') {
                             allConsultations = allConsultations.filter(b => b.id !== bookingId);
                        } else {
                            const booking = allConsultations.find(b => b.id === bookingId);
                            if(booking) booking.status = newStatus;
                        }
                        renderConsultations();
                    } else { // It's a flight
                        allFlights = allFlights.filter(b => b.id !== bookingId);
                        renderFlights();
                    }
                } else {
                    alert('Action failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => console.error('Error performing action:', error));
            
            actionConfirmModal.hide();
        });

        // Initial render
        renderConsultations();
        renderFlights();
    });
    </script>
</body>
</html>

