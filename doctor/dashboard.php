<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'doctor') {
    header("Location: ../login.php");
    exit;
}

$doctor_id = $_SESSION['user_id'];
$query = "SELECT * FROM appointments WHERE doctor_id = $doctor_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Doctor Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Doctor Dashboard</h1>
        <h2>Your Appointments</h2>
        <ul>
            <?php while ($appointment = mysqli_fetch_assoc($result)): ?>
                <li><?php echo $appointment['appointment_date'] . " " . $appointment['appointment_time']; ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
