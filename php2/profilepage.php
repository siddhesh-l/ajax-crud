<?php
error_reporting(E_ALL);
//Call the Database File
require_once 'db_helper.php';

session_start();

//Check the user is logged in, if not, redirect the log in page

if (!isset($_SESSION['id'])) {
   header("location:http://localhost/siddhesh/php2/login.php");
   exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['name'];
$user_phone = $_SESSION['phone'];
$user_gender = $_SESSION['gender'];


$sql = mysqli_prepare($conn, "SELECT username, phone, email, gender, user_image FROM users WHERE id=?");
mysqli_stmt_bind_param($sql, "i", $user_id);
mysqli_stmt_execute($sql);
$result = mysqli_stmt_get_result($sql);

if (mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_assoc($result);
   $current_user_name = $row["username"];
   $current_user_phone = $row["phone"];
   $current_user_gender = $row["gender"];
   $current_user_email = $row["email"];
   $current_user_image = $row["user_image"];
}

//Handle form submission

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   // $user_id = $_SESSION['id'];
   $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
   $new_phone = mysqli_real_escape_string($conn, $_POST['new_phone']);
   $new_gender = mysqli_real_escape_string($conn, $_POST['new_gender']);
   
   //Handle profile image upload

   if (!empty($_FILES['new_profile_image']['name'])) {
      $target_dir = "img/";
      $target_file = $target_dir . basename($_FILES['new_profile_image']['name']);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      
      //Check if the upload file is an image
      $check = getimagesize($_FILES['new_profile_image']['tmp_name']);

      if ($check !== false) {
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
         echo "The uploaded file is not an image.";
     }
 } else {
     // No new image uploaded
     $new_image = $current_user_image;
 }

 $update_sql = "UPDATE users SET username = '$new_username', phone = '$new_phone', gender = '$new_gender', user_image = '$new_image' WHERE id = $user_id";

 if (mysqli_query($conn, $update_sql)) {
     $_SESSION['name'] = $new_username;
     $_SESSION['phone'] = $new_phone;
     $_SESSION['gender'] = $new_gender;
     $_SESSION['user_image'] = $new_image;

     echo "Update data successfully";

     header("location:http://localhost/siddhesh/php2/home.php");
     exit;
 } else {
     echo "Error: " . mysqli_error($conn);
 }
}

session_write_close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

   <title>Home Page</title>

   <style>
      .gradient-background {

         height: 723px;
      }

      body {
         align-items: center;
         margin: 0;
         padding-top: 90px;
         height: 100vh;

         background: linear-gradient(135deg, #d9ffbd, #9effdf, #fdbdff, #cfc2ff);
      }
   </style>


</head>

<body>
   <div class="container">
      <div class="row justify-content-center">
         <!-- Profile Picture Card -->
         <div class="col-md-3">
            <div class="card align-items-center" style="height: 515px;"><br><br>
               <?php
               // Query to retrieve the user's profile image path
               $image_query = "SELECT user_image FROM users WHERE id = $user_id";
               $image_result = mysqli_query($conn, $image_query);

               if ($image_result && mysqli_num_rows($image_result) > 0) {
                  $image_row = mysqli_fetch_assoc($image_result);
                  $profile_image_path = $image_row['user_image'];

                  // Set the profile image path in the <img> tag
                  echo '<img src="' . $profile_image_path . '" alt="Profile Picture" class="centered-image" style="height: 150px; width: 150px; align-items: center;">';
               } else {
                  // If no image is found, you can use a default image
                  echo '<img src="default_profile.jpg" alt="Profile Picture" class="centered-image" style="height: 150px; width: 150px; align-items: center;">';
               }
               mysqli_close($conn);
               ?>
              
               <p>
               <h6>JPG or PNG no larger than 5 MB</h6>
               </p><br>
               <div class="card-body text-center">
                  <form method="post" action="profilepage.php" enctype="multipart/form-data">
                     <!-- Other form inputs -->
                     <!-- Add the provided form code here -->
                     <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="basic-addon1">
                           <i class="bi bi-image"></i>
                        </span>
                        <input type="file" class="form-control" name="new_profile_image" accept="image/*">
                     </div>
                     <!-- Update and Cancel buttons -->
                     <div class="row">
                        <div class="col-md-6">
                           <button type="Update" class="btn btn-outline-primary w-100" value="submit">Update</button>
                        </div>
                        <div class="col-md-6">
                           <a href="profilepage.php"><button type="Update" class="btn btn-outline-danger w-100">Cancel</button></a>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>

         <!-- Personal Information Card -->
         <div class="col-md-5">
            <div class="card p-5">
               <div class="card-body">
                  <h3 class="card-title text-center">Personal Information</h3><br>
                  <form method="post" action="profilepage.php">
                     <div class="input-group">
                        <div class="input-group-prepend">

                        </div>
                     </div>
                     <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="basic-addon1">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                              <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                           </svg>
                        </span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="new_username" value="<?php echo $current_user_name; ?>">
                     </div><br>
                     <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="basic-addon1">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                              <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                           </svg>
                        </span>
                        <input type="number" class="form-control" placeholder="Mobile" aria-label="Mobile" name="new_phone" aria-describedby="basic-addon1" value="<?php echo $current_user_phone; ?>">
                     </div><br>
                     <div class="mb-3">
                        <label for="gender" class="mb-2">
                           <h6>Gender</h6>
                        </label><br>
                        <input type="radio" name="new_gender" id="male" value="male" <?php echo ($current_user_gender === 'male') ? 'checked' : '' ?>>
                        <label for="male">Male</label>

                        <input type="radio" name="new_gender" id="female" value="female" <?php echo ($current_user_gender === 'female') ? 'checked' : '' ?>>
                        <label for="female">Female</label>
                     </div><br>
                     <div class="row">
                        <div class="col-md-6">
                           <button type="Update" class="btn btn-outline-primary w-100" value="submit">Update</button>
                        </div>
                        <div class="col-md-6">
                           <a href="profilepage.php"><button type="Update" class="btn btn-outline-danger w-100">Cancle</button></a>
                        </div>

                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>