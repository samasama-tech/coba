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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand fw-bold" href="#">Get Hotels</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Facilities</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contact us</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        </ul>
        <!-- Trigger Login Modal -->
        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-primary">Register</button>
    </div>
</nav>

<!-- Booking Form -->
<div class="container my-5">
    <div class="bg-light p-4 rounded shadow">
        <h4>Check Booking Availability</h4>
        <form action="search.php" method="POST" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Check-in</label>
                <input type="date" name="checkin" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Check-out</label>
                <input type="date" name="checkout" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Adult</label>
                <select name="adults" class="form-select">
                    <?php for ($i = 1; $i <= 10; $i++) echo "<option>$i</option>"; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Children</label>
                <select name="children" class="form-select">
                    <?php for ($i = 0; $i <= 5; $i++) echo "<option>$i</option>"; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Rooms Section -->
<div class="container my-5">
    <h2 class="text-center mb-4">Our Rooms</h2>
    <div class="row g-4">
        <?php
        $rooms = [
            ["title" => "Supreme deluxe room", "price" => 900, "features" => ["bedroom", "balcony", "kitchen"], "facilities" => ["Wifi", "Air conditioner", "Room Heater", "Geyser"]],
            ["title" => "Luxury Room", "price" => 600, "features" => ["bedroom", "balcony", "kitchen"], "facilities" => ["Wifi", "Air conditioner", "Room Heater"]],
            ["title" => "Deluxe Room", "price" => 500, "features" => ["bedroom", "balcony", "kitchen"], "facilities" => ["Air conditioner", "Room Heater", "Geyser"]],
        ];

        foreach ($rooms as $room) {
            echo '<div class="col-md-4">';
            echo '<div class="card shadow-sm h-100">';
            echo '<img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Room Image">';
            echo '<div class="card-body">';
            echo "<h5 class='card-title'>{$room['title']}</h5>";
            echo "<p class='card-text fw-bold'>₹{$room['price']} per night</p>";
            echo "<p><strong>Features:</strong> " . implode(", ", $room['features']) . "</p>";
            echo "<p><strong>Facilities:</strong> " . implode(", ", $room['facilities']) . "</p>";
            echo '</div></div></div>';
        }
        ?>
    </div>
</div>

<!-- Login Modal -->
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
            <label class="form-label">Email / Username</label>
            <input type="text" name="username" class="form-control" required>
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
              <input type="text" name="name" class="form-control" required>
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
              <label class="form-label">Picture</label>
              <input type="file" name="picture" class="form-control">
            </div>

            <div class="col-md-12">
              <label class="form-label">Address</label>
              <textarea name="address" rows="2" class="form-control" required></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label">Pincode</label>
              <input type="text" name="pincode" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date of Birth</label>
              <input type="date" name="dob" class="form-control" required>
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


<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
