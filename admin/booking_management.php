<?php
// Page-specific data
$page_title = "RAIS Admin - Booking Management";
$active_page = "booking_management";

// Data for the first card: Consultation Bookings
$consultationBookings = [
    ['id' => 'BK-001', 'firstName' => 'Carlos', 'lastName' => 'Reyes', 'service' => 'Visa Consultation', 'dateTime' => '2024-08-15 10:00 AM', 'status' => 'Confirmed'],
    ['id' => 'BK-002', 'firstName' => 'Maria', 'lastName' => 'Santos', 'service' => 'IELTS Review', 'dateTime' => '2024-08-15 02:00 PM', 'status' => 'Pending'],
    ['id' => 'BK-003', 'firstName' => 'Luis', 'lastName' => 'Garcia', 'service' => 'Work Permit Assistance', 'dateTime' => '2024-08-16 11:00 AM', 'status' => 'Completed'], // Assuming 'Completed' is a final state
    ['id' => 'BK-004', 'firstName' => 'Ana', 'lastName' => 'Cruz', 'service' => 'Visa Consultation', 'dateTime' => '2024-08-17 09:00 AM', 'status' => 'Cancelled'],
    ['id' => 'BK-005', 'firstName' => 'Juan', 'lastName' => 'Dela Cruz', 'service' => 'Initial Assessment', 'dateTime' => '2024-08-18 01:00 PM', 'status' => 'Pending'],
];

// Data for the second card: Flight Bookings
$flightBookings = [
    ['id' => 'FL-001', 'firstName' => 'Elena', 'lastName' => 'Velez', 'service' => 'Toronto (YYZ)', 'dateTime' => '2024-09-01 08:00 PM', 'status' => 'Confirmed'],
    ['id' => 'FL-002', 'firstName' => 'Miguel', 'lastName' => 'Ocampo', 'service' => 'Vancouver (YVR)', 'dateTime' => '2024-09-05 06:00 AM', 'status' => 'Pending'],
];

// Available consultants for assignment
$consultants = ['Mr. Roman', 'Ms. Associates', 'Legal Team'];
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
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php require_once 'sidebar.php'; ?>
        <div class="content-area">
            <?php require_once 'header.php'; ?>
            <main class="main-content">
                <h1>Booking Management</h1>

                <div class="content-card mb-4" id="consultationCard">
                    <h2 class="mb-3">Book Consultation</h2>
                    <ul class="nav nav-tabs nav-tabs-custom">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#consult-pending">Pending</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#consult-confirmed">Confirmed</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#consult-cancelled">Cancelled</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#consult-completed">Completed</button></li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="consult-pending"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Service</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="consultation-pending-tbody"></tbody></table></div></div>
                        <div class="tab-pane fade" id="consult-confirmed"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Service</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="consultation-confirmed-tbody"></tbody></table></div></div>
                        <div class="tab-pane fade" id="consult-cancelled"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Service</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="consultation-cancelled-tbody"></tbody></table></div></div>
                        <div class="tab-pane fade" id="consult-completed"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Service</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="consultation-completed-tbody"></tbody></table></div></div>
                    </div>
                </div>

                <div class="content-card" id="flightCard">
                    <h2 class="mb-3">Book Flight</h2>
                    <ul class="nav nav-tabs nav-tabs-custom">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#flight-pending">Pending</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#flight-confirmed">Confirmed</button></li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="flight-pending"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Destination</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="flight-pending-tbody"></tbody></table></div></div>
                        <div class="tab-pane fade" id="flight-confirmed"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>ID</th><th>Name</th><th>Destination</th><th>Schedule</th><th>Actions</th></tr></thead><tbody id="flight-confirmed-tbody"></tbody></table></div></div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="acceptBookingModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Confirm Booking</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Confirm booking for:</p><ul class="list-group mb-3"><li class="list-group-item"><strong>Client:</strong> <span id="modalClientName"></span></li><li class="list-group-item"><strong>Schedule:</strong> <span id="modalClientSchedule"></span></li></ul><div class="mb-3"><label for="consultantSelect" class="form-label">Appoint Consultant:</label><select class="form-select" id="consultantSelect"><?php foreach ($consultants as $consultant) { echo "<option value=\"" . htmlspecialchars($consultant) . "\">" . htmlspecialchars($consultant) . "</option>"; } ?></select></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirmAcceptBtn">Confirm Appointment</button></div></div></div></div>
    <div class="modal fade" id="cancelBookingModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Cancel Booking</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="cancelModalText"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger" id="confirmCancelBtn"> Cancel Booking</button></div></div></div></div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="togglemodeScript.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let consultationBookings = <?php echo json_encode($consultationBookings, JSON_PRETTY_PRINT); ?>;
        let flightBookings = <?php echo json_encode($flightBookings, JSON_PRETTY_PRINT); ?>;
        
        const acceptModal = new bootstrap.Modal(document.getElementById('acceptBookingModal'));
        const cancelModal = new bootstrap.Modal(document.getElementById('cancelBookingModal'));

        function renderBookings(cardId, data) {
            const cardElement = document.getElementById(cardId);
            const isCancellable = (cardId === 'consultationCard');
            
            // Clear all tables within the card first
            cardElement.querySelectorAll('tbody').forEach(tbody => tbody.innerHTML = '');

            data.forEach(book => {
                let tbody;
                switch(book.status) {
                    case 'Pending': tbody = cardElement.querySelector('[id$="-pending-tbody"]'); break;
                    case 'Confirmed': tbody = cardElement.querySelector('[id$="-confirmed-tbody"]'); break;
                    case 'Cancelled': tbody = cardElement.querySelector('[id$="-cancelled-tbody"]'); break;
                    case 'Completed': tbody = cardElement.querySelector('[id$="-completed-tbody"]'); break;
                }
                if (!tbody) return; // Skip if no matching tab for status

                const isPending = book.status === 'Pending';
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${book.id}</td>
                    <td>${book.firstName} ${book.lastName}</td>
                    <td>${book.service}</td>
                    <td>${book.dateTime}</td>
                    <td>
                        <button class="btn btn-sm btn-success accept-btn" data-booking-id="${book.id}" ${!isPending ? 'disabled' : ''}><i class="bi bi-check-lg"></i></button>
                        <button class="btn btn-sm btn-danger cancel-btn" data-booking-id="${book.id}" ${(!isPending || !isCancellable) ? 'disabled' : ''} title="${!isCancellable ? 'Flights cannot be cancelled' : ''}"><i class="bi bi-x-lg"></i></button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }
        
        function handleActionClick(event) {
            const button = event.target.closest('button.accept-btn, button.cancel-btn');
            if (!button) return;

            const bookingId = button.dataset.bookingId;
            const booking = consultationBookings.find(b => b.id === bookingId) || flightBookings.find(b => b.id === bookingId);
            if (!booking) return;

            if (button.classList.contains('accept-btn')) {
                document.getElementById('modalClientName').textContent = `${booking.firstName} ${booking.lastName}`;
                document.getElementById('modalClientSchedule').textContent = booking.dateTime;
                document.getElementById('confirmAcceptBtn').dataset.bookingId = bookingId;
                acceptModal.show();
            } else if (button.classList.contains('cancel-btn')) {
                document.getElementById('cancelModalText').textContent = `Are you sure you want to cancel the booking for ${booking.firstName} ${booking.lastName}?`;
                document.getElementById('confirmCancelBtn').dataset.bookingId = bookingId;
                cancelModal.show();
            }
        }

        function updateBookingStatus(bookingId, newStatus) {
            let consultBooking = consultationBookings.find(b => b.id === bookingId);
            let flightBooking = flightBookings.find(b => b.id === bookingId);

            if (consultBooking) {
                consultBooking.status = newStatus;
                renderBookings('consultationCard', consultationBookings);
            } else if (flightBooking) {
                flightBooking.status = newStatus;
                renderBookings('flightCard', flightBookings);
            }
        }
        
        document.body.addEventListener('click', handleActionClick);

        document.getElementById('confirmAcceptBtn').addEventListener('click', function() {
            updateBookingStatus(this.dataset.bookingId, 'Confirmed');
            acceptModal.hide();
        });

        document.getElementById('confirmCancelBtn').addEventListener('click', function() {
            updateBookingStatus(this.dataset.bookingId, 'Cancelled');
            cancelModal.hide();
        });

        // Initial render for both sections
        renderBookings('consultationCard', consultationBookings);
        renderBookings('flightCard', flightBookings);
    });
    </script>
</body>
</html>```