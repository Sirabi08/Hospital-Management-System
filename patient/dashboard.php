<?php
session_start();
include '../db.php';
if ($_SESSION['role'] != 'patient') {
    header("Location: ../login.php");
    exit;
}

$patient_id = $_SESSION['user_id'];
$query = "SELECT * FROM medical_records WHERE patient_id = $patient_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Patient Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Patient Dashboard</h1>
        <h2>Your Medical Records</h2>
        <ul>
            <?php while ($record = mysqli_fetch_assoc($result)): ?>
                <li><?php echo $record['record_date'] . " - " . $record['description']; ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
