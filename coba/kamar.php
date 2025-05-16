<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'hotel';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$tipe = "";
$kap = "";
$ci = "";
$co = "";
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipe = $_POST['tipe'] ?? '';
    $kap = $_POST['kap'] ?? '';
    $ci = $_POST['ci'] ?? '';
    $co = $_POST['co'] ?? '';

    // Query tipe kamar harus persis sama
    $stmt = $conn->prepare("SELECT * FROM kmr WHERE tipe = ? AND kap >= ?");
    $stmt->bind_param("si", $tipe, $kap);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        echo "Query error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pencarian Kamar Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container my-5">
    <h2 class="mb-4">Pencarian Kamar Hotel</h2>

    <form method="post" class="mb-5">
        <div class="mb-3">
            <label for="tipe" class="form-label">Tipe Kamar</label>
            <select name="tipe" id="tipe" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="Deluxe Room" <?= $tipe == 'Deluxe Room' ? 'selected' : '' ?>>Deluxe Room</option>
                <option value="Luxury Room" <?= $tipe == 'Luxury Room' ? 'selected' : '' ?>>Luxury Room</option>
                <option value="Supreme Deluxe Room" <?= $tipe == 'Supreme Deluxe Room' ? 'selected' : '' ?>>Supreme
                    Deluxe Room</option>
                <!-- Tambahkan tipe lain sesuai database jika perlu -->
            </select>
        </div>

        <div class="mb-3">
            <label for="kap" class="form-label">Kapasitas (orang)</label>
            <input type="number" name="kap" id="kap" class="form-control" min="1" value="<?= htmlspecialchars($kap) ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="ci" class="form-label">Check-in</label>
            <input type="date" name="ci" id="ci" class="form-control" value="<?= htmlspecialchars($ci) ?>" required>
        </div>

        <div class="mb-3">
            <label for="co" class="form-label">Check-out</label>
            <input type="date" name="co" id="co" class="form-control" value="<?= htmlspecialchars($co) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Cari Kamar</button>
    </form>

    <h4 class="mb-3">Hasil Pencarian</h4>
    <div class="mb-3">
        <p><strong>Tipe Kamar:</strong> <?= htmlspecialchars($tipe ?: '-') ?></p>
        <p><strong>Kapasitas:</strong> <?= htmlspecialchars($kap ?: '-') ?> orang</p>
        <p><strong>Check-in:</strong> <?= htmlspecialchars($ci ?: '-') ?></p>
        <p><strong>Check-out:</strong> <?= htmlspecialchars($co ?: '-') ?></p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No Kamar</th>
                <th>Tipe</th>
                <th>Fasilitas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nokmr']) ?></td>
                <td><?= htmlspecialchars($row['tipe']) ?></td>
                <td><?= htmlspecialchars($row['fasilitas']) ?></td>
                <td>
                    <span class="badge <?= $row['status'] == 'Kosong' ? 'bg-success' : 'bg-danger' ?>">
                        <?= htmlspecialchars($row['status']) ?>
                    </span>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php elseif ($result): ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada kamar tersedia sesuai pencarian Anda.</td>
            </tr>
            <?php else: ?>
            <tr>
                <td colspan="4" class="text-center text-muted">Silakan isi formulir di atas untuk mencari kamar.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>