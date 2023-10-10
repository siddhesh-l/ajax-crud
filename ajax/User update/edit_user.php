<?php
session_start();

// Check if the user is authenticated, replace 'user_id' with your actual session variable name
if (!isset($_SESSION['id'])) {
   header('Location: /login/login.php'); // Redirect to the login page if not authenticated
   exit();
}

// Include your database connection script here
require_once "../database/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $userId = $_POST["userId"];
   $name = $_POST["name"];
   $gender = $_POST["gender"];
   $mobile = $_POST["mobile"];

   // Update user details in the database
   $sql = "UPDATE ajax_user SET name=?, gender=?, mobile=? WHERE id=?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("sssi", $name, $gender, $mobile, $userId);
   if ($stmt->execute()) {
      // Redirect back to the user list after successful update
      header("Location: http://localhost/siddhesh/ajax/dashboard/dashboard.html");
   } else {
      // Handle the error
      echo "Error updating user: " . $stmt->error;
   }
   $stmt->close();
}

$conn->close();
?>
