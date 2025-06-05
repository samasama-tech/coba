<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$activePages = ['rooms'];
$rooms = [
    [
        "title" => "Deluxe Room",
        "price" => 600000,
        "features" => ["Double Bed", "Balcony", "Kitchen"],
        "facilities" => ["Wifi, Ac, Luas 28m²"],
        "image" => "img/double.png",
        "rating" => 4.5 // Added rating
    ],
    [
        "title" => "Suite Room",
        "price" => 500000,
        "features" => ["Twin Bed", "Balcony", "Kitchen"],
        "facilities" => ["Wifi, Ac, Luas 20m²"],
        "image" => "img/twin.png",
        "rating" => 4.0 // Added rating
    ],
    [
        "title" => "Executive Room",
        "price" => 700000,
        "features" => ["King Bed", "Balcony", "Kitchen"],
        "facilities" => ["Wifi, Ac, Luas 35m²"],
        "image" => "img/king.png",
        "rating" => 4.8 // Added rating
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rooms - Nexus Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .star-rating {
        color: #ffc107;
        margin-bottom: 10px;
    }

    .review-btn {
        width: 100%;
        margin-top: 10px;
    }
    </style>
</head>

<body>

    <?php include 'navbar.php' ?>

    <!-- Rooms Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Our Rooms</h2>
        <div class="row g-4">
            <?php foreach ($rooms as $room): ?>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="<?= $room['image'] ?>" class="card-img-top" alt="Room Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $room['title'] ?></h5>
                        <p class="card-text fw-bold">Rp. <?= number_format($room['price'], 0, ',', '.') ?> per night</p>

                        <!-- Star Rating -->
                        <div class="star-rating">
                            <?php
                            $fullStars = floor($room['rating']);
                            $hasHalfStar = ($room['rating'] - $fullStars) > 0;
                            
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $fullStars) {
                                    echo '<i class="bi bi-star-fill"></i>';
                                } elseif ($i == $fullStars + 1 && $hasHalfStar) {
                                    echo '<i class="bi bi-star-half"></i>';
                                } else {
                                    echo '<i class="bi bi-star"></i>';
                                }
                            }
                            ?>
                            <span class="text-muted ms-2"><?= number_format($room['rating'], 1) ?></span>
                        </div>

                        <p><strong>Features:</strong> <?= implode(", ", $room['features']) ?></p>
                        <p><strong>Facilities:</strong> <?= implode(", ", $room['facilities']) ?></p>

                        <!-- Review Button -->
                        <button class="btn btn-outline-dark review-btn" data-bs-toggle="modal"
                            data-bs-target="#reviewModal">
                            <i class="bi bi-pencil-square"></i> Write a Review
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">
                        <i class="bi bi-star-fill text-warning me-2"></i>Write a Review
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="submit_review.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Select Room</label>
                            <select class="form-select" name="room" required>
                                <option value="">Select a room</option>
                                <option value="Deluxe Room">Deluxe Room</option>
                                <option value="Suite Room">Suite Room</option>
                                <option value="Executive Room">Executive Room</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Your Rating</label>
                            <div class="star-rating mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star rating-star" data-value="<?= $i ?>"
                                    style="cursor: pointer; font-size: 1.5rem;"></i>
                                <?php endfor; ?>
                                <input type="hidden" name="rating" id="ratingValue" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Your Review</label>
                            <textarea class="form-control" name="review" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark w-100">SUBMIT REVIEW</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>