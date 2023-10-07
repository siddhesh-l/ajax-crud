<?php
require_once '../database/db.php'; // Include your database connection script
session_start();

if (!isset($_SESSION['id'])) {
   header("location: http://localhost/siddhesh/ajax/login/login.html");
   exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   $user_id = $_SESSION['id'];
   $new_username = $_POST['new_username'];
   $new_phone = $_POST['new_phone'];
   $new_gender = $_POST['new_gender'];

   $update_sql = "UPDATE ajax_user SET name = ?, mobile = ?, gender = ? WHERE id = ?";

   $stmt = mysqli_prepare($conn, $update_sql);
   mysqli_stmt_bind_param($stmt, "sssi", $new_username, $new_phone, $new_gender, $user_id);

   if (mysqli_stmt_execute($stmt)) {
      $_SESSION['name'] = $new_username;
      $_SESSION['mobile'] = $new_phone;
      $_SESSION['gender'] = $new_gender;
      $response = array('success' => true);
   } else {
      $response = array('success' => false, 'message' => 'Error updating personal information: ' . mysqli_error($conn));
   }

   mysqli_stmt_close($stmt);
   echo json_encode($response);
} else {
   echo json_encode(array('success' => false, 'message' => 'Invalid request'));
}

mysqli_close($conn);
?>
