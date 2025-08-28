<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "job_portal";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    // Extract and sanitize input
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $salary = isset($_POST['salary']) ? intval($_POST['salary']) : 0;
    $experience = isset($_POST['experience']) ? $_POST['experience'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $company = isset($_POST['company']) ? $_POST['company'] : '';
    $date_posted = date('Y-m-d');

    // Insert query
    $stmt = $conn->prepare("INSERT INTO jobs (title, type, salary, experience, location, company, date_posted) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $title, $type, $salary, $experience, $location, $company, $date_posted);

    if ($stmt->execute()) {
        echo "Your data is submitted successfully.<br> We'll let you know if any job is available!";
    } else {
        echo "Error: " . $stmt->error;
    }

$conn->close();
?>