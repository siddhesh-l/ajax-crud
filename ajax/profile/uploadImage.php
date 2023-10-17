<?php
session_start();
include_once "../database/db.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['new_profile_image']) && $_FILES['new_profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images/';  // Specify your upload directory
        $uploadPath = $uploadDir . basename($_FILES['new_profile_image']['name']);
        move_uploaded_file($_FILES['new_profile_image']['tmp_name'], $uploadPath);

        // Update the user's profile picture in the database using mysqli
        $updateQuery = "UPDATE ajax_user SET image = ? WHERE id = ?";
        $stmt = $db->prepare($updateQuery);
        $stmt->bind_param("si", $uploadPath, $user_id);

        if ($stmt->execute()) {
            // Update the profile image URL in the HTML to reflect the change
            echo '<script>document.getElementById("profileImage").src = "' . $uploadPath . '";</script>';
            echo 'Profile picture updated successfully';
        } else {
            echo 'Error updating the profile picture: ' . $db->error;
        }

        $stmt->close();
        $db->close();
    } else {
        echo 'Error uploading the file';
    }
} else {
    echo 'User not logged in';
}
