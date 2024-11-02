<?php
include('../db.php'); // Include your database connection file

// Fetch reports or data for the report
$reports_query = "SELECT a.id, d.name AS doctor_name, p.name AS patient_name, a.appointment_date, a.appointment_time
                  FROM appointments a
                  JOIN doctors d ON a.doctor_id = d.id
                  JOIN patients p ON a.patient_id = p.id";

$reports_result = $conn->query($reports_query);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css"> <!-- Link to CSS -->
    <title>Reports</title>
</head>
<body>
    <header>
        <h1>Hospital Management System</h1>
    </header>

    <div class="container">
        <h2>Appointment Reports</h2>

        <!-- Report Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php
            if ($reports_result->num_rows > 0) {
                while ($row = $reports_result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                            <td>" . htmlspecialchars($row['patient_name']) . "</td>
                            <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                            <td>" . htmlspecialchars($row['appointment_time']) . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No reports found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

