document.addEventListener('DOMContentLoaded', function () {

    // --- FUNCTION 1: REFRESH THE SUMMARY CARDS ---
    function updateUserCounts() {
        fetch('/RAIS-Global/admin/get_active_users.php')
            .then(response => response.json())
            .then(data => {
                const activeCountElement = document.getElementById('activeUserCount');
                const inactiveCountElement = document.getElementById('inactiveUserCount');

                if (activeCountElement) {
                    activeCountElement.textContent = data.active_users;
                }
                if (inactiveCountElement) {
                    inactiveCountElement.textContent = data.inactive_users;
                }
            })
            .catch(error => console.error('Error fetching user counts:', error));
    }

    // --- FUNCTION 2: REFRESH THE USER TABLE ---
    function refreshUserTable() {
        const userTableBody = document.getElementById('userTableBody');
        fetch('/RAIS-Global/admin/get_user_table.php')
            .then(response => response.text())
            .then(html => {
                if (userTableBody) {
                    userTableBody.innerHTML = html;
                }
            })
            .catch(error => console.error('Error refreshing user table:', error));
    }

    // --- START THE AUTO-REFRESH INTERVALS ---
    // Change the intervals at the bottom of the file
    setInterval(updateUserCounts, 7000); // 7000 milliseconds = 7 seconds
    setInterval(refreshUserTable, 7000); // Let's make this one fast too for consistency
});