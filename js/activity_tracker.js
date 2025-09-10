// This script should be included on all USER-FACING pages of your website 
// (not the admin pages).

document.addEventListener('DOMContentLoaded', function() {
    // This function sends a request to the server every 10 seconds to log user activity.
    const updateUserActivity = () => {
        // The path must correctly point to your new PHP file.
        // If your main site pages are in the root and this file is in admin/,
        // the path might be '/admin/update_activity.php'
        fetch('/admin/update_activity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .catch(error => {
            console.error('Error updating user activity:', error);
        });
    };

    // Run the function immediately on page load
    updateUserActivity();

    // Then, run the function every 10 seconds (10000 milliseconds)
    setInterval(updateUserActivity, 10000);
});
