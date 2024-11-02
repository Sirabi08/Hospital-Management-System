<?php
// Feedback form processing
$feedbackSubmitted = false;
$nameChanged = false; // Flag to indicate name change status

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle feedback submission
    if (isset($_POST['feedback'])) {
        $feedback = htmlspecialchars($_POST['feedback']); // Sanitize input
        $feedbackSubmitted = true;
    }

    // Handle name change
    if (isset($_POST['new_name'])) {
        $newName = htmlspecialchars($_POST['new_name']); // Sanitize input
        // Here you would typically update the name in your database
        // For this example, we will just set the flag
        // (You may need to implement actual database logic)
        $nameChanged = true; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Hospital Management System</title>
</head>
<body>
<header>
    <div class="container">
        <h1>Hospital Management System</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </div>
</header>

<section id="home" class="home">
    <div class="container">
        <h2>Providing Quality Healthcare</h2>
        <p>Welcome to our hospital management system, where we manage appointments, patients, and doctors with the utmost efficiency. Our commitment to patient care is unwavering, and we strive to provide the best healthcare services to our community.</p>
        <p>With a focus on patient-centered care, our system integrates advanced technology to streamline healthcare operations. We aim to create a seamless experience for our patients, ensuring they receive timely and effective treatment.</p>
        <p>Join us as we embrace innovation and technology to enhance the healthcare experience. Our hospital is equipped with state-of-the-art facilities and a dedicated team of professionals ready to assist you.</p>
        <p>Explore our services to discover how we can meet your healthcare needs effectively!</p>
    </div>
</section>

<section id="about" class="about">
    <div class="container">
        <h2>About Us</h2>
        <p>Our hospital management system simplifies the administration of healthcare facilities, streamlining processes for managing patient records, doctor schedules, and appointments. Our system is designed to enhance the operational efficiency of healthcare institutions, ensuring that all stakeholders—from patients to administrators—have access to the information they need.</p>
        <p>Our dedicated team of healthcare professionals and IT experts work together to create a system that prioritizes patient care and operational efficiency. Our goal is to improve the quality of healthcare while reducing administrative burdens.</p>
        <p>We believe in transparency, communication, and continuous improvement, and we are committed to adapting to the ever-changing needs of the healthcare landscape.</p>
        <p>Our vision is to be the leading provider of innovative healthcare solutions that improve the quality of life for patients and communities. We work tirelessly to integrate the latest medical advancements and best practices into our services.</p>
    </div>
</section>

<section id="services" class="services">
    <div class="container">
        <h2>Our Services</h2>
        <p>We offer a comprehensive range of services to meet the needs of our patients and healthcare providers, including:</p>
        <ul>
            <li><strong>Patient Registration:</strong> Streamlined processes for patient registration and record management.</li>
            <li><strong>Appointment Scheduling:</strong> Easy scheduling of appointments with doctors and specialists.</li>
            <li><strong>Medical Records Management:</strong> Secure and organized storage of patient medical records.</li>
            <li><strong>Billing and Insurance Processing:</strong> Efficient billing services and handling of insurance claims.</li>
            <li><strong>Telemedicine Services:</strong> Virtual consultations for patients unable to visit the hospital.</li>
            <li><strong>Emergency Services:</strong> 24/7 availability for urgent medical assistance and treatment.</li>
            <li><strong>Pharmacy Services:</strong> In-house pharmacy for easy prescription fulfillment.</li>
            <li><strong>Lab Services:</strong> Comprehensive laboratory tests and diagnostics with quick turnaround times.</li>
            <li><strong>Wellness Programs:</strong> Preventive health screenings and wellness initiatives to promote a healthier lifestyle.</li>
        </ul>
        <p>For more details on our services, please contact us or visit our service pages once logged in. We are dedicated to providing the highest level of care for our patients.</p>
    </div>
</section>

<section id="contact" class="contact">
    <div class="container">
        <h2>Contact Us</h2>
        <p>If you have any questions or need assistance, feel free to reach out to us:</p>
        <p><strong>Email:</strong> <a href="mailto:contact@hospital.com">contact@hospital.com</a></p>
        <p><strong>Phone:</strong> <a href="tel:+1234567890">+123 456 7890</a></p>
        <p><strong>Address:</strong> 123 Health Street, Wellness City, State, ZIP Code</p>
        <p>Our customer service team is available from 9 AM to 5 PM, Monday to Friday. We strive to respond to all inquiries within 24 hours.</p>
        <p>We encourage you to reach out for any queries regarding our services, appointment scheduling, or any other concerns you may have. Your health and satisfaction are our top priorities.</p>
    </div>
</section>

<section id="feedback" class="feedback">
    <div class="container">
        <h2>Feedback</h2>
        <?php if ($feedbackSubmitted): ?>
            <p style="color: green; font-weight: bold;">Thank you for your feedback! We appreciate your input and will use it to improve our services.</p>
        <?php else: ?>
            <form action="index.php" method="post">
                <textarea name="feedback" rows="4" placeholder="Your feedback" required></textarea>
                <button type="submit">Submit Feedback</button>
            </form>
        <?php endif; ?>
        <p>Your feedback is vital for us to enhance our services. We value your opinions and strive to meet your expectations in every aspect of our care.</p>
    </div>
</section>

<section id="change-name" class="change-name">
    <div class="container">
        <h2>Change Your Name</h2>
        <?php if (isset($nameChanged) && $nameChanged): ?>
            <p style="color: green; font-weight: bold;">Your name has been updated successfully!</p>
        <?php else: ?>
            <form action="index.php" method="post">
                <input type="text" name="new_name" placeholder="Enter your new name" required>
                <button type="submit">Change Name</button>
            </form>
        <?php endif; ?>
    </div>
</section>

<footer>
    <div class="container">
    <p>&copy; <?php echo date("Y"); ?> Hospital Management System. All rights reserved.</p>
        <p>Follow us on:
            <a href="#">Facebook</a> |
            <a href="#">Twitter</a> |
            <a href="#">Instagram</a>
        </p>
    </div>
</footer>

</body>
</html>




