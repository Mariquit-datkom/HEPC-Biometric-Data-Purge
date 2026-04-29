function calculateNewCutoffDate() {
    const today = new Date();
    const currentDay = today.getDate();

    let year = today.getFullYear();
    let month = today.getMonth();

    if (currentDay >= 20) {
        month++;
        if (month > 11) {
            month = 0;
            year++;
        }
    }        
    
    const newCutoffDate = new Date(year, month, 20);

    return newCutoffDate.toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        timeZone: 'Asia/Manila'
    });
}

async function updateCutoffDate() {
    if (!currentActiveItem) return;

    const deviceName = currentActiveItem.getAttribute('data-name');
    const newCutoffDate = calculateNewCutoffDate();

    try {
        const response = await fetch('updateData.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                name: deviceName, 
                cutoff: newCutoffDate 
            })
        });

        const result = await response.json();

        if (result.success) {
            alert(`Success! Logs purged. Next cutoff: ${newCutoffDate}`);
            // Reload the page so PHP re-renders the sorted dashboard
            window.location.reload(); 
        } else {
            alert("Error: " + result.message);
        }
    } catch (error) {
        console.error("Fetch Error:", error);
        alert("Failed to communicate with the server.");
    }
}