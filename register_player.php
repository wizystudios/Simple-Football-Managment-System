<?php
session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collecting form data
    $name = validate_input($_POST['name']);
    $email = validate_input($_POST['email']);
    $phone = validate_input($_POST['phone']);
    $address = validate_input($_POST['address']);
    $gender = validate_input($_POST['gender']);
    $country = validate_input($_POST['country']);
    $role = validate_input($_POST['role']);
    $dob = validate_input($_POST['dob']);
    $position = validate_input($_POST['position']); // Position if the user is a player
    $coach_position = validate_input($_POST['coach_position']); // Coach role
    $photo = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $password = validate_input($_POST['password']); // Capturing password field

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Image upload path
    $photo_path = 'uploads/' . basename($photo);

    // Move uploaded image to the desired folder
    if (move_uploaded_file($photo_tmp, $photo_path)) {
        // Save player details
        $sql = "INSERT INTO users (name, email, phone, address, gender, country, role, position, coach_position, photo, dob, password) 
                VALUES ('$name', '$email', '$phone', '$address', '$gender', '$country', '$role', '$position', '$coach_position', '$photo', '$dob', '$hashed_password')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success text-center'>User registered successfully!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Error uploading the photo.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Player/Coach</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
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

        .register-form {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 800px;
        }

        .form-title {
            font-size: 35px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: #28a745;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid #28a745;
            border-radius: 5px;
            padding-left: 40px;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: #28a745;
        }

        .form-label {
            color: #fff;
            font-weight: bold;
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

        .form-group select {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid #28a745;
            padding-left: 40px;
        }

        .form-group select:focus {
            background-color: rgba(255, 255, 255, 0.3);
            border-color: #28a745;
        }

        .icon-input input {
            padding-left: 40px;
        }

        .btn-custom {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #218838;
        }

        .photo-preview {
            margin-top: 15px;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer i {
            margin-left: 5px;
        }

        .alert {
            margin-top: 20px;
        }

        .input-group-text {
            background-color: rgba(255, 255, 255, 0.2);
            color: #28a745;
        }

        .photo-preview img {
            max-width: 200px;
            border-radius: 10px;
        }

        /* Magic football icons in background */
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

    <div class="register-form">
        <h2 class="form-title"><i class="fas fa-user-plus"></i> Registration Page</h2>
        <form method="POST" enctype="multipart/form-data">
            
            <!-- Three columns layout for Name, Email, Phone -->
            <div class="row">
                <div class="col-md-4 form-group icon-input">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                    <i class="fas fa-user"></i>
                </div>
                <div class="col-md-4 form-group icon-input">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="col-md-4 form-group icon-input">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" id="phone" required>
                    <i class="fas fa-phone-alt"></i>
                </div>
            </div>

            <!-- Address, Gender, Country (3 columns layout) -->
            <div class="row">
                <div class="col-md-4 form-group icon-input">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" id="address" required>
                    <i class="fas fa-home"></i>
                </div>
                <div class="col-md-4 form-group icon-input">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" class="form-control" id="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <i class="fas fa-venus-mars"></i>
                </div>
                <div class="col-md-4 form-group icon-input">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" id="country" required>
                    <i class="fas fa-flag"></i>
                </div>
            </div>

            <!-- Date of Birth and Role Selection -->
            <div class="row">
                <div class="col-md-6 form-group icon-input">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" id="dob" required>
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="col-md-6 form-group">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-control" id="role" onchange="showRoleFields()">
                        <option value="admin">Admin</option>
                        <option value="player">Player</option>
                        <option value="coach">Coach</option>
                        <option value="doctor">Doctor</option>
                        <option value="physiotherapy">Physiotherapy</option>
                    </select>
                </div>
                <div class="col-md-4 form-group icon-input">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <!-- Role-specific fields -->
            <div id="positionField" style="display:none;">
                <label for="position" class="form-label">Position</label>
                <select name="position" class="form-control">
                    <option value="goalkeeper">Goalkeeper</option>
                    <option value="defender">Defender</option>
                    <option value="midfielder">Midfielder</option>
                    <option value="striker">Striker</option>
                </select>
            </div>

            <div id="coachPositionField" style="display:none;">
                <label for="coach_position" class="form-label">Coach Position</label>
                <select name="coach_position" class="form-control">
                    <option value="head_coach">Head Coach</option>
                    <option value="assistant_coach">Assistant Coach</option>
                    <option value="goalkeeper_coach">Goalkeeper Coach</option>
                </select>
            </div>

            <!-- Photo Upload -->
            <div class="form-group">
                <label for="photo" class="form-label">Upload Photo</label>
                <input type="file" name="photo" class="form-control" id="photo" accept="image/*" required>
                <div class="photo-preview" id="photoPreview"></div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-custom w-100">Register</button>
             <a href="index.php" class="btn btn-outline-light">Back to Home</a>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Football Team Registration <i class="fas fa-futbol"></i></p>
    </footer>

    <script>
        function showRoleFields() {
            const role = document.getElementById('role').value;
            if (role === 'player') {
                document.getElementById('positionField').style.display = 'block';
                document.getElementById('coachPositionField').style.display = 'none';
            } else if (role === 'coach') {
                document.getElementById('positionField').style.display = 'none';
                document.getElementById('coachPositionField').style.display = 'block';
            } else {
                document.getElementById('positionField').style.display = 'none';
                document.getElementById('coachPositionField').style.display = 'none';
            }
        }
    </script>

</body>
</html>
