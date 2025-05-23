<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
  .custom-navbar {
    background-color: #ced4da;
  }

  .nav-pills .nav-link {
    color: black;
  }

  .nav-pills .nav-link.active {
    background-color: #adb5bd;
    color: black !important;
  }
</style>

<nav class="navbar navbar-expand-lg custom-navbar px-4">
  <a class="navbar-brand fw-bold" href="home.php">Get Hotels</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="nav nav-pills me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link <?= in_array('home', $activePages ?? []) ? 'active' : '' ?>" href="home.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= in_array('rooms', $activePages ?? []) ? 'active' : '' ?>" href="rooms.php">Rooms</a>
      </li>
      <li class="nav-item">
       <a class="nav-link <?= in_array('facilities', $activePages ?? []) ? 'active' : '' ?>" href="facilities.php">Facilities</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= in_array('about', $activePages ?? []) ? 'active' : '' ?>" href="about.php">About</a>
      </li>
    </ul>

    <?php if (!empty($_SESSION['loggedin'])): ?>
      <div class="dropdown">
        <a class="d-inline-flex align-items-center text-dark text-decoration-none dropdown-toggle fw-bold"
           href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle me-1" style="font-size: 1.4rem;"></i>
          Hi, <?= htmlspecialchars($username) ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" style="min-width: 180px;">
          <li><a class="dropdown-item" href="profile.php">Ubah Profil</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </div>
    <?php else: ?>
      <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
    <?php endif; ?>
  </div>
</nav>
