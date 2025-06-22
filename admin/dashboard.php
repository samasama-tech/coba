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

        .container {
            margin-left: auto;
        }
        .card-body p {
        font-size: 1.1rem;
    }
    </style>
</head>

<body>
    
    <?php include 'navbar.php'
    ?>

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
                                <a href="dttransaksi.php" class="text-dark small">More info <i
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
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($admin_data['username']) ?> - Admin Nexus Hotel</p>
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