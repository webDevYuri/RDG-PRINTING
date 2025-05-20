<?php

$pageTitle = 'Dashboard';

session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

if (!isset($_SESSION['username'])) {
      header('Location: signin.php');
      exit;
} else {
      $admin_username = $_SESSION['username'];
}
include '../backend/admin-process/dashboard-data.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | RDG Printing</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css"/>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <link rel="icon" href="../assets/logo/logo.png" type="image/x-icon">
</head>
<body>
      <?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
            <script>
                  Swal.fire({
                        title: 'Welcome!',
                        text: 'You have successfully logged in as Admin.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                  }).then(() => {
                        window.history.replaceState(null, null, window.location.pathname);
                  });
            </script>
      <?php endif; ?>
    <div class="d-flex">
      <?php include "../includes/admin-sidebar.php" ?>
        <main class="admin-main flex-grow-1 d-flex flex-column min-vh-100">
            <?php include "../includes/admin-header.php" ?>
            <div class="admin-content p-4">
                <div class="row mb-0">
                    <div class="col-12 mb-1">
                        <h5 class="text-muted fw-bold small text-uppercase">Today's Activity</h5>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon-new bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-printer fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Print Document</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 me-2"><?php echo $todayCounts['print']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon-new bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-person fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Passport Size</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 me-2"><?php echo $todayCounts['passport']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon-new bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-person-circle fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">2x2</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 me-2"><?php echo $todayCounts['2x2']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon-new bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-person-badge fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">1x1</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 me-2"><?php echo $todayCounts['1x1']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-12 mb-1">
                        <h5 class="text-muted fw-bold small text-uppercase">Overall Statistics</h5>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon-total text-primary rounded-4 d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-printer fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Print Document</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 me-2"><?php echo $serviceCounts['print']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon-total text-success rounded-4 d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-person fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Passport Size</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 me-2"><?php echo $serviceCounts['passport']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon-total text-warning rounded-4 d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-person-circle fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">2x2</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 me-2"><?php echo $serviceCounts['2x2']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon-total text-info rounded-4 d-flex align-items-center justify-content-center me-3">
                                    <i class="bi bi-person-badge fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">1x1</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 me-2"><?php echo $serviceCounts['1x1']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                  <div class="col-6"> 
                        <div class="bg-white shadow-sm rounded-3 p-4 d-flex flex-column align-items-center justify-content-center">
                              <h5 class="text-muted fw-bold small text-uppercase">Print Document Requests</h5>
                              <div class="bar-chart-wrapper">
                                    <canvas id="printRequestsChart"></canvas>
                              </div>
                        </div>
                  </div>
                  <div class="col-6"> 
                        <div class="bg-white shadow-sm rounded-3 p-4 d-flex flex-column align-items-center justify-content-center">
                              <h5 class="text-muted fw-bold small text-uppercase">Top Customers</h5>
                              <div class="pie-chart-wrapper d-flex justify-content-center">
                                    <canvas id="customerFileChart" class="h-100"></canvas>
                              </div>
                        </div>
                  </div>
                </div>
            </div>
        </main>
    </div>

    <script>
      const ctxBar = document.getElementById('printRequestsChart').getContext('2d');
      const printRequestsChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                  labels: ['PRINT', 'PASSPORT SIZE', '2X2', '1X1'],
                  datasets: [{
                        data: [<?php echo $serviceCounts['print']; ?>, <?php echo $serviceCounts['passport']; ?>, <?php echo $serviceCounts['2x2']; ?>, <?php echo $serviceCounts['1x1']; ?>],
                        backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                  }]
            },
            options: {
                  scales: {
                        y: {
                        beginAtZero: true
                        },
                        x: {
                        title: {
                              display: false 
                        }
                        }
                  },
                  plugins: {
                        legend: {
                        display: false 
                        }
                  }
            }
            });

            const ctxPie = document.getElementById('customerFileChart').getContext('2d');
            const customerFileChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                  labels: <?php echo json_encode(array_column($topCustomers, 'name')); ?>,
                  datasets: [{
                        data: <?php echo json_encode(array_column($topCustomers, 'count')); ?>,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                  }]
            },
            options: {
                  responsive: true,
                  plugins: {
                        legend: {
                        position: 'bottom', 
                        },
                        title: {
                        display: false 
                        }
                  }
            }
      });
    </script>
    <script>
            document.getElementById('logoutButton').addEventListener('click', function(event) {
                  event.preventDefault(); 
                  Swal.fire({
                        title: 'Are you sure?',
                        text: "You will be logged out!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        reverseButtons: "true",
                        customClass: {
                              confirmButton: 'swal-confirm-button', 
                              cancelButton: 'swal-cancel-button'    
                        }
                  }).then((result) => {
                        if (result.isConfirmed) {
                        window.location.href = '../backend/admin-process/logout.php'; 
                        }
                  });
            });
      </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/active-count.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>