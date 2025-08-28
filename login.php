<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password
$dbname = "job_portal"; // Replace with your database name
// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $password = $_POST['password'] ?? '';
    // Validate user using fullname
    $stmt = $conn->prepare("SELECT password FROM users WHERE fullname = ?");
    $stmt->bind_param("s", $fullname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Check password
        if (password_verify($password, $user['password'])) {
            echo "Successful login.";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this full name.";
    }
    $stmt->close();
}
$conn->close();
?>
