<?php
session_start();
include '../backend/connection/db_conn.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $admin['username'];
            header('Location: index.php?login=success');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css"/>
  <link rel="stylesheet" href="../assets/css/admin.css" >
  <link rel="icon" href="../assets/logo/logo.png" type="image/x-icon">
  <title>Admin login | RDG Printing</title>
</head>
<body class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh">

      <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
            <div class="d-flex flex-column align-items-center justify-content-center mb-3">
                  <div class="shadow-logo mb-3 overflow-hidden d-flex align-items-center justify-content-center rounded-circle" style="width: 150px; height: 150px;">
                        <img src="../assets/logo/logo.png" alt="RDG Printing" class="img-fluid mb-3" style="width: 100px; height: auto;">
                  </div>
                  <h4 class="fw-bolder text-secondary">Enter your Credentials</h4>
            </div>

            <?php if ($error): ?>
                  <div class="alert alert-danger text-center" role="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" action="">
                  <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autofocus autocomplete="off">
                        <label for="username">Username</label>
                  </div>
                  <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                        <span class="position-absolute end-0 top-50 translate-middle-y pe-3" style="cursor: pointer;" onclick="togglePassword()">
                              <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
      </div>

  <script>
    function togglePassword() {
      const pwd = document.getElementById('password');
      const icon = document.getElementById('toggleIcon');
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        pwd.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    }
  </script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</body>
</html>
