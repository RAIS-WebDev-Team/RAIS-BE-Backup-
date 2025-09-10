document.addEventListener('DOMContentLoaded', function() {

    const activeUserCountEl = document.getElementById('activeUserCount');
    const inactiveUserCountEl = document.getElementById('inactiveUserCount');

    /**
     * Fetches the latest active/inactive user counts from the server
     * and updates the numbers displayed on the dashboard.
     */
    async function updateUserCounts() {
        // Only proceed if the elements exist on the page
        if (!activeUserCountEl || !inactiveUserCountEl) {
            return;
        }

        try {
            // NOTE: This path assumes your admin folder is at the root of the project.
            // Adjust '/admin/get_user_counts.php' if your folder structure is different.
            const response = await fetch('../admin/get_user_counts.php');
            if (!response.ok) {
                throw new Error(`Network response was not ok (${response.status})`);
            }
            const data = await response.json();

            // Update the text content of the elements
            activeUserCountEl.textContent = data.active_users;
            inactiveUserCountEl.textContent = data.inactive_users;

        } catch (error) {
            console.error('Failed to fetch user counts:', error);
        }
    }

    /**
     * Periodically pings the server to update the current admin's 
     * 'last_activity' timestamp, keeping their session marked as active.
     */
    async function updateUserActivity() {
         try {
            // NOTE: Adjust path if needed.
            const response = await fetch('../admin/update_activity.php');
             if (!response.ok) {
                throw new Error(`Activity update failed (${response.status})`);
            }
            await response.json(); // Consume the JSON response to complete the request
         } catch(error) {
             console.error('Failed to update user activity:', error);
         }
    }

    // --- SET TIMERS ---

    // Update the user counts on the dashboard every 5 seconds (5000 milliseconds)
    setInterval(updateUserCounts, 5000);

    // Update this user's own "last seen" time every 10 seconds (10000 milliseconds)
    setInterval(updateUserActivity, 10000);

    // --- INITIAL CALLS ---
    // Run the functions once immediately on page load without waiting for the timers
    updateUserCounts();
    updateUserActivity();
});
