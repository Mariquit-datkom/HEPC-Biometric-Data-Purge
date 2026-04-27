document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('search');
    const items = document.querySelectorAll('.content-item');
    const noResultMessage = document.querySelectorAll('.no-results');

    if (searchBar) {
        searchBar.addEventListener('input', (e) => {
            const searchString = e.target.value.toLowerCase();
            let visibleCount = 0;

            items.forEach((item) => {
                const name = item.getAttribute('data-name') || '';
                const ip = item.getAttribute('data-ip') || '';
                const cutoff = item.getAttribute('data-cutoff') || '';

                if (name.includes(searchString) || ip.includes(searchString) || cutoff.includes(searchString)) {
                    item.style.display = 'flex';
                    setTimeout(() => {item.classList.remove('is-hidden');}, 10);
                    visibleCount++;
                } else {
                    item.classList.add('is-hidden');
                    setTimeout(() => {if (item.classList.contains('is-hidden')) item.style.display = 'none';}, 200);
                }
            });

            noResultMessage.forEach((msg) => {
                if (visibleCount === 0 && searchString !== "") msg.style.display = 'grid';
                else msg.style.display = 'none';
            });
        });
    }
});