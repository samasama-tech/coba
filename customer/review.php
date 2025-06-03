<?php
session_start();
require('koneksi.php');

// Check if room type is provided
if (!isset($_GET['room'])) {
    header('Location: home.php');
    exit();
}

$roomType = htmlspecialchars($_GET['room']);

// Get room details from database - adjusted for your table structure
$stmt = $db->prepare("SELECT * FROM kmr WHERE type = ?");
$stmt->bind_param("s", $roomType);
$stmt->execute();
$room = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Calculate average rating for this room
$avgRatingQuery = $db->prepare("SELECT AVG(bintang) as avg_rating FROM review WHERE idxrrr = ?");
$avgRatingQuery->bind_param("i", $room['id']);
$avgRatingQuery->execute();
$avgResult = $avgRatingQuery->get_result();
$avgRating = $avgResult->fetch_assoc()['avg_rating'] ?? 0;
$avgRatingQuery->close();

// Get reviews for this room - adjusted for your review table structure
$stmt = $db->prepare("SELECT r.*, c.name as customer_name 
                     FROM review r
                     JOIN customer c ON r.id_cust = c.id_cust
                     WHERE r.idxrrr = ? 
                     ORDER BY r.created_at DESC");
$stmt->bind_param("i", $room['id']);
$stmt->execute();
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Review Kamar - <?= $roomType ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    .review-card {
        max-width: 800px;
        margin: 0 auto;
    }

    .room-image {
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }

    .star-rating {
        color: #ffc107;
    }

    .review-item {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .review-form {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <div class="card review-card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Review Kamar <?= $roomType ?></h4>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <img src="<?= $room['image'] ?>" class="img-fluid room-image" alt="<?= $roomType ?>">
                    </div>
                    <div class="col-md-6">
                        <h3><?= $roomType ?></h3>
                        <div class="star-rating mb-3">
                            <?php
                            $fullStars = floor($avgRating);
                            $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                            
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $fullStars) {
                                    echo '<i class="bi bi-star-fill fs-3"></i>';
                                } elseif ($i == $fullStars + 1 && $hasHalfStar) {
                                    echo '<i class="bi bi-star-half fs-3"></i>';
                                } else {
                                    echo '<i class="bi bi-star fs-3"></i>';
                                }
                            }
                            ?>
                            <span class="ms-2"><?= number_format($avgRating, 1) ?> (<?= count($reviews) ?>
                                reviews)</span>
                        </div>
                        <p><?= $room['description'] ?></p>
                    </div>
                </div>

                <h5 class="mb-3">Beri Nilai Kamar Ini</h5>
                <div class="review-form mb-5">
                    <form action="submit_review.php" method="POST">
                        <input type="hidden" name="idxrrr" value="<?= $room['id'] ?>">
                        <input type="hidden" name="id_cust" value="<?= $_SESSION['user']['id_cust'] ?? '' ?>">

                        <div class="mb-3">
                            <label class="form-label">Rating (1-5)</label>
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star rating-star fs-3" data-value="<?= $i ?>"
                                    style="cursor: pointer;"></i>
                                <?php endfor; ?>
                                <input type="hidden" name="bintang" id="ratingValue" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Komentar</label>
                            <textarea class="form-control" name="komen" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Review</button>
                    </form>
                </div>

                <h5 class="mb-3">Review Pelanggan</h5>
                <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold"><?= htmlspecialchars($review['customer_name']) ?></span>
                        <span class="text-muted"><?= date('d M Y', strtotime($review['created_at'])) ?></span>
                    </div>
                    <div class="star-rating mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $review['bintang']): ?>
                        <i class="bi bi-star-fill"></i>
                        <?php else: ?>
                        <i class="bi bi-star"></i>
                        <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <p><?= htmlspecialchars($review['komen']) ?></p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted">Belum ada review untuk kamar ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Star rating interaction
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.rating-star');
        const ratingValue = document.getElementById('ratingValue');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingValue.value = value;

                // Update star display
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.classList.remove('bi-star');
                        s.classList.add('bi-star-fill');
                    } else {
                        s.classList.remove('bi-star-fill');
                        s.classList.add('bi-star');
                    }
                });
            });
        });
    });
    </script>
</body>

</html>