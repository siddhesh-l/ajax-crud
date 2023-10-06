<?php
// Connect to your MySQL database
include_once './database/db.php';

// Retrieve data from the AJAX request
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];
$userType = $_POST["userType"];

// Hash the password for security
$passwordHash = hash("sha256", $password);

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO `ajax_user`(`name`, `email`, `password`, `mobile`, `gender`, `userType`) VALUES (?, ?, ?, ?, ?, ?)");

if ($stmt) {
    // Bind parameters
    $stmt->bind_param("ssssss", $name, $email, $passwordHash, $mobile, $gender, $userType);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
