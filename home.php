<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$activePages = ['home'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Get Hotels</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <?php include 'navbar.php'
        ?>

    <!-- Booking Form -->
    <div class="container my-5">
        <div class="bg-light p-4 rounded shadow">
            <h4>Check Booking Availability</h4>
            <form action="kamar.php" id="bookingForm" method="POST" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Check-in</label>
                    <input type="date" name="ci" id="ci" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Check-out</label>
                    <input type="date" name="co" id="co" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kapasitas</label>
                    <select name="kap" class="form-select">
                        <?php for ($i = 1; $i <= 2; $i++)
                            echo "<option>$i</option>"; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="tipe" class="form-select" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Deluxe Room">Deluxe Room</option>
                        <option value="Suite Room">Suite Room</option>
                        <option value="Executive Room">Executive Room</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" id="bookingSubmit" class="btn btn-success w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lokasi -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Lokasi Kami</h2>
            <div class="ratio ratio-16x9 shadow-sm rounded">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.992047245303!2d115.1374700501162!3d-8.786816156588177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2448af6f410a5%3A0x313ee67691a146ca!2sAYANA%20Resort%20Bali!5e0!3m2!1sid!2sid!4v1748408708735!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <p class="text-center mt-3">Terletak di pusat kota dengan akses mudah ke berbagai tempat menarik.</p>
        </div>
    </section>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const isLoggedIn = <?= (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) ? 'true' : 'false' ?>;

        document.getElementById('bookingForm').addEventListener('submit', function (event) {
            if (!isLoggedIn) {
                event.preventDefault();
                const alertLoginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                alertLoginModal.show();
                return;
            }

            const ci = document.getElementById('ci').value;
            const co = document.getElementById('co').value;

            if (ci === '' || co === '') {
                return;
            }

            if (ci > co) {
                event.preventDefault();
                alert('Tanggal check-out harus lebih besar dari tanggal check-in!');
            }
        });
    </script>


</body>

</html>