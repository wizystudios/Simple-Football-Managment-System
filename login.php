<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Prepared statement to prevent SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: user_dashboard.php');
            }
            exit();
        } else {
            echo "<script>alert('Invalid email or password! Please try again.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all fields!');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://your-football-background-image-url.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        @keyframes moveBackground {
            0% { background-position: 0 0, 100px 100px; }
            100% { background-position: 100px 100px, 0 0; }
        }

        .login-form {
            background-color: rgba(0, 123, 255, 0.85); /* Blue with opacity */
            color: white;
            padding: 40px;
            border-radius: 15px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 20px;
            padding: 12px 20px;
            font-size: 18px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            transition: background-color 0.3s;
        }

        .football-icon {
            font-size: 2rem;
            color: #ffcc00;
            margin-right: 8px;
        }

        .login-header {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: white;
            font-size: 16px;
            padding: 10px 0;
            background-color: #343a40; /* Same as your register page footer */
        }

        .icon-input {
            position: relative;
        }

        .icon-input i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #28a745;
        }
        .icon-input input {
            padding-left: 40px;
        }

        footer i {
            color: #ffcc00;
        }
        .magic-icons {
            position: absolute;
            top: 10%;
            left: 10%;
            right: 10%;
            bottom: 10%;
            pointer-events: none;
            z-index: -1;
            opacity: 0.2;
            animation: floating-icons 8s infinite ease-in-out;
        }

        @keyframes floating-icons {
            0% { transform: translate(0, 0); }
            25% { transform: translate(10%, -10%); }
            50% { transform: translate(-10%, 10%); }
            75% { transform: translate(0, 10%); }
            100% { transform: translate(0, 0); }
        }

        .magic-icons i {
            font-size: 50px;
            color: #28a745;
            position: absolute;
            opacity: 0.5;
            animation: floating-icons 10s infinite ease-in-out;
        }

        .magic-icons i:nth-child(1) { top: 0; left: 50%; }
        .magic-icons i:nth-child(2) { top: 20%; left: 70%; }
        .magic-icons i:nth-child(3) { top: 50%; left: 30%; }
        .magic-icons i:nth-child(4) { top: 80%; left: 10%; }
        .magic-icons i:nth-child(5) { top: 60%; left: 90%; }

    </style>
</head>
<body>
<div class="magic-icons">
        <i class="fas fa-futbol"></i>
        <i class="fas fa-trophy"></i>
        <i class="fas fa-soccer-ball"></i>
        <i class="fas fa-shield-alt"></i>
        <i class="fas fa-futbol"></i>
    </div>


    <!-- Login Form Section -->
    <div class="login-form">
        <h2 class="login-header"><i class="fas fa-sign-in-alt football-icon"></i>Login</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required placeholder="Enter your password">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-custom btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </div>
        </form>

        <!-- Home Link/Button -->
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-light">Back to Home</a>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 Football Team Management System. <i class="fas fa-futbol"></i></p>
    </footer>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
