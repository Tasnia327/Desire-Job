<?php
// Database connection
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";  // Default XAMPP password (empty)
$dbname = "job_portal";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and escape to prevent SQL injection
    $loginUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $loginPassword = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to fetch the admin by username
    $sql = "SELECT * FROM admin WHERE username = '$loginUsername'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the data from the database
        $row = $result->fetch_assoc();
        
        // Verify password using password_verify
        if (password_verify($loginPassword, $row['password'])) {
            // Successful login
            echo "Login successful!";
            // Redirect to the admin dashboard
            exit;
        } else {
            // Invalid password
            echo "<p style='color: red;'>Invalid login credentials!</p>";
        }
    } else {
        // Username not found
        echo "<p style='color: red;'>Invalid login credentials!</p>";
    }

    // Close the connection
    $conn->close();
}
?>
