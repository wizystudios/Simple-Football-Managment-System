<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Team Management</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            background-image: url('https://example.com/football-bg.jpg'); /* Replace with your football background image URL */
            background-size: cover;
            background-position: center;
        }
        .hero-section {
            background-color: rgba(0, 123, 255, 0.7); /* Blue with opacity */
            color: white;
            padding: 60px 0;
            border-radius: 10px;
        }
        .hero-text {
            font-size: 3rem;
        }
        .nav-link {
            color: white !important;
        }
        .nav-link:hover {
            color: #ffcc00 !important;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .football-icon {
            font-size: 2rem;
            color: #ffcc00;
            margin-right: 8px;
        }
        footer {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="hero-text">Welcome to the Football Team Management System</h1>
            <p class="lead">Manage your football team with ease - registration, player management, and more!</p>
            <a href="login.php" class="btn btn-custom btn-lg">
                <i class="fas fa-sign-in-alt"></i> Login 
            </a>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-futbol football-icon"></i> Football Team
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register_player.php"><i class="fas fa-user-plus"></i> Register Player</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-users"></i> View Players</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Manage Your Team Efficiently</h2>
                <p class="lead">Our system allows you to add, update, and manage players and staff easily.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 mt-5">
        <p>&copy; 2025 Football Team Management System. <i class="fas fa-futbol"></i></p>
    </footer>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
