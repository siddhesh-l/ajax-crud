<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

error_reporting(E_ERROR | E_WARNING);
session_start();

include "../database/db.php";

// Initialize response data with default values
$response_data = array("success" => false, "email_error" => "", "password_error" => "", "login_error" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $email = test_input($_POST["email"]);
   $password = test_input($_POST["password"]);

   $email_error = validate_email($email);
   $password_error = validate_password($password);

   if (empty($email_error) && empty($password_error)) {
      $hashed_password = hash('sha256', $password);
      
      $sql = "SELECT id, name, email, mobile, gender, userType FROM ajax_user WHERE email = ? AND password = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $email, $hashed_password);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows == 1) {
         $row = $result->fetch_assoc();
         $_SESSION['id'] = $row['id'];
         $_SESSION['name'] = $row['name'];
         $_SESSION['email'] = $row['email'];
         $_SESSION['mobile'] = $row['mobile'];
         $_SESSION['gender'] = $row['gender'];
         $_SESSION['userType'] = $row['userType'];

         // Set success to true to indicate successful login
         $response_data["success"] = true;
      } else {
         $response_data["login_error"] = "Email and/or password are incorrect.";
      }
   } else {
      // Set error messages in the response data
      $response_data["email_error"] = $email_error;
      $response_data["password_error"] = $password_error;
   }
}

// Set the JSON content type header
header('Content-Type: application/json');

// Send the JSON-encoded response data
echo json_encode($response_data);

// Log the response data for debugging
file_put_contents("response.log", json_encode($response_data) . PHP_EOL, FILE_APPEND);

exit();

function test_input($data)
{
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

function validate_email($email)
{
   if (empty($email)) {
      return "Email is required.";
   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return "Invalid email format.";
   }
   return "";
}

function validate_password($password)
{
   if (empty($password)) {
      return "Password is required.";
   } elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) {
      return "Password must contain at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least 8 characters long.";
   }
   return "";
}
?>
