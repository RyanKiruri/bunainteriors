<?php

// Database connection details (replace with your actual credentials)
$DB_HOST = "bunainteriors";
$DB_USERNAME = "NatalieGrace";
$DB_PASSWORD = "F81/D4IHDlkL5*K@ ";
$DB_NAME = "buna_interiors";

// Create connection
$conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}else {

// Prepare statement for insertion (replace table name if needed)
$sql = "INSERT INTO appointments (name, email, number, date, time, location) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
  echo "Error creating prepared statement: " . $conn->error;
  exit();
}

// Validate and sanitize user input
$name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$number = filter_var($_POST["number"], FILTER_SANITIZE_NUMBER_INT);
$date = filter_var($_POST["date"], FILTER_SANITIZE_STRING);
$time = filter_var($_POST["time"], FILTER_SANITIZE_STRING);
$location = filter_var($_POST["Location"], FILTER_SANITIZE_STRING);

if (!$name || !$email || !$number || !$date || !$time || !$location) {
  echo "Error: All fields are required.";
  exit();
}

// Bind parameters to prevent SQL injection
$stmt->bind_param("ssisss", $name, $email, $number, $date, $time, $location);

if (!$stmt->execute()) {
  echo "Error inserting data: " . $stmt->error;
  exit();
}

// Close statement and connection
$stmt->close();
$conn->close();

// Send confirmation email using PHPMailer (replace with your logic)
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

// Configure email sending with your credentials and format
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp-relay.brevo.com';
$mail->SMTPAuth = true;
$mail->Username = 'ryansebby64@gmail.com';
$mail->Password = 'Sn7MxDZmwHaUK0FA';
$mail->SMTPSecure = 'tls'; // or 'ssl'
$mail->Port = 587;
$mail->setFrom('bunainteriors@gmail.com', 'BUNA Interiors');
$mail->addAddress($email, $name); // Add recipient
$mail->Subject = 'Appointment Confirmation - BUNA Interiors';
$mail->Body = "Dear $name,\n\nThis email confirms your appointment with BUNA Interiors on $date at $time. Please arrive 15 minutes early and bring your confirmation email with you.\n\nWe look forward to seeing you!\n\nSincerely,\nBUNA Interiors Team";

if (!$mail->send()) {
  echo "Error sending email: " . $mail->ErrorInfo;
} else {
  echo "Appointment booked successfully! Check your email for details.";
}
}
?>