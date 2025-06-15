<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Cek email sudah terdaftar
    $check = $koneksi->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        echo '<script>
                document.getElementById("emailExistsModal").style.display = "flex";
                setTimeout(function() {
                    document.getElementById("emailExistsModal").style.display = "none";
                }, 3000);
              </script>';
    } else {
        $stmt = $koneksi->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            header("Location: index.php?success=1");
            exit();
        } else {
            $error = "Pendaftaran gagal: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Daftar Akun Baru</h1>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group password-container">
                <label>Password</label>
                <input type="password" name="password" id="regPasswordField" required>
                <i class="fas fa-eye password-toggle" id="regTogglePassword"></i>
            </div>
            <button type="submit" class="btn">Daftar</button>
            <a href="index.php" class="btn-link">Sudah punya akun? Login</a>
        </form>
    </div>

    <!-- Modal Email Sudah Terdaftar -->
    <div class="modal" id="emailExistsModal">
        <div class="modal-content">
            <p>Email sudah terdaftar, silahkan login!</p>
        </div>
    </div>

    <script>
        // Toggle password visibility for registration form
        const regTogglePassword = document.querySelector('#regTogglePassword');
        const regPasswordField = document.querySelector('#regPasswordField');
        
        regTogglePassword.addEventListener('click', function() {
            const type = regPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
            regPasswordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>