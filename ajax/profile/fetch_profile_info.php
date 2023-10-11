<?php
require_once '../database/db.php'; // Include your database connection script
session_start();

if (!isset($_SESSION['id'])) {
   header("location: http://localhost/siddhesh/ajax/login/login.html");
   exit;
}

if ($_SERVER['REQUEST_METHOD'] == "GET") { // Use GET request to fetch user data
   $user_id = $_SESSION['id'];

   $select_sql = "SELECT name, mobile, gender, image FROM ajax_user WHERE id = ?";
   $stmt = mysqli_prepare($conn, $select_sql);
   mysqli_stmt_bind_param($stmt, "i", $user_id);

   if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_bind_result($stmt, $name, $mobile, $gender, $profile_image);
      mysqli_stmt_fetch($stmt);

      $user_data = array(
         'name' => $name,
         'mobile' => $mobile,
         'gender' => $gender,
         'profile_image' => $profile_image // Include the image information
      );

      $response = array('success' => true, 'user_data' => $user_data);
   } else {
      $response = array('success' => false, 'message' => 'Error fetching user data: ' . mysqli_error($conn));
   }

   mysqli_stmt_close($stmt);
   echo json_encode($response);
} else {
   echo json_encode(array('success' => false, 'message' => 'Invalid request'));
}

mysqli_close($conn);
?>
