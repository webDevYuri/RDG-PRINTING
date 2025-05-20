<?php
$pageTitle = 'Job Request';

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

include '../backend/connection/db_conn.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 10;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$alpha = isset($_GET['alpha']) ? $_GET['alpha'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : 'all';

$offset = ($page - 1) * $pageSize;

$query = "SELECT * FROM uploads WHERE 1=1";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $query .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
}

if (!empty($alpha)) {
    $alpha = $conn->real_escape_string($alpha);
    $query .= " AND name LIKE '$alpha%'";
}

if ($status !== 'all') {
    $isActive = $status === 'active' ? 1 : 0;
    $query .= " AND isActive = $isActive";
}

$query .= " ORDER BY created_at DESC"; 

$totalCountResult = $conn->query("SELECT COUNT(*) as total FROM ($query) as t");
$totalCount = $totalCountResult->fetch_assoc()['total'];
$totalPages = ceil($totalCount / $pageSize);

$query .= " LIMIT $pageSize OFFSET $offset";
$result = $conn->query($query);

$jobRequests = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $jobRequests[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | RDG Printing</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <link rel="icon" href="../assets/logo/logo.png" type="image/x-icon">
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php
        if (isset($_SESSION['success_message'])): ?>
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '<?php echo htmlspecialchars($_SESSION['success_message']); ?>',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <div class="d-flex">
        <?php include "../includes/admin-sidebar.php"; ?>
        <main class="admin-main flex-grow-1 d-flex flex-column min-vh-100">
            <?php include "../includes/admin-header.php"; ?>
            <div class="container mt-3">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                                <h5 class="card-title mb-0 my-2">
                                    <i class="bi bi-list-ul"></i>
                                    List of Job Requests
                                </h5>
                            </div>
                            <div class="card-body mt-4">
                                <div class="row mb-4 align-items-center">
                                    <div class="col-12 col-md-8">
                                        <form method="GET" action="">
                                            <div class="row g-2">
                                                <div class="col-12 col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                                        <input type="text" class="form-control" id="searchInput" name="search" autocomplete="off" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="input-group" style="width: 82%">
                                                        <span class="input-group-text" for="pageSizeSelect">Showing</span>
                                                        <select class="form-select" id="pageSizeSelect" name="pageSize" onchange="this.form.submit()">
                                                            <option value="5" <?php echo $pageSize == 5 ? 'selected' : ''; ?>>5</option>
                                                            <option value="10" <?php echo $pageSize == 10 ? 'selected' : ''; ?>>10</option>
                                                            <option value="25" <?php echo $pageSize == 25 ? 'selected' : ''; ?>>25</option>
                                                            <option value="50" <?php echo $pageSize == 50 ? 'selected' : ''; ?>>50</option>
                                                            <option value="all" <?php echo $pageSize == 'all' ? 'selected' : ''; ?>>All</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-2" style="margin-left: -4.5%">
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="alphaSelect">A-Z</label>
                                                        <select class="form-select" id="alphaSelect" name="alpha" onchange="this.form.submit()">
                                                            <option value="">All</option>
                                                            <?php
                                                            for ($i = 65; $i <= 90; $i++) {
                                                                $char = chr($i);
                                                                echo "<option value=\"$char\" " . ($alpha == $char ? 'selected' : '') . ">$char</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
                                        <div class="btn-group" role="group">
                                            <form method="GET" action="">
                                                <button type="submit" class="btn btn-outline-primary <?php echo $status === 'all' ? 'active' : ''; ?>" name="status" value="all">All</button>
                                                <button type="submit" class="btn btn-outline-primary <?php echo $status === 'active' ? 'active' : ''; ?>" name="status" value="active">Active</button>
                                                <button type="submit" class="btn btn-outline-primary <?php echo $status === 'finished' ? 'active' : ''; ?>" name="status" value="finished">Finished</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Service</th>
                                                <th>Requested at</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Attachment</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="jobRequestsTable">
                                            <?php foreach ($jobRequests as $request): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($request['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($request['email']); ?></td>
                                                    <td class="text-uppercase"><?php echo htmlspecialchars($request['service']); ?></td>
                                                    <td><?php echo date('M d Y g:i A', strtotime($request['created_at'])); ?></td>
                                                    <td class="text-center">
                                                        <?php if ($request['isActive']): ?>
                                                            <span class="badge bg-success" style="width: 70px">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary" style="width: 70px">Done</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-outline-secondary view-attachment" data-id="<?php echo $request['id']; ?>" data-customer-name="<?php echo htmlspecialchars($request['name']); ?>"  data-bs-toggle="modal" data-bs-target="#attachmentModal">View Attachment</button>
                                                    </td>
                                                    <td class="text-center d-flex gap-2 align-items-center justify-content-center">
                                                        <form method="POST" action="mark-as-done.php">
                                                            <input type="hidden" name="id" value="<?php echo $request['id']; ?>">
                                                            <input type="hidden" name="action" value="markAsDone">
                                                            <?php if ($request['isActive']): ?>
                                                                <button type="submit" class="btn btn-warning">Job Done</button>
                                                            <?php else: ?>
                                                                <button class="btn btn-warning" disabled>Job Done</button>
                                                            <?php endif; ?>
                                                        </form>
                                                        <form method="POST" action="notify.php">
                                                            <input type="hidden" name="id" value="<?php echo $request['id']; ?>">
                                                            <?php if ($request['isActive']): ?>
                                                                <button type="submit" name="action" value="notify" class="btn btn-primary" disabled>Notify</button>
                                                            <?php else: ?>
                                                                <button type="submit" name="action" value="notify" class="btn btn-primary">Notify</button>
                                                            <?php endif; ?>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
                                    <div class="mb-3 mb-md-0">
                                        <p class="mb-0 text-muted" id="entriesSummary">Showing 1 to <?php echo count($jobRequests); ?> of <?php echo $totalCount; ?> entries</p>
                                    </div>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0" id="pagination">
                                            <?php if ($page > 1): ?>
                                                <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&pageSize=<?php echo $pageSize; ?>&search=<?php echo urlencode($search); ?>&alpha=<?php echo urlencode($alpha); ?>&status=<?php echo $status; ?>">Previous</a></li>
                                            <?php else: ?>
                                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                            <?php endif; ?>
                                            
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                    <a class="page-link" href="?page=<?php echo $i; ?>&pageSize=<?php echo $pageSize; ?>&search=<?php echo urlencode($search); ?>&alpha=<?php echo urlencode($alpha); ?>&status=<?php echo $status; ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            
                                            <?php if ($page < $totalPages): ?>
                                                <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&pageSize=<?php echo $pageSize; ?>&search=<?php echo urlencode($search); ?>&alpha=<?php echo urlencode($alpha); ?>&status=<?php echo $status; ?>">Next</a></li>
                                            <?php else: ?>
                                                <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" tabindex="-1" id="attachmentModal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Attachments for <span class="text-capitalize badge bg-danger text-white" id="customerNameBadge"></span></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="attachmentModalBody">
              <p>Loading attachments...</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/active-count.js"></script>
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
                reverseButtons: true,
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

        document.querySelectorAll('.view-attachment').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const customerName = this.getAttribute('data-customer-name');
                document.getElementById('customerNameBadge').textContent = customerName;

                fetch(`get-attachments.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const modalBody = document.getElementById('attachmentModalBody');
                        modalBody.innerHTML = ''; 
                        if (data.attachments && data.attachments.length > 0) {
                            let attachmentHtml = '<ul class="list-group">';
                            data.attachments.forEach(attachment => {
                                const fileType = attachment.file_path.split('.').pop().toLowerCase();
                                let icon = '';
                                switch (fileType) {
                                    case 'pdf':
                                        icon = '📄'; 
                                        break;
                                    case 'jpg':
                                    case 'jpeg':
                                    case 'png':
                                        icon = '🖼️'; 
                                        break;
                                    case 'doc':
                                    case 'docx':
                                        icon = '📝'; 
                                        break;
                                    case 'zip':
                                        icon = '🗄️'; 
                                        break;
                                    default:
                                        icon = '📁'; 
                                }

                                attachmentHtml += `
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>${icon} <a href="../uploads/${attachment.file_path}" target="_blank">${attachment.file_name}</a></span>
                                        <button class="btn btn-sm btn-success" onclick="downloadFile('${attachment.file_path}', '${customerName}')">Download</button>
                                    </li>
                                `;
                            });
                            attachmentHtml += '</ul>';
                            modalBody.innerHTML = attachmentHtml;
                        } else {
                            modalBody.innerHTML = '<p>No attachments found.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading attachments:', error);
                        document.getElementById('attachmentModalBody').innerHTML = '<p class="text-danger">Error loading attachments. Please try again.</p>';
                    });
            });
        });

        function downloadFile(filePath, customerName) {
            const link = document.createElement('a');
            const randomNum = Math.floor(Math.random() * 10000);
            const fileName = `${customerName}_${randomNum}.${filePath.split('.').pop()}`; 
            link.href = `../uploads/${filePath}`;
            link.download = fileName; 
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>