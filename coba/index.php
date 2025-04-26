<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Get Hotels</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .custom-navbar {
            background-color: #ced4da; /* Light gray */
        }

        .nav-pills .nav-link {
            color: black;
        }

        .nav-pills .nav-link.active {
            background-color: #adb5bd; /* Darker gray for active tab */
            color: black !important;
        }

        .nav-pills .nav-link {
            border-radius: 0.5rem; /* To give rounded corners */
            margin-right: 5px; /* Spacing between links */
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg custom-navbar px-4">
    <a class="navbar-brand fw-bold" href="#">Get Hotels</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-3 mb-lg-0 nav-pills">
            <li class="nav-item">
                <a class="nav-link px-3" aria-current="page" href="home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3 active" href="rooms.php">Rooms</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="facilities.php">Facilities</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="about.php">About</a>
            </li>
        </ul>
        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-primary">Register</button>
    </div>
</nav>

<!-- ... rest of your code ... -->

</body>
</html>