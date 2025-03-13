<?php 
// Database connection
$servername = "localhost"; // Adjust if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "football_team_db"; // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch roles dynamically from the database (optional)
$roles = ['admin', 'player', 'doctor', 'coach', 'physiotherapy'];
$selected_role = 'admin'; // Default to 'admin'

// Handle role selection
if (isset($_POST['role'])) {
    $selected_role = $_POST['role'];
}

// Query based on role selection
$sql = "SELECT * FROM users WHERE role = '$selected_role'";
$role_results = mysqli_query($conn, $sql);

// Handle errors in the SQL query
if (!$role_results) {
    die("Error executing query: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Football Team Management</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        h1 {
            color: #007bff;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .btn-view, .btn-update, .btn-delete {
            font-size: 0.9rem;
        }
        .icon-size {
            font-size: 18px;
        }
        .table-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .dropdown {
            margin-bottom: 20px;
        }
        .select2-container--default .select2-selection--single {
            height: 38px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Admin Dashboard</h1>

        <!-- Role Selection Dropdown -->
        <form method="POST" action="">
            <div class="row justify-content-center mb-4">
                <div class="col-md-4">
                    <select name="role" class="form-control" onchange="this.form.submit()">
                        <option value="admin" <?= ($selected_role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="player" <?= ($selected_role == 'player') ? 'selected' : ''; ?>>Player</option>
                        <option value="doctor" <?= ($selected_role == 'doctor') ? 'selected' : ''; ?>>Doctor</option>
                        <option value="coach" <?= ($selected_role == 'coach') ? 'selected' : ''; ?>>Coach</option>
                        <option value="physiotherapy" <?= ($selected_role == 'physiotherapy') ? 'selected' : ''; ?>>Physiotherapy</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Table for the selected role -->
        <?php if (isset($role_results) && mysqli_num_rows($role_results) > 0): ?>
            <div class="card">
                <div class="card-header">
                    <h2><?= ucfirst($selected_role) ?>s</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($role_results)): ?>
                                <tr>
                                    <td><img src="uploads/<?= htmlspecialchars($row['photo']) ?>" class="table-icon" alt="User Photo"></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['role']) ?></td>
                                    <td>
                                    <a href="view_player.php?id=<?= urlencode($row['id']) ?>" class="btn btn-primary btn-sm btn-view">
                                        <i class="fas fa-eye icon-size"></i> View
                                    </a>
                                    <a href="update_player.php?id=<?= urlencode($row['id']) ?>" class="btn btn-warning btn-sm btn-update">
                                        <i class="fas fa-edit icon-size"></i> Update
                                    </a>
                                    <a href="delete_player.php?id=<?= urlencode($row['id']) ?>" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash-alt icon-size"></i> Delete
                                    </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                No users found for the selected role.
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="row mt-3">
            <div class="col-md-6">
                <a href="register_player.php" class="btn btn-custom btn-lg btn-block">
                    <i class="fas fa-plus-circle"></i> Register New User
                </a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <a href="login.php" class="btn btn-danger btn-lg btn-block">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
