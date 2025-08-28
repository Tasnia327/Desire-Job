<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "job_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // File upload
    if (isset($_FILES["resume"]) && $_FILES["resume"]["error"] == 0) {
        $target_dir = "uploads/";
        $resume_file = $target_dir . basename($_FILES["resume"]["name"]);

        // Move uploaded file
        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $resume_file)) {
            // Insert data into database
            $sql = "INSERT INTO applications (name, email, resume) VALUES ('$name', '$email', '$resume_file')";
            
            if ($conn->query($sql) === TRUE) {
                echo "Application submitted successfully!<br>";
                echo "Name: " . htmlspecialchars($name) . "<br>";
                echo "Email: " . htmlspecialchars($email) . "<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Please upload a valid resume file.";
    }
}

$conn->close();
?>
