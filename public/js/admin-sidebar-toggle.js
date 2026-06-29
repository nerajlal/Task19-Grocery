function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    if (sidebar) {
        sidebar.classList.toggle('d-none');
        sidebar.classList.toggle('d-flex');
    }
}
