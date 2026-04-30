document.addEventListener('DOMContentLoaded', () => {
    const devices = document.querySelectorAll('.device');
    const instructions = document.querySelector('.history-instructions');
    const historyContainer = document.querySelector('.history-container');

    devices.forEach(device => {
        device.addEventListener('click', async () => {
            devices.forEach(d => d.classList.remove('active-device'));
            device.classList.add('active-device');

            instructions.style.display = 'none';
            historyContainer.style.display = 'block';
            document.body.style.cursor = 'wait';

            const name = device.getAttribute('data-name');
            const ip = device.getAttribute('data-ip');

            try {
                const response = await fetch(`fetchHistory.php?name=${encodeURIComponent(name)}&ip=${encodeURIComponent(ip)}`);
                const result = await response.json();

                if (result.success) {
                    if (result.data.length > 0) {
                        historyContainer.innerHTML = result.data.map(line => `
                            <div class="history-entry">
                                ${line}
                            </div>
                        `).join('');
                    } else {
                        historyContainer.innerHTML = 'No removal history recorded for this device.';
                    }
                }
            } catch (error) {
                historyContainer.innerHTML = 'Error loading history.';
            }
            
            document.body.style.cursor = 'default';
        });
    });
});