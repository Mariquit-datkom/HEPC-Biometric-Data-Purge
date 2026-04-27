document.addEventListener('DOMContentLoaded', () => {
    const userContainer = document.getElementById('userDropdownContainer');

    userContainer.addEventListener('click', (e) => {
        userContainer.classList.toggle('open');
        e.stopPropagation();
    });

    window.addEventListener('click', () => {
        userContainer.classList.remove('open');
    });
});