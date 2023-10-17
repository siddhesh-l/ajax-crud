<?php
include '../database/db.php'; // Include your database connection script

session_start();

if (!isset($_SESSION['id'])) {
    header("location: http://localhost/siddhesh/ajax/login/login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_SESSION['id'];

    // Handle the uploaded image if provided
    if (isset($_FILES['_image']['name']) && !empty($_FILES['_image']['name'])) {
        $targetDirectory = 'images/'; // Create this directory to store uploaded images
        $newFileName = uniqid() . '_' . $_FILES['_image']['name'];
        $targetPath = $targetDirectory . $newFileName;

        // Debug: Print the target path and other information
        echo "Target Path: " . $targetPath . "<br>";
        
        if (move_uploaded_file($_FILES['_image']['tmp_name'], $targetPath)) {
            // Debug: Print success message
            echo "Image uploaded successfully.<br>";

            // Update the user's profile picture in the database
            $updateImageQuery = "UPDATE ajax_user SET image = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $updateImageQuery);
            mysqli_stmt_bind_param($stmt, "si", $targetPath, $user_id);

            if (mysqli_stmt_execute($stmt)) {
                // Debug: Print success message
                echo "Image updated in the database.<br>";

                $response = array('success' => true, 'message' => 'Profile Image updated successfully');
            } else {
                $response = array('success' => false, 'message' => 'Error updating profile image: ' . mysqli_error($conn));
            }

            mysqli_stmt_close($stmt);
        } else {
            $response = array('success' => false, 'message' => 'Error uploading profile image');
        }
    } else {
        $response = array('success' => false, 'message' => 'No file was uploaded');
    }

    // Handle other user information updates
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];

    // Debug: Print the user information being updated
    echo "Name: $name, Mobile: $mobile, Gender: $gender<br>";

    $updateInfoQuery = "UPDATE ajax_user SET name = ?, mobile = ?, gender = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateInfoQuery);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $mobile, $gender, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Debug: Print success message
        echo "Profile information updated in the database.<br>";

        $response = array('success' => true, 'message' => 'Profile updated successfully');
    } else {
        $response = array('success' => false, 'message' => 'Error updating profile information: ' . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);
} else {
    $response = array('success' => false, 'message' => 'Invalid request');
}

mysqli_close($conn);

// Debug: Print the final response
echo json_encode($response);
?>
