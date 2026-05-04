// This event triggers when the server sends a push notification
self.addEventListener('push', function(event) {
    let data = { 
        title: 'SYSTEM NOTIFICATION', 
        body: 'New data stream detected.' 
    };

    if (event.data) {
        try {
            // Try to parse the JSON sent from PHP
            data = event.data.json();
        } catch (e) {
            // If it's just text, use that as the body
            data.body = event.data.text();
        }
    }

    const options = {
        body: data.body,
        icon: 'assets/img/notif_icon.png', // Path to your logo
        badge: 'assets/img/favicon-32x32.png', // Small icon for mobile status bars
        vibrate: [100, 50, 100],
        data: {
            url: '/biometric_data_purge/dashboard.php' // Link to open when clicked
        }
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

// This handles the user clicking on the notification
self.addEventListener('notificationclick', function(event) {
    event.notification.close(); // Close the popup

    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});