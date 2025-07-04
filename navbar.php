<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
    .custom-navbar {
        background-color: #261fb3;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    @media (max-width: 576px) {
        .navbar-brand {
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
        }

        .navbar-toggler {
            padding: 0.25rem 0.5rem;
        }
    }

    .nav-pills .nav-link {
        padding: 4px 10px;
        border-radius: 6px;
        color: white;
    }

    .nav-pills .nav-link.active {
        background-color: $primary;
        color: white !important;
        padding: 4px 10px;
        border-radius: 6px;
    }


    #togglePassword {
        position: absolute;
        top: 43px;
        right: 20px;
        cursor: pointer;
        color: #6c757d;
        font-size: 1.25rem;
        z-index: 10;
    }

    /* Tambahkan padding agar input tidak tertimpa ikon */
    #passwordInput {
        padding-right: 2.75rem;
        /* Ruang untuk icon */
    }

    /* Responsive untuk layar kecil */
    @media (max-width: 576px) {
        #togglePassword {
            right: 15px;
            font-size: 1.1rem;
        }
    }
</style>

<nav class="navbar navbar-expand-lg custom-navbar px-4 py-2">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <img src="img/favicon.ico" alt="Nexus Hotels Logo" class="img-fluid" style="width: 40px; height: 40px;">
        <span class="fs-5 fw-bold text-white">Nexus Hotels</span>
    </a>
    <button class="navbar-toggler bg-white border border-dark" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="nav nav-pills me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link <?= in_array('home', $activePages ?? []) ? 'active' : '' ?>"
                    href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= in_array('rooms', $activePages ?? []) ? 'active' : '' ?>"
                    href="rooms.php">Rooms</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= in_array('facilities', $activePages ?? []) ? 'active' : '' ?>"
                    href="facilities.php">Facilities</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= in_array('about', $activePages ?? []) ? 'active' : '' ?>"
                    href="about.php">About</a>
            </li>
        </ul>

        <?php if (!empty($_SESSION['loggedin'])): ?>
            <div class="dropdown">
                <a class="d-inline-flex align-items-center text-light text-decoration-none dropdown-toggle fw-bold" href="#"
                    role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-fill me-1" style="font-size: 1.4rem;"></i>
                    Hi,
                    <?= htmlspecialchars($username) ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" style="min-width: 180px;">
                    <li><a class="dropdown-item" href="profile.php">Ubah Profil</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <button class="btn btn-light me-2 text-dark" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="btn btn-primary text-white" data-bs-toggle="modal"
                data-bs-target="#registerModal">Register</button>
        <?php endif; ?>
    </div>
</nav>

<!-- Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white" style="background: #261fb3;">
                <h5 class="modal-title" id="loginModalLabel">
                    <i class="bi bi-box-arrow-in-right me-2"></i> User Login
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="login.php" method="POST">
                <div class="modal-body bg-light rounded-bottom-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg rounded-3"
                            placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-2 position-relative">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" id="passwordInput"
                            class="form-control form-control-lg rounded-3 pe-5" placeholder="Masukkan password"
                            required>
                        <i class="bi bi-eye-slash" id="togglePassword"
                            style="position: absolute; right: 15px; top: 42px; cursor: pointer;"></i>
                    </div>
                    <div class="text-end mb-3">
                        <a href="#" class="text-decoration-none text-primary small" data-bs-toggle="modal"
                            data-bs-target="#lupaPasswordModal">
                            Lupa Password?
                        </a>
                    </div>

                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="submit" class="btn btn-primary w-100">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #261fb3;">
                <h5 class="modal-title" id="registerModalLabel">
                    <i class="bi bi-person-plus me-2"></i> User Registration
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="register.php" method="POST" enctype="multipart/form-data" onsubmit="return validateRegister()"
                id="formRegister">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Name</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="no_hp" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="reg_password" minlength="3" class="form-control"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="cpassword" id="reg_cpassword" class="form-control" required>
                            <div id="registerPasswordMismatch" class="text-danger small d-none mt-1">
                                Password dan konfirmasi tidak cocok.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">REGISTER</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Lupa Password -->
<div class="modal fade" id="lupaPasswordModal" tabindex="-1" aria-labelledby="lupaPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white" style="background: #261fb3;">
                <h5 class="modal-title" id="lupaPasswordModalLabel">
                    <i class="bi bi-key me-2"></i> Reset Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="lupa_pw.php" method="POST" onsubmit="return validateResetPassword()" id="formResetPassword">
                <div class="modal-body bg-light rounded-bottom-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg rounded-3"
                            placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru</label>
                        <input type="password" name="password_baru" id="reset_password" minlength="3"
                            class="form-control form-control-lg rounded-3" placeholder="Password baru" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" id="reset_cpassword" minlength="3"
                            class="form-control form-control-lg rounded-3" placeholder="Konfirmasi password" required>
                        <div id="resetPasswordMismatch" class="text-danger small d-none mt-1">
                            Password dan konfirmasi tidak cocok.
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateRegister() {
        const pass = document.getElementById("reg_password");
        const confirm = document.getElementById("reg_cpassword");
        const errorDiv = document.getElementById("registerPasswordMismatch");

        if (pass.value !== confirm.value) {
            errorDiv.classList.remove("d-none");
            confirm.reportValidity();
            return false;
        } else {
            errorDiv.classList.add("d-none");
            confirm.setCustomValidity("");
            return true;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const pass = document.getElementById("reg_password");
        const confirm = document.getElementById("reg_cpassword");
        const errorDiv = document.getElementById("registerPasswordMismatch");

        [pass, confirm].forEach(input => {
            input.addEventListener('input', function () {
                confirm.setCustomValidity('');
                errorDiv.classList.add("d-none");
            });
        });
    });
</script>

<script>
    function validateResetPassword() {
        const pass = document.getElementById("reset_password");
        const confirm = document.getElementById("reset_cpassword");
        const errorDiv = document.getElementById("resetPasswordMismatch");

        if (pass.value !== confirm.value) {
            errorDiv.classList.remove("d-none");
            confirm.reportValidity();
            return false;
        } else {
            errorDiv.classList.add("d-none");
            confirm.setCustomValidity("");
            return true;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const pass = document.getElementById("reset_password");
        const confirm = document.getElementById("reset_cpassword");
        const errorDiv = document.getElementById("resetPasswordMismatch");

        [pass, confirm].forEach(input => {
            input.addEventListener('input', function () {
                confirm.setCustomValidity('');
                errorDiv.classList.add("d-none");
            });
        });
    });
</script>


<script>
    const togglePassword = document.querySelector("#togglePassword");
    const passwordInput = document.querySelector("#passwordInput");

    togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);

        // Ganti ikon
        this.classList.toggle("bi-eye");
        this.classList.toggle("bi-eye-slash");
    });
</script>