<?ph<?php
include('../db.php'); // Include database connection

// Fetch current settings
$settings_query = "SELECT * FROM settings";
$settings_result = $conn->query($settings_query);

// Initialize an array to hold current settings
$current_settings = [];

// Check if the query was successful and fetch results
if ($settings_result && $settings_result->num_rows > 0) {
    while ($row = $settings_result->fetch_assoc()) {
        $current_settings[$row['setting_name']] = $row['setting_value'];
    }
}

// Handle form submission for updating settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hospital_name = $_POST['hospital_name'];
    $contact_number = $_POST['contact_number'];

    // Update settings in the database
    $update_query = "UPDATE settings SET setting_value = CASE 
                    WHEN setting_name = 'Hospital Name' THEN '$hospital_name' 
                    WHEN setting_name = 'Contact Number' THEN '$contact_number' 
                    END 
                    WHERE setting_name IN ('Hospital Name', 'Contact Number')";

    if ($conn->query($update_query) === TRUE) {
        echo "<p style='color: green;'>Settings updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error updating settings: " . $conn->error . "</p>";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        .feedback {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Settings</h1>
        
        <form method="post" action="">
            <div class="feedback">
                <?php
                if (isset($success_message)) {
                    echo "<p style='color: green;'>$success_message</p>";
                }
                if (isset($error_message)) {
                    echo "<p style='color: red;'>$error_message</p>";
                }
                ?>
            </div>
            <label for="hospital_name">Hospital Name:</label>
            <input type="text" id="hospital_name" name="hospital_name" value="<?php echo isset($current_settings['Hospital Name']) ? htmlspecialchars($current_settings['Hospital Name']) : ''; ?>" required>
            
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="<?php echo isset($current_settings['Contact Number']) ? htmlspecialchars($current_settings['Contact Number']) : ''; ?>" required>
            
            <button type="submit">Update Settings</button>
        </form>
    </div>
</body>
</html>


