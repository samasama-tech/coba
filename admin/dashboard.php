<?php
// Include file koneksi
require_once '../koneksi.php';

// Query untuk mengambil data admin (contoh: ambil admin pertama)
$sql = "SELECT * FROM admin LIMIT 1";
$result = $conn->query($sql);
$admin_data = $result->fetch_assoc();

// Jika tidak ada data admin
if (!$admin_data) {
    $admin_data = [
        'nama' => 'Admin Default',
        'telp' => '',
        'email' => '',
        'password' => ''
    ];
}

// Query untuk statistik
$stats = [
    'kmr' => $conn->query("SELECT COUNT(*) FROM kmr")->fetch_row()[0],
    'cust' => $conn->query("SELECT COUNT(*) FROM cust WHERE role != 'admin'")->fetch_row()[0],
    'transaksi' => $conn->query("SELECT COUNT(*) FROM transaksi")->fetch_row()[0]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard - Admin</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
  /* Sidebar styling */
  .offcanvas-start {
    width: 250px !important;
  }

  .sidebar {
    min-height: 50vh;
    background-color: #2c3e50;
    color: white;
    width: 250px;
    max-width: 80vw;
  }

  .sidebar .nav-link {
    color: rgba(255, 255, 255, 0.85);
    border-left: 3px solid transparent;
    margin-bottom: 8px;
    font-weight: 500;
    padding: 12px 20px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
  }

  .sidebar .nav-link i {
    margin-right: 12px;
    width: 22px;
    text-align: center;
    font-size: 1.1rem;
    transition: transform 0.2s;
  }

  .sidebar .nav-link:hover,
  .sidebar .nav-link.active {
    color: #ffffff;
    background-color: rgba(255, 255, 255, 0.15);
    border-left: 3px solid #3498db;
    text-decoration: none;
  }

  .sidebar .nav-link:hover i {
    transform: scale(1.2);
  }

  /* Stat card styling */
  .stat-card {
    border-radius: 10px;
    border: none;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
  }

  .stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }


  /* Online badge */
  .online-badge {
    width: 11px;
    height: 11px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 6px;
    vertical-align: middle;
  }

  /* Breadcrumb */
  .breadcrumb {
    background-color: transparent;
    padding: 0;
    margin-bottom: 0;
  }

  /* Navbar */
  nav.navbar {
    background-color: #3498db !important;
  }

  /* Footer */
  footer {
    padding: 15px 0;
    font-size: 0.9rem;
    color: #666;
    border-top: 1px solid #eaeaea;
    margin-top: 40px;
  }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #3498db;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <button class="btn text-white me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
          aria-controls="sidebarMenu">
          <i class="fas fa-bars fa-lg"></i>
        </button>
        <span class="navbar-brand mb-0 h1">Dashboard</span>
      </div>
      <div>
        <a href="../logout.php" class="btn btn-sm btn-outline-light">Logout <i class="fas fa-sign-out-alt"></i></a>
      </div>
    </div>
  </nav>


  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-12 col-md-3 col-lg-2 p-0">
        <div class="offcanvas offcanvas-start sidebar text-bg-dark" tabindex="-1" id="sidebarMenu"
          aria-labelledby="sidebarMenuLabel">
          <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title text-primary fw-bold" id="sidebarMenuLabel">Nexus Hotel</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
              aria-label="Close"></button>
          </div>
          <div class="offcanvas-body px-0 pt-3">
            <!-- Admin Info -->
            <div class="text-center mb-4 px-3">
              <h5 class="text-primary fw-bold mb-1"><?= htmlspecialchars($admin_data['nama']) ?></h5>
              <small class="text-success fw-semibold">
                <span class="online-badge bg-success"></span> Online
              </small>
              <hr class="bg-secondary my-3" />
              <h6 class="text-muted fw-normal mb-0">Dashboard Control Panel</h6>
            </div>

            <!-- Navigation Menu -->
            <ul class="nav flex-column px-3">
              <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i>
                  Dashboard</a></li>
              <li class="nav-item"><a class="nav-link" href="kamar.php"><i class="fas fa-bed"></i> Data
                  Kamar </a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-hotel"></i> gatau </a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-concierge-bell"></i>
                  Layanan Tambahan kali</a></li>
              <li class="nav-item"><a class="nav-link" href="tambah.php"><i class="fas fa-tags"></i> Tambah Kamar
                </a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-door-open"></i> Data
                  Kamar</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users"></i> Data
                  Customer</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-receipt"></i> Transaksi /
                  Booking</a></li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-file-alt"></i>
                  Laporan</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user-shield"></i> Data
                  Admin</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user-tie"></i> Data
                  Resepsionis</a></li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-key"></i> Ganti
                  Password</a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <main class="col-12 col-md-9 col-lg-10 px-4 py-4 d-flex flex-column min-vh-100 bg-light position-relative">
        <!-- Header -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center border-bottom pb-2 mb-4">
          <h1 class="h2 fw-bold">Dashboard</h1>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-4 mb-4">
          <div class="col-12 col-md-4 col-lg-3">
            <div class="card stat-card bg-success text-white">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="card-subtitle mb-1 fw-semibold">Jumlah Kamar</h6>
                  <h2 class="card-title fw-bold"><?= $stats['kmr'] ?></h2>
                </div>
                <i class="fas fa-door-open fa-3x opacity-75"></i>
              </div>
              <a href="kamar.php" class="text-white text-decoration-none px-3 pb-3 d-block text-end">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-12 col-md-4 col-lg-3">
            <div class="card stat-card bg-danger text-white">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="card-subtitle mb-1 fw-semibold">Jumlah Customer</h6>
                  <h2 class="card-title fw-bold"><?= $stats['cust'] ?></h2>
                </div>
                <i class="fas fa-users fa-3x opacity-75"></i>
              </div>
              <a href="#" class="text-white text-decoration-none px-3 pb-3 d-block text-end">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-12 col-md-4 col-lg-3">
            <div class="card stat-card bg-warning text-dark">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="card-subtitle mb-1 fw-semibold">Jumlah Transaksi</h6>
                  <h2 class="card-title fw-bold"><?= $stats['transaksi'] ?></h2>
                </div>
                <i class="fas fa-plus fa-3x opacity-75"></i>
              </div>
              <a href="#" class="text-dark text-decoration-none px-3 pb-3 d-block text-end">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Detail Login -->
        <div class="card mb-4">
          <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Detail Login</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label text-muted">Nama</label>
                  <p class="form-control-static"><?= htmlspecialchars($admin_data['nama']) ?></p>
                </div>
                <div class="mb-3">
                  <label class="form-label text-muted">Email</label>
                  <p class="form-control-static"><?= htmlspecialchars($admin_data['email'] ?? '-') ?>
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label text-muted">Telepon</label>
                  <p class="form-control-static"><?= htmlspecialchars($admin_data['telp'] ?? '-') ?>
                  </p>
                </div>
                <div class="mb-3">
                  <label class="form-label text-muted">Login Tools</label>
                  <p class="form-control-static" id="loginTools">Loading...</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <footer class="text-center mt-auto">
          <p class="mb-0 text-muted">&copy; <?= date('Y') ?> <?= htmlspecialchars($admin_data['nama']) ?> -
            Admin Nexus Hotel</p>
        </footer>
      </main>
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  function detectDevice() {
    const ua = navigator.userAgent.toLowerCase();
    if (/mobile|android|iphone|iemobile/.test(ua)) {
      return "Mobile Device";
    }
    if (/tablet|iPad|i/.test(ua)) {
      return "Tablet";
    }
    return "Web Browser";
  }

  document.getElementById('loginTools').textContent = detectDevice();
  </script>

</body>

</html>