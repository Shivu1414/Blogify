document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    let isOpen = true;

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            if (isOpen) {
                sidebar.classList.add('-ml-64');
            } else {
                sidebar.classList.remove('-ml-64');
            }
            isOpen = !isOpen;
        });
    }
});