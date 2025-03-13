<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';

// Validate and fetch player ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid or missing Player ID in the URL.</div>";
    exit;
}
$player_id = $_GET['id'];

// Fetch player data using a prepared statement
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $position = validate_input($_POST['position']);
    $status = validate_input($_POST['status']);

    // Update player data using a prepared statement
    $update_stmt = $conn->prepare("UPDATE users SET position = ?, status = ? WHERE id = ?");
    $update_stmt->bind_param("ssi", $position, $status, $player_id);

    if ($update_stmt->execute()) {
        $success_message = "Player updated successfully!";
    } else {
        $error_message = "Error updating player: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url('https://path/to/football-background.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .form-label {
            font-size: 1.2rem;
            color: #f8f9fa;
        }
        .form-control {
            padding: 15px;
            border-radius: 5px;
            font-size: 1rem;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            font-size: 1.1rem;
            padding: 12px 20px;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .alert {
            margin-top: 20px;
            padding: 10px;
            font-size: 1.1rem;
        }
        .alert-success {
            background-color: #28a745;
            color: white;
        }
        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Update Player Details</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="position" class="form-label">Position <i class="fas fa-futbol"></i></label>
            <select name="position" class="form-control" required>
                <option value="Goalkeeper" <?= $player['position'] == 'Goalkeeper' ? 'selected' : '' ?>>Goalkeeper</option>
                <option value="Defensive" <?= $player['position'] == 'Defensive' ? 'selected' : '' ?>>Defensive</option>
                <option value="Midfielder" <?= $player['position'] == 'Midfielder' ? 'selected' : '' ?>>Midfielder</option>
                <option value="Striker" <?= $player['position'] == 'Striker' ? 'selected' : '' ?>>Striker</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status <i class="fas fa-user-check"></i></label>
            <select name="status" class="form-control" required>
                <option value="active" <?= $player['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="injured" <?= $player['status'] == 'injured' ? 'selected' : '' ?>>Injured</option>
                <option value="retired" <?= $player['status'] == 'retired' ? 'selected' : '' ?>>Retired</option>
                <option value="on_leave" <?= $player['status'] == 'on_leave' ? 'selected' : '' ?>>On Leave</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-custom"><i class="fas fa-save icon-size"></i> Update Player</button>
            <a href="admin_dashboard.php" class="btn btn-secondary ms-3">Back</a>
        </div>
    </form>

    <!-- Display success or error messages -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
