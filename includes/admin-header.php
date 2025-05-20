<header class="admin-header d-flex justify-content-between align-items-center bg-white shadow-sm p-3 sticky-top">
    <div class="header-left d-flex align-items-center">
        <button class="btn btn-outline-dark d-md-none me-3" id="menuToggle">
            <i class="bi bi-list"></i>
        </button>
        <h1 class="page-title mb-0"><?php echo $pageTitle; ?></h1>
    </div>
    <div class="header-right">
        <div class="px-2 py-1 shadow me-2 rounded d-flex align-items-center">
            <i class="bi bi-person-circle fs-4 me-2"></i>
            <span class="user-name"><?php echo htmlspecialchars($admin_username); ?></span>
        </div>
        <div>
            <button class="btn btn-danger" id="logoutButton"><i class="bi bi-power"></i></button>
        </div>
    </div>
</header>