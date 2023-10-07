<?php
session_start();
include "../database/db.php";

// Check if the user is authenticated, replace 'user_id' with your actual session variable name
if (isset($_SESSION['id'])) {
   $authenticatedUserId = $_SESSION['id'];
   

   // Replace 'users' with your actual table name and 'name_column' with the column storing user names
   $sql = "SELECT name, userType FROM ajax_user WHERE id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("i", $authenticatedUserId);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $response = array("name" => $row["name"], "userType" => $row["userType"]);
      echo json_encode($response);
   } else {
      echo json_encode(array("name" => "User"));
   }

   $stmt->close();
   $conn->close();
} else {
   echo json_encode(array("name" => "User"));
}
?>
