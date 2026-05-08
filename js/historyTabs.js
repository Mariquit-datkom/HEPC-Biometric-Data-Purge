document.addEventListener('DOMContentLoaded', () => {
    const historyTabsContainer = document.querySelector('.tabs-container');
    const historyTabs = historyTabsContainer.querySelectorAll('.company-tab');
    
    const deviceListContainer = document.querySelector('.device-list-container');
    const devices = deviceListContainer.querySelectorAll('.device');

    historyTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            historyTabs.forEach(t => t.classList.remove('active-tab'));
            tab.classList.add('active-tab');
            
            const company = tab.getAttribute('data-company');
            showDevices(company);
        })
    })

    function showDevices(company) {
        devices.forEach((device) => {
            if (company === 'all') {
                devices.forEach(d => d.style.display = 'flex');
            } else {
                const name = device.getAttribute('data-name');
                if(name.includes(company)) device.style.display = 'flex';
                else device.style.display = 'none';
            }
        })
    }
})