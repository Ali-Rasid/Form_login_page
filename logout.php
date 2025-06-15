<?php
session_start();

// Tambahkan animasi loading sebelum logout
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Simpan username untuk pesan selamat tinggal
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Modal Konfirmasi Logout -->
    <div class="modal" id="logoutModal" style="display: flex;">
        <div class="modal-content">
            <div class="spinner"></div>
            <p>See you again, <?php echo htmlspecialchars($username); ?>!</p>
            <p>Logging out...</p>
        </div>
    </div>

    <script>
        // Tampilkan animasi selama 3 detik sebelum benar-benar logout
        setTimeout(function() {
            // Hancurkan sesi
            fetch('do_logout.php')
                .then(() => {
                    window.location.href = 'index.php';
                });
        }, 3000);
    </script>
</body>
</html>