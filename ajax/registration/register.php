<?php
// Include the database connection
include_once '../database/db.php';

$name = $email = $password = $mobile = $gender = $userType = "";
$registration_date = date('d-m-y:H:i:s');

// Define validation functions
function validateName($name) {
    // Name should not be empty and should contain only letters and spaces
    if (!empty($name) && preg_match("/^[a-zA-Z ]+$/", $name)) {
        return true;
    } else {
        echo "Name validation failed.";
        return false;
    }
}

function validateEmail($email) {
    // Use PHP's built-in email validation function
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        echo "Email validation failed.";
        return false;
    }
}

function validatePassword($password) {
    // Password should be at least 8 characters long
    if (strlen($password) >= 8) {
        return true;
    } else {
        echo "Password validation failed.";
        return false;
    }
}

function validateMobile($mobile) {
    // Mobile number should be a valid format, e.g., 123-456-7890
    if (preg_match("/^\d{3}\d{3}\d{4}$/", $mobile)) {
        return true;
    } else {
        echo "Mobile validation failed.";
        return false;
    }
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

// Set the default profile picture URL
$defaultProfilePicture = 'default_user.png'; // Replace with the actual path or URL of your default image.

// Validate the input data
if (
    validateName($name) &&
    validateEmail($email) &&
    validatePassword($password) &&
    validateMobile($mobile)
) {
    // Hash the password for security
    $passwordHash = hash("sha256", $password);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO `ajax_user`(`image`, `name`, `email`, `password`, `mobile`, `gender`, `userType`, `reg_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Bind parameters, including the default profile picture URL
        $stmt->bind_param("ssssssss", $defaultProfilePicture, $name, $email, $passwordHash, $mobile, $gender, $userType, $registration_date);

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
