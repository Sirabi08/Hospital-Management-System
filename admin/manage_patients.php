<?php
include('../db.php'); // Include the database connection

// Initialize $result
$result = null;

// Check if form is submitted to add a new patient
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_patient'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepare and execute insert query
    $stmt = $conn->prepare("INSERT INTO patients (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);
    if ($stmt->execute()) {
        echo "Patient added successfully.";
    } else {
        echo "Error adding patient: " . $conn->error;
    }
    $stmt->close();
}

// Check if a delete request is sent
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM patients WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "Patient deleted successfully.";
    } else {
        echo "Error deleting patient: " . $conn->error;
    }
    $stmt->close();

    // Redirect to avoid multiple deletions on page refresh
    header("Location: manage_patients.php");
    exit;
}

// Fetch patients from database
$result = $conn->query("SELECT * FROM patients");

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Patients</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Hospital Management System</h1>
    </header>

    <div class="container">
        <h2>Manage Patients</h2>

        <!-- Add Patient Form -->
        <form method="post" action="">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <button type="submit" name="add_patient">Add Patient</button>
        </form>

        <!-- Patient Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td><a href='?delete_id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this patient?');\">Delete</a></td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No patients found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
