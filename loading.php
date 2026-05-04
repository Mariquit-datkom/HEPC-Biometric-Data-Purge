<div id="loading-screen">
    <div class="loader-wrapper">
        <div class="spinner"></div>
        <p class="loader-text">INITIALIZING SYSTEM..</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loader = document.getElementById('loading-screen');

        if (!sessionStorage.getItem('dashboard_loaded')) {
            window.addEventListener('load', () => {
                setTimeout(() => {
                    loader.classList.add('loader-hidden');
                    sessionStorage.setItem('dashboard_loaded', 'true');
                }, 1500);
            });
        } else {
            loader.style.display = 'none';
        }
    });
</script>