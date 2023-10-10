<?php
session_start();

// Include your database connection script here
require_once "../database/db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
   $userId = $_GET["id"];

   // Fetch user data by ID
   $sql = "SELECT * FROM ajax_user WHERE id=?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("i", $userId);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      echo json_encode($row);
   } else {
      echo "User not found";
   }

   $stmt->close();
}

$conn->close();
?>
