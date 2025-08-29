 // This function sends the heartbeat to the server
    function sendUserHeartbeat() {
        fetch('/RAIS-Global/admin/update_activity.php') // This calls the PHP file we just created
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'success') {
                    console.error('Heartbeat failed:', data.message);
                }
            })
            .catch(error => console.error('Error sending heartbeat:', error));
    }

    // Call the function once immediately on page load
    sendUserHeartbeat(); 

    // Change the interval at the bottom of the file
    setInterval(sendUserHeartbeat, 5000); // 5000 milliseconds = 5 seconds