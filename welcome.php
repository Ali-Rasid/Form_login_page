<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Anda berhasil login ke sistem.</p>
        
        <!-- Tombol Logout dengan Konfirmasi -->
        <button onclick="confirmLogout()" class="btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div class="modal" id="confirmLogoutModal">
        <div class="modal-content">
            <p>Apakah Anda yakin ingin logout?</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="proceedLogout()" class="btn" style="background-color: #4CAF50;">Ya</button>
                <button onclick="document.getElementById('confirmLogoutModal').style.display = 'none'" 
                        class="btn" style="background-color: #f44336;">Tidak</button>
            </div>
        </div>
    </div>

    <script>
        function confirmLogout() {
            document.getElementById('confirmLogoutModal').style.display = 'flex';
        }

        function proceedLogout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>