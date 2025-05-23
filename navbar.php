<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .custom-navbar {
      background-color: #ced4da;
    }

    .nav-pills .nav-link {
      border-radius: 0.5rem;
    }

    .nav-pills .nav-link.active {
      background-color: #adb5bd;
      color: black !important;
      border: 1px solid #6c757d;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }
  </style>

</head>

<body>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg custom-navbar px-4">
    <a class="navbar-brand fw-bold" href="home.php">Get Hotels</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="nav nav-pills me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>"
            href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'rooms.php' ? 'active' : '' ?>"
            href="rooms.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'facilities.php' ? 'active' : '' ?>"
            href="facilities.php">Facilities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>"
            href="about.php">About</a>
        </li>
      </ul>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <span class="fw-bold me-2">Hi, <?= htmlspecialchars($username) ?></span>
        <a href="logout.php" class="btn btn-primary">Logout</a>
      <?php else: ?>
        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Login -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">
            <i class="bi bi-box-arrow-in-right me-2"></i> User Login
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="login.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-dark w-100">LOGIN</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Register -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">
            <i class="bi bi-person-plus me-2"></i> User Registration
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="register.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-dark w-100">REGISTER</button>
          </div>
        </form>
      </div>
    </div>
  </div>



</body>

</html>