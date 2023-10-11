<?php
session_start();
require_once '../database/db.php'; // Include your database connection code

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("location: http://localhost/siddhesh/ajax/login/login.html");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_FILES['new_profile_image']['name'])) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES['new_profile_image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $check = getimagesize($_FILES['new_profile_image']['tmp_name']);

        if ($check !== false) {
            $allowed_extensions = array("jpg", "png", "jpeg");

            if (in_array($imageFileType, $allowed_extensions)) {
                if (move_uploaded_file($_FILES['new_profile_image']['tmp_name'], $target_file)) {
                    // Update the user's profile image in the database
                    $new_image = mysqli_real_escape_string($conn, $target_file);
                    $update_sql = "UPDATE ajax_user SET image = '$new_image' WHERE id = $user_id";

                    if (mysqli_query($conn, $update_sql)) {
                        // Optionally, return a success response to the client
                        $response = array('success' => true, 'newImage' => $new_image);
                        echo json_encode($response);
                        exit;
                    } else {
                        // Handle the database error and return an error response
                        $response = array('success' => false, 'error' => 'Error updating profile image: ' . mysqli_error($conn));
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    // Return an error response for the file upload failure
                    $response = array('success' => false, 'error' => 'Error uploading the image.');
                    echo json_encode($response);
                    exit;
                }
            } else {
                // Return an error response for invalid file format
                $response = array('success' => false, 'error' => 'Invalid file format. Allowed formats: JPG, PNG, JPEG');
                echo json_encode($response);
                exit;
            }
        } else {
            // Return an error response for a non-image file
            $response = array('success' => false, 'error' => 'The uploaded file is not an image.');
            echo json_encode($response);
            exit;
        }
    } else {
        // Return a response for no new image uploaded
        $response = array('success' => false, 'error' => 'No new image uploaded.');
        echo json_encode($response);
        exit;
    }
}

// Close the database connection (if not done already)
mysqli_close($conn);
