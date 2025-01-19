document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('menuToggle').addEventListener('click', function() {
        const navContent = document.getElementById('navContent');
        navContent.classList.toggle('hidden');
    });
});