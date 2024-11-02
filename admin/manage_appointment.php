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
                <?php while ($doctor = $doctors_result->fetch_assoc()) { ?>
                    <option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['name']; ?></option>
                <?php } ?>
            </select>
            <select name="patient_id" required>
                <option value="">Select Patient</option>
                <?php while ($patient = $patients_result->fetch_assoc()) { ?>
                    <option value="<?php echo $patient['id']; ?>"><?php echo $patient['name']; ?></option>
                <?php } ?>
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
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $doctor = $conn->query("SELECT name FROM doctors WHERE id={$row['doctor_id']}")->fetch_assoc();
                    $patient = $conn->query("SELECT name FROM patients WHERE id={$row['patient_id']}")->fetch_assoc();
                    
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$doctor['name']}</td>
                            <td>{$patient['name']}</td>
                            <td>{$row['appointment_date']}</td>
                            <td>{$row['appointment_time']}</td>
                            <td><a href='?delete_id={$row['id']}'>Delete</a></td>
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


