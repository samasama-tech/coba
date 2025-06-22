

<style>
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
</style>
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
            <a class="navbar-brand ms-2" href="dashboard.php">Nexus Hotel</a>
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