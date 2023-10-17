<?php
error_reporting(0);

require_once '../database/db.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("location: http://localhost/siddhesh/php2/login.php");
    exit;
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    $new_phone = mysqli_real_escape_string($conn, $_POST['new_phone']);
    $new_gender = mysqli_real_escape_string($conn, $_POST['new_gender']);
    
    // Handle profile image upload
    if (!empty($_FILES['new_profile_image']['name'])) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES['new_profile_image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $allowed_extensions = array("jpg", "png", "jpeg");

        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES['new_profile_image']['tmp_name'], $target_file)) {
                $new_image = mysqli_real_escape_string($conn, $target_file);
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Invalid file format. Allowed formats: JPG, PNG, JPEG";
        }
    } else {
        $new_image = $current_user_image; // Use the existing image if no new image is uploaded
    }

    // Update user information including the profile image
    $update_sql = "UPDATE ajax_user SET name = '$new_username', mobile = '$new_phone', gender = '$new_gender', image = '$new_image' WHERE id = $user_id";

    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['name'] = $new_username;
        $_SESSION['phone'] = $new_phone;
        $_SESSION['gender'] = $new_gender;
        $_SESSION['user_image'] = $new_image;

        echo "Update data successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

session_write_close();
?>
