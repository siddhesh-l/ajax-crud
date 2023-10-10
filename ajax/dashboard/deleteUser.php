<?php
session_start();
// Check if the user is authenticated as an admin (replace 'userType' with your actual admin role)
if (!isset($_SESSION['id']) || $_SESSION['userType'] !== 'admin') {
   http_response_code(403); // Forbidden
   echo "You don't have permission to perform this action.";
   exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Get the user ID to delete from the POST data
   $id = $_POST['id'];

   // Include your database connection script here
   require_once "../database/db.php";

   // Prepare and execute the SQL statement to delete the user
   $sql = "DELETE FROM ajax_user WHERE id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("i", $id);

   if ($stmt->execute()) {
      // User deleted successfully
      echo "User deleted successfully.";
   } else {
      // Failed to delete user
      http_response_code(500); // Internal Server Error
      echo "Failed to delete user.";
   }

   $stmt->close();
   $conn->close();
} else {
   http_response_code(400); // Bad Request
   echo "Invalid request method.";
}
?>
