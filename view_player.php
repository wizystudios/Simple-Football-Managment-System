<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "football_team_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the 'id' parameter exists and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id']; // Get the user ID from the URL

    // Prepare SQL query to fetch user details based on user ID
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameter to the SQL query
        mysqli_stmt_bind_param($stmt, "i", $user_id);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $user_result = mysqli_stmt_get_result($stmt);

        // Fetch user details
        $user = mysqli_fetch_assoc($user_result);

        // Close the statement
        mysqli_stmt_close($stmt);

        // Check if user exists
        if (!$user) {
            echo "User not found.";
            exit;
        }
    } else {
        die("Error preparing statement: " . mysqli_error($conn));
    }
} else {
    echo "Invalid user ID.";
    exit;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User - Football Team Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 15px 25px;
        }
        .user-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #007bff;
            margin-bottom: 20px;
        }
        .card-body {
            padding: 30px;
        }
        h3 {
            color: #007bff;
        }
        .card-body p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 10px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            font-size: 1.2rem;
            padding: 10px 20px;
            text-align: center;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .icon-size {
            font-size: 1.5rem;
            margin-right: 8px;
        }
        .back-btn {
            margin-top: 20px;
            display: inline-block;
        }
        .social-icons a {
            font-size: 1.5rem;
            color: #007bff;
            margin-right: 15px;
            text-decoration: none;
        }
        .social-icons a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">User Details</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="fas fa-user"></i> <?= htmlspecialchars($user['name']) ?></h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="uploads/<?= htmlspecialchars($user['photo']) ?>" class="user-photo" alt="User Photo">
                        
                        <p><strong><i class="fas fa-envelope icon-size"></i>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                        <p><strong><i class="fas fa-users icon-size"></i>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
                        <p><strong><i class="fas fa-check-circle icon-size"></i>Status:</strong> <?= htmlspecialchars($user['status']) ?></p>
                        <p><strong><i class="fas fa-soccer-ball icon-size"></i>Position:</strong> <?= htmlspecialchars($user['position']) ?></p>
                        
                        <div class="social-icons mt-4">
                            <a href="https://facebook.com/<?= htmlspecialchars($user['name']) ?>" target="_blank"><i class="fab fa-facebook-square"></i></a>
                            <a href="https://twitter.com/<?= htmlspecialchars($user['name']) ?>" target="_blank"><i class="fab fa-twitter-square"></i></a>
                            <a href="https://linkedin.com/in/<?= htmlspecialchars($user['name']) ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>

                        <a href="admin_dashboard.php" class="btn btn-custom mt-3 back-btn">
                            <i class="fas fa-arrow-left icon-size"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
