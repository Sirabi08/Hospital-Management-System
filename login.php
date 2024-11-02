<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // 's' indicates the type is string

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] == 'doctor') {
                header("Location: doctor/dashboard.php");
            } elseif ($user['role'] == 'patient') {
                header("Location: patient/dashboard.php");
            }
            exit(); // Prevent further execution after redirect
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password"; // Generic message for security
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
    <style>
        /* Styles as before... */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            margin-bottom: 1em;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.8em;
            margin: 0.5em 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 0.8em;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
        .forgot-password {
            margin-top: 1em;
            font-size: 14px;
        }
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" onsubmit="return validateForm()">
            <input type="text" name="username" placeholder="Username" required aria-label="Username">
            <input type="password" name="password" placeholder="Password" required aria-label="Password">
            <button type="submit">Login</button>
        </form>
        <div class="forgot-password">
            <p><a href="#">Forgot Password?</a></p>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
