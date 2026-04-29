document.addEventListener('DOMContentLoaded', () => {
    const dropdown = document.getElementById('sortContainer');
    const display = dropdown.querySelector('.selected-display');
    const list = dropdown.querySelector('.options-list');
    const hiddenInput = document.getElementById('sortByValue');
    const dashboardContent = document.querySelector('.dashboard-content');

    display.addEventListener('click', () => {
        dropdown.classList.toggle('open');
    });

    list.querySelectorAll('li').forEach(item => {
        item.addEventListener('click', () => {
            const val = item.getAttribute('data-value');
            const text = item.innerText;

            display.innerText = text;
            hiddenInput.value = val;
            dropdown.classList.remove('open');
            
            sortDashboard(val);
        });
    });

    function sortDashboard(criteria) {
        const items = Array.from(dashboardContent.querySelectorAll('.dashboard-item'));

        items.sort((a, b) => {            
            if (criteria === 'byCutoff') {
                const dateA = new Date(a.querySelector('.log-cutoff').innerText.replace('Cutoff: ', ''));
                const dateB = new Date(b.querySelector('.log-cutoff').innerText.replace('Cutoff: ', ''));
                return dateA - dateB;
            }

            if (criteria === 'alphabetical') {
                const nameA = a.querySelector('.device-name').innerText.toLowerCase();
                const nameB = b.querySelector('.device-name').innerText.toLowerCase();
                return nameA.localeCompare(nameB);
            } 

            return 0;
        });

        dashboardContent.style.opacity = '0';
        setTimeout(() => {
            dashboardContent.innerHTML = '';
            items.forEach(item => dashboardContent.appendChild(item));
            dashboardContent.style.opacity = '1';
        }, 350);
    }

    window.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) dropdown.classList.remove('open');
    });
})