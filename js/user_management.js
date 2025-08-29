document.addEventListener('DOMContentLoaded', function () {
    // Get references to all possible elements
    const userTableBody = document.getElementById('userTableBody');
    const addUserModal = document.getElementById('addUserModal');
    const editUserModal = document.getElementById('editUserModal');
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const confirmationModal = document.getElementById('confirmationModal') ? new bootstrap.Modal(document.getElementById('confirmationModal')) : null;

    // --- FUNCTION TO REFRESH THE TABLE CONTENT ---
    // This is called after any successful action (add, edit, delete)
    function refreshUserTable() {
        fetch('/RAIS-Global/admin/get_user_table.php')
            .then(response => response.text())
            .then(html => {
                if (userTableBody) userTableBody.innerHTML = html;
            })
            .catch(error => console.error('Error refreshing user table:', error));
    }

    // --- EVENT HANDLING (for populating modals) ---
    if (userTableBody) {
        userTableBody.addEventListener('click', function (event) {
            const target = event.target;
            const userRow = target.closest('tr');

            if (target.classList.contains('edit-btn')) {
                editUserModal.querySelector('#editUserId').value = target.dataset.userId;
                editUserModal.querySelector('#editFirstName').value = userRow.cells[1].textContent;
                editUserModal.querySelector('#editLastName').value = userRow.cells[2].textContent;
                editUserModal.querySelector('#editEmail').value = userRow.cells[3].textContent;
            }

            if (target.classList.contains('delete-btn')) {
                const userId = target.dataset.userId;
                const userName = userRow.cells[1].textContent + ' ' + userRow.cells[2].textContent;
                deleteConfirmModal.querySelector('#deleteModalBody').textContent = `Are you sure you want to delete ${userName}?`;
                deleteConfirmModal.querySelector('#confirmDeleteButton').dataset.userIdToDelete = userId;
            }
        });
    }

    // --- FORM SUBMISSION LOGIC ---

    // Handle ADD USER submission
    if (addUserModal) {
        const addUserForm = document.getElementById('addUserForm');
        addUserForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = {
                firstName: document.getElementById('addFirstName').value,
                lastName: document.getElementById('addLastName').value,
                email: document.getElementById('addEmail').value,
                status: document.getElementById('addStatus').value
            };
            fetch('/RAIS-Global/admin/add_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    refreshUserTable();
                    bootstrap.Modal.getInstance(addUserModal).hide();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });
    }

    // Handle EDIT USER submission
    if (editUserModal) {
        const editUserForm = document.getElementById('editUserForm');
        editUserForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = {
                userId: document.getElementById('editUserId').value,
                firstName: document.getElementById('editFirstName').value,
                lastName: document.getElementById('editLastName').value,
                email: document.getElementById('editEmail').value,
                status: document.getElementById('editStatus').value
            };
            fetch('/RAIS-Global/admin/edit_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    refreshUserTable();
                    bootstrap.Modal.getInstance(editUserModal).hide();
                    if (confirmationModal) confirmationModal.show();
                } else {
                    alert('Error updating user.');
                }
            });
        });
    }
    
    // Handle DELETE USER confirmation
    if (deleteConfirmModal) {
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');
        confirmDeleteButton.addEventListener('click', function () {
            const userId = this.dataset.userIdToDelete;
            fetch('/RAIS-Global/admin/delete_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ userId: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    refreshUserTable();
                } else {
                    alert('Error: ' + data.message);
                }
                bootstrap.Modal.getInstance(deleteConfirmModal).hide();
            });
        });
    }
});