<?php
session_start();
include '../db.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Insert a new doctor when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $query = "INSERT INTO doctors (name, specialization, phone, email) VALUES ('$name', '$specialization', '$phone', '$email')";
    mysqli_query($conn, $query);
}

// Delete a doctor if delete_id is provided
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM doctors WHERE id = $delete_id";
    mysqli_query($conn, $delete_query);
    header("Location: manage_doctors.php"); // Redirect to refresh the list
}

// Retrieve all doctors from the database
$query = "SELECT * FROM doctors";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Manage Doctors</title>
</head>
<body>
    <div class="container">
        <h1>Manage Doctors</h1>

        <!-- Doctor Form -->
        <form method="POST">
            <input type="text" name="name" placeholder="Doctor Name" required>
            <input type="text" name="specialization" placeholder="Specialization" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Add Doctor</button>
        </form>

        <h2>Doctor List</h2>

        <!-- Doctor Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['specialization']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['email']}</td>
                            <td><a href='?delete_id={$row['id']}'>Delete</a></td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No doctors found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
