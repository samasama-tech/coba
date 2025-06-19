<?php
// Include file koneksi
session_start();
require_once '../koneksi.php';
$currentPage = 'dashboard';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Query untuk mengambil data admin (contoh: ambil admin pertama)
$email = $_SESSION['email'] ?? '';

if ($email) {
    $stmt = $conn->prepare("SELECT * FROM cust WHERE email = ? AND role = 'admin' LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin_data = $result->fetch_assoc();
    $stmt->close();
}

if (!$admin_data) {
    $admin_data = [
        'username' => 'Admin Default',
        'no_hp' => '-',
        'email' => '-',
        'password' => '-'
    ];
}


// Query statistik
$stats = [
    'kmr' => $conn->query("SELECT COUNT(*) FROM kmr")->fetch_row()[0],
    'cust' => $conn->query("SELECT COUNT(*) FROM cust WHERE role != 'admin'")->fetch_row()[0],
    'transaksi' => $conn->query("SELECT COUNT(*) FROM transaksi")->fetch_row()[0],
    'admin' => $conn->query("SELECT COUNT(*) FROM cust WHERE role = 'admin'")->fetch_row()[0]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* Hybrid Layout Styling */
        .offcanvas-custom {
            width: 50%;
            max-width: 250px;
        }

        .stat-card {
            border-radius: 10px;
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }

        /* Mobile offcanvas spacing fix */
        @media (max-width: 767.98px) {
            .main-content {
                padding: 10px !important;
            }

            .stat-card {
                margin-bottom: 15px;
            }
        }

        /* Desktop content center fix */
        @media (min-width: 992px) {
            .main-content .container {
                max-width: 1200px;
            }
        }

        .container {
            margin-left: auto;
        }
        .card-body p {
        font-size: 1.1rem;
    }
    </style>
</head>

<body>
    <!-- Navbar for Desktop -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-none d-lg-flex">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Nexus Hotel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'dashboard')
                            echo 'active'; ?>" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if ($currentPage == 'kamar' || $currentPage == 'tambah')
                            echo 'active'; ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            <i class="fas fa-bed"></i> &nbsp; Kamar
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?php if ($currentPage == 'tambah')
                                echo 'active'; ?>" href="tambah.php">Tambah Kamar</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item <?php if ($currentPage == 'kamar')
                                echo 'active'; ?>" href="kamar.php">Daftar Kamar</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if ($currentPage == 'dtadmin' || $currentPage == 'dtcust')
                            echo 'active'; ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            <i class="fas fa-user-tie"></i>&nbsp; Data Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?php if ($currentPage == 'dtadmin')
                                echo 'active'; ?>" href="dtadmin.php">Data Admin</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item <?php if ($currentPage == 'dtcust')
                                echo 'active'; ?>" href="dtcust.php">Data Customers</a></li>
                        </ul>
                    </li>

                </ul>
                <a href="../logout.php" class="btn btn-outline-light btn-sm"><i
                        class="fas fa-sign-out-alt me-1"></i>Logout</a>
            </div>
        </div>
    </nav>

    <!-- Navbar for Mobile (with Offcanvas) -->
    <nav class="navbar navbar-dark bg-dark d-lg-none">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand ms-2" href="#">Nexus Hotel</a>
        </div>
    </nav>

    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start text-bg-dark d-lg-none offcanvas-custom" id="mobileSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Nexus Hotel</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i
                            class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>

                <!-- Kamar -->
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                        href="#menuKamar" role="button" aria-expanded="false" aria-controls="menuKamar">
                        <div><i class="fas fa-bed"></i>&nbsp;Kamar</div>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="collapse" id="menuKamar">
                        <ul class="nav flex-column ms-3">
                            <li><a class="nav-link" href="tambah.php">Tambah Kamar</a></li>
                            <li><a class="nav-link" href="kamar.php">Daftar Kamar</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Data Account -->
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                        href="#menuAccount" role="button" aria-expanded="false" aria-controls="menuAccount">
                        <div><i class="fas fa-user-tie"></i>&nbsp; Data Account</div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </a>
                    <div class="collapse" id="menuAccount">
                        <ul class="nav flex-column ms-3">
                            <li><a class="nav-link" href="dtadmin.php">Data Admin</a></li>
                            <li><a class="nav-link" href="dtcust.php">Data Customers</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item mt-3"><a class="nav-link text-danger" href="../logout.php"><i
                            class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>


    <!-- Main Content -->
    <main class="main-content py-4">
        <div class="container">
            <h1 class="mb-4">Dashboard</h1>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Jumlah Kamar</h5>
                                <h2><?= $stats['kmr'] ?></h2>
                                <a href="kamar.php" class="text-white small">More info <i
                                        class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                            <i class="fas fa-door-open fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Jumlah Customer</h5>
                                <h2><?= $stats['cust'] ?></h2>
                                <a href="dtcust.php" class="text-white small">More info <i
                                        class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card bg-warning text-dark">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Jumlah Transaksi</h5>
                                <h2><?= $stats['transaksi'] ?></h2>
                                <a href="#" class="text-dark small">More info <i
                                        class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                            <i class="fas fa-receipt fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card bg-danger text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Jumlah Admin</h5>
                                <h2><?= $stats['admin'] ?></h2>
                                <a href="dtadmin.php" class="text-white small">More info <i
                                        class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                            <i class="fas fa-user-shield fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Detail login -->
            <div class="card shadow-lg rounded mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Detail Login</h5>
                </div>
                <div class="card-body row align-items-center">
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-person-circle" style="font-size: 100px; color: #6c757d;"></i>
                        </div class="mb-3">
                        <p class="mb-2"><strong><?= htmlspecialchars($admin_data['username']) ?></strong></p>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($admin_data['email'] ?? '-') ?>
                            </p>
                            <p class="mb-2"><strong>Telepon:</strong>
                                <?= htmlspecialchars($admin_data['no_hp'] ?? '-') ?></p>
                            <p class="mb-2"><strong>Login Tools:</strong> <span id="loginTools">Loading...</span></p>
                        </div>
                    </div>
                </div>
            </div>



            <footer class="mt-4 text-center text-muted">
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($admin_data['username']) ?> - Admin Ne Hotel</p>
            </footer>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showDeviceInfo() {
            const ua = navigator.userAgent;
            let browser = "Unknown", os = "Unknown";
            if (ua.includes("Firefox")) browser = "Firefox";
            else if (ua.includes("Chrome")) browser = "Chrome";
            else if (ua.includes("Safari")) browser = "Safari";
            else if (ua.includes("Edge")) browser = "Edge";

            if (ua.includes("Windows")) os = "Windows";
            else if (ua.includes("Mac")) os = "MacOS";
            else if (ua.includes("Linux")) os = "Linux";
            else if (ua.includes("Android")) os = "Android";
            else if (ua.includes("iPhone") || ua.includes("iPad")) os = "iOS";

            document.getElementById('loginTools').textContent = `${os} | ${browser}`;
        }
        document.addEventListener('DOMContentLoaded', showDeviceInfo);
    </script>
</body>

</html>