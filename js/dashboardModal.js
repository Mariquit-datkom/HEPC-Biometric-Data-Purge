document.addEventListener ('DOMContentLoaded', () => {
    const dashboardItems = document.querySelectorAll('.dashboard-item');
    const dashboardModal = document.getElementById('modal-overlay');
    const modalContent = document.getElementById('modal-content');

    const backBtn = document.getElementById('back-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    const deviceName = document.getElementById('modal-device-name');
    const deviceIp = document.getElementById('modal-device-ip');

    const lastLogRemovalDate = document.getElementById('last-logs-removal-date');
    const nextCutoffDate = document.getElementById('next-cutoff-date');

    dashboardItems.forEach(item => {
        item.addEventListener('click', (e) => {
            currentActiveItem = item;
            
            const name = item.getAttribute('data-name');
            const ip = item.getAttribute('data-ip');

            const lastRemovalDate = item.getAttribute('data-last-removal-date');
            const cutoff = item.getAttribute('data-cutoff');

            deviceName.textContent = name.toUpperCase();
            deviceIp.textContent = '(' + ip + ')';

            lastLogRemovalDate.textContent = lastRemovalDate;
            nextCutoffDate.textContent = cutoff.charAt(0).toUpperCase() + cutoff.slice(1);

            dashboardModal.style.display = 'grid';
            e.stopPropagation();
        });
    })

    modalContent.addEventListener('click', (e) => {
        e.stopPropagation();
    })
        
    backBtn.addEventListener('click', (e) => {
        dashboardModal.style.display = 'none';
    });
        
    cancelBtn.addEventListener('click', (e) => {
        dashboardModal.style.display = 'none';
    });

    window.addEventListener('click', () => {
        dashboardModal.style.display = 'none';
    });
})