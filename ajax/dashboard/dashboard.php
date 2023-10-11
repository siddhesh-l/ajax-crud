<?php
session_start();
// Check if the user is authenticated, replace 'user_id' with your actual session variable name
if (!isset($_SESSION['id'])) {
   header('Location: /login/login.php'); // Redirect to the login page if not authenticated
   exit();
}

// Include your database connection script here
require_once "../database/db.php"; 

// Fetch user data excluding the authenticated user's profile
$authenticatedUserId = $_SESSION['id'];
$sql = "SELECT * FROM ajax_user WHERE id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $authenticatedUserId);
$stmt->execute();
$result = $stmt->get_result();

$users = array(); //empty array
while ($row = $result->fetch_assoc()) {
   $users[] = $row; //store the data in array
}


$stmt->close();
$conn->close();


// Prepare and send the JSON response
$response = array("data" => $users);
echo json_encode($response);



?>
