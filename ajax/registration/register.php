<?php
// Include the database connection
include_once '../database/db.php';

// Define validation functions
function validateName($name) {
    // Name should not be empty and should contain only letters and spaces
    return !empty($name) && preg_match("/^[a-zA-Z ]+$/", $name);
}

function validateEmail($email) {
    // Use PHP's built-in email validation function
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password) {
    // Password should be at least 8 characters long
    return strlen($password) >= 8;
}

function validateMobile($mobile) {
    // Mobile number should be a valid format, e.g., 123-456-7890
    return preg_match("/^\d{3}-\d{3}-\d{4}$/", $mobile);
}

function validateGender($gender) {
    // Gender can be validated according to your specific requirements
    // For simplicity, we'll assume it's valid if it's "Male" or "Female"
    return in_array($gender, ["Male", "Female"]);
}

function validateUserType($userType) {
    // User type can be validated according to your specific requirements
    // For simplicity, we'll assume it's valid if it's "User" or "Admin"
    return in_array($userType, ["User", "Admin"]);
}

// Define a function to log messages to a file
function logMessage($message) {
    // Define the log file path
    $logFile = 'registration_log.log';

    // Append the message with a timestamp
    $logMessage = date('Y-m-d H:i:s') . ' - ' . $message . "\n";

    // Write the message to the log file
    error_log($logMessage, 3, $logFile);
}

// Retrieve data from the AJAX request
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];
$userType = $_POST["userType"];

// Validate the input data
if (
    validateName($name) &&
    validateEmail($email) &&
    validatePassword($password) &&
    validateMobile($mobile) &&
    validateGender($gender) &&
    validateUserType($userType)
) {
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
            // Log a success message
            logMessage("User registered successfully: $name, $email");
        } else {
            echo "Error: " . $stmt->error;
            // Log an error message
            logMessage("Error during registration: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        // Log an error message
        logMessage("Error preparing statement: " . $conn->error);
    }
} else {
    echo "Invalid input data. Please check your input and try again.";
    // Log an error message
    logMessage("Invalid input data: $name, $email, $mobile, $gender, $userType");
}

// Close the database connection
$conn->close();
?>
