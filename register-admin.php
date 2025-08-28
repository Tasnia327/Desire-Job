<?php
// Database connection
$servername = "localhost";
$username = "root"; // default XAMPP username
$password = ""; // default XAMPP password (empty)
$dbname = "job_portal"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $adminName = mysqli_real_escape_string($conn, $_POST['adminName']);
    $adminEmail = mysqli_real_escape_string($conn, $_POST['adminEmail']);
    $adminPassword = mysqli_real_escape_string($conn, $_POST['adminPassword']);

    // Hash the password before storing it
    $hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);
    // Check if email already exists
    $emailCheck = "SELECT * FROM admin WHERE email = '$adminEmail'";
    $result = $conn->query($emailCheck);
    if ($result->num_rows > 0) {
        echo "Email is already registered.";
    } else {
        // Insert the admin data into the database
        $sql = "INSERT INTO admin (username, email, password) VALUES ('$adminName', '$adminEmail', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "New admin registered successfully.<br><a href='admin-login.html'>Login here</a> ";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close connection
    $conn->close();
}
?>
