<?php 
    $currentPage = basename($_SERVER['PHP_SELF']); 

?>

<aside class="admin-sidebar bg-white" id="sidebar">
    <div class="sidebar-header p-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center fw-bold fs-5">
            <i class="bi bi-speedometer2 fs-3 text-secondary me-2"></i>
            <span class="logo-text">RDG <span class="text-primary">PRINTING</span></span>
        </div>
        <button class="btn-close d-md-none" id="sidebarClose"></button>
    </div>
    <div class="sidebar-menu px-3">
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="index.php"
                   class="nav-link menu-link text-dark <?php echo ($currentPage === 'index.php') ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2 me-2"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="job-request.php"
                class="nav-link menu-link text-dark <?php echo ($currentPage === 'job-request.php') ? 'active' : ''; ?>">
                    <i class="bi bi-hourglass-split me-2"></i>
                    <span class="menu-text">Job Request&nbsp;&nbsp;
                        <div id="activeCountBadge" style="font-size: 15px" class="badge rounded-circle bg-danger text-white">
                            <?php echo $activeCount ?>
                        </div>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</aside>
