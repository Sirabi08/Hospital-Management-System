<?php
include('../db.php'); // Include database connection

// Fetch doctors
$doctors_query = "SELECT * FROM doctors";
$doctors_result = $conn->query($doctors_query);

// Fetch patients
$patients_query = "SELECT * FROM patients";
$patients_result = $conn->query($patients_query);

// Handle form submission for adding appointments
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_appointment'])) {
    $doctor_id = $_POST['doctor_id'];
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    // Check if form fields are not empty
    if ($doctor_id && $patient_id && $appointment_date && $appointment_time) {
        $insert_query = "INSERT INTO appointments (doctor_id, patient_id, appointment_date, appointment_time)
                         VALUES ('$doctor_id', '$patient_id', '$appointment_date', '$appointment_time')";
        if ($conn->query($insert_query) === TRUE) {
            echo "<p>Appointment added successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>All fields are required.</p>";
    }
}

// Fetch appointments
$appointments_query = "SELECT * FROM appointments";
$appointments_result = $conn->query($appointments_query);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css"> <!-- Link to CSS -->
</head>
<body>
    <header>
        <h1>Hospital Management System</h1>
    </header>

    <div class="container">
        <h2>Manage Appointments</h2>

        <!-- Add Appointment Form -->
        <form method="post" action="">
            <select name="doctor_id" required>
                <option value="">Select Doctor</option>
                <?php
                // Reopen connection to fetch doctors for the form
                $conn = new mysqli('localhost', 'root', '', 'hospital_management');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $doctors_result = $conn->query("SELECT * FROM doctors");
                while ($doctor = $doctors_result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($doctor['id']) . "'>" . htmlspecialchars($doctor['name']) . "</option>";
                }
                ?>
            </select>
            <select name="patient_id" required>
                <option value="">Select Patient</option>
                <?php
                // Fetch patients for the form
                $patients_result = $conn->query("SELECT * FROM patients");
                while ($patient = $patients_result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($patient['id']) . "'>" . htmlspecialchars($patient['name']) . "</option>";
                }
                ?>
            </select>
            <input type="date" name="appointment_date" required>
            <input type="time" name="appointment_time" required>
            <button type="submit" name="add_appointment">Add Appointment</button>
        </form>

        <!-- Appointment Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
            <?php
            // Reopen connection to fetch appointments
            $conn = new mysqli('localhost', 'root', '', 'hospital_management');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $appointments_result = $conn->query("SELECT * FROM appointments");

            if ($appointments_result->num_rows > 0) {
                while ($row = $appointments_result->fetch_assoc()) {
                    $doctor_query = $conn->query("SELECT name FROM doctors WHERE id={$row['doctor_id']}")->fetch_assoc();
                    $patient_query = $conn->query("SELECT name FROM patients WHERE id={$row['patient_id']}")->fetch_assoc();
                    
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($doctor_query['name']) . "</td>
                            <td>" . htmlspecialchars($patient_query['name']) . "</td>
                            <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                            <td>" . htmlspecialchars($row['appointment_time']) . "</td>
                            <td><a href='?delete_id=" . htmlspecialchars($row['id']) . "'>Delete</a></td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No appointments found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>


