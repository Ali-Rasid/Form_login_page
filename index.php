<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            echo '<script>
                    document.getElementById("loadingModal").style.display = "flex";
                    setTimeout(function() {
                        window.location.href = "welcome.php";
                    }, 5000);
                  </script>';
            exit();
        } else {
            echo '<script>
                    document.getElementById("errorModal").style.display = "flex";
                    setTimeout(function() {
                        document.getElementById("errorModal").style.display = "none";
                    }, 3000);
                  </script>';
        }
    } else {
        echo '<script>
                document.getElementById("errorModal").style.display = "flex";
                setTimeout(function() {
                    document.getElementById("errorModal").style.display = "none";
                }, 3000);
              </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" id="loginForm">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group password-container">
                <label>Password</label>
                <input type="password" name="password" id="passwordField" required>
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
            </div>
            <button type="submit" class="btn">Login</button>
            <a href="register.php" class="btn-link">Daftar</a>
        </form>
    </div>

    <!-- Modal Error -->
    <div class="modal" id="errorModal">
        <div class="modal-content">
            <p>Data kamu salah!</p>
        </div>
    </div>

    <!-- Modal Loading -->
    <div class="modal loading-modal" id="loadingModal">
        <div class="modal-content">
            <div class="spinner"></div>
            <p>Selamat datang!</p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#passwordField');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>