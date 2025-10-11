<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch the user record by email
    $stmt = $conn->prepare("SELECT * FROM tUser WHERE Email_id = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['Password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['User_id'] ?? null; 
            $_SESSION['username'] = $user['Name'];
            echo "<div class='alert alert-success text-center  position-fixed top-0 w-100'>Login successful! Welcome, " . htmlspecialchars($user['Name']) . ".</div>
             <script>
                    setTimeout(function() {
                        window.location.href = 'dashboard.php?user_id=" . $user['User_id'] . "';
                    }, 2000); // 2000ms = 2 seconds
                </script>";
            
        } else {
            echo "<div class='alert alert-danger text-center  position-fixed top-0 w-100'>Invalid password.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center  position-fixed top-0 w-100'>No account found with that email.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container ">
    <div class="row justify-content-center min-vh-100">
        <div class="col-md-5 h-50 my-auto">

            <div class="card shadow-sm p-4">
                <h2 class="text-center mb-4 text-primary">Login</h2>

                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    Don't have an account? <a href="register.php">Register here</a>
                </p>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
