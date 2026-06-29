<header class="navbar navbar-expand bg-white border-bottom sticky-top px-4 py-2 flex-shrink-0" style="height: 64px;">
    <button class="btn btn-link text-secondary p-1 d-md-none me-3" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    
    <div class="d-flex align-items-center flex-grow-1" style="max-width: 600px;">
        <!-- Search removed for Super Admin or keep as placeholder -->
        <span class="text-secondary fw-semibold">Super Admin Panel</span>
    </div>

    <div class="d-flex align-items-center gap-3 ms-auto">
        <div class="dropdown">
            <div class="d-flex align-items-center gap-2 cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="d-flex align-items-center justify-content-center rounded bg-dark text-white fw-medium" style="width: 32px; height: 32px;">SA</div>
                <span class="small fw-medium text-secondary d-none d-sm-block">{{ Auth::check() ? Auth::user()->name : 'Super Admin' }}</span>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li>
                    <form method="POST" action="{{ route('super_admin.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item small text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        sidebar.classList.toggle('d-none');
        sidebar.classList.toggle('position-absolute');
        sidebar.classList.toggle('h-100');
        sidebar.classList.toggle('z-3');
    }
</script>
