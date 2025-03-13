<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';

// Ensure the player_id is passed through the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Player ID is missing or invalid in the URL.</div>";
    exit;
}

$player_id = $_GET['id'];

// Fetch player data to show confirmation details using a prepared statement
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $player = $result->fetch_assoc();
} else {
    echo "<div class='alert alert-danger'>Player not found or invalid ID.</div>";
    exit;
}

// Handle deletion request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Perform deletion using a prepared statement
    $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete_stmt->bind_param("i", $player_id);

    if ($delete_stmt->execute()) {
        echo "<div class='alert alert-success'>Player deleted successfully!</div>";
        // Redirect to the players list page
        header("Location: players_list.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Player</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url('https://path/to/football-background.jpg');
            background-size: cover;
            background-position: center;
            color: white;
        }
        .container {
            margin-top: 50px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
        }
        .form-label {
            font-size: 1.2rem;
        }
        .form-control {
            padding: 15px;
        }
        .btn-custom {
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #c82333;
        }
        .btn-back {
            background-color: #007bff;
            color: white;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Delete Player</h2>

    <div class="alert alert-warning text-center">
        <strong><i class="fas fa-exclamation-triangle"></i> Are you sure you want to delete this player?</strong>
    </div>

    <div class="card">
        <div class="card-header text-center">
            <h3><i class="fas fa-user-slash"></i> Delete Player: <?= htmlspecialchars($player['name']) ?></h3>
        </div>
        <div class="card-body text-center">
            <img src="uploads/<?= htmlspecialchars($player['photo']) ?>" class="img-fluid rounded-circle mb-3" alt="Player Photo" style="width: 150px; height: 150px;">
            <p><strong><i class="fas fa-futbol"></i> Position:</strong> <?= htmlspecialchars($player['position']) ?></p>
            <p><strong><i class="fas fa-user-check"></i> Status:</strong> <?= htmlspecialchars($player['status']) ?></p>
            <p><strong><i class="fas fa-envelope"></i> Email:</strong> <?= htmlspecialchars($player['email']) ?></p>

            <form method="POST">
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-trash-alt"></i> Confirm Deletion
                </button>
            </form>
            <a href="admin_dashboard.php" class="btn btn-back mt-3">
                <i class="fas fa-arrow-left"></i> Back to Player List
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap JS & Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
