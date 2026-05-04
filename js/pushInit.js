function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

async function initPushNotifications(publicVapidKey) {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) return;

    try {
        const registration = await navigator.serviceWorker.register('sw.js');
        const permission = await Notification.requestPermission();

        if (permission === 'granted') {
            const subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(publicVapidKey)
            });

            await fetch('saveSubscription.php', {
                method: 'POST',
                body: JSON.stringify(subscription),
                headers: { 'Content-Type': 'application/json' }
            });
            console.log("Matrix Link Established.");
        }
    } catch (error) {
        console.error('Push Error:', error);
    }
}