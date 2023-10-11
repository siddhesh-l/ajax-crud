$('#infoForm').submit(function (e) {
   e.preventDefault();

   // Serialize form data
   var formData = $(this).serialize();

   // Send AJAX request to update user data
   $.ajax({
      url: 'profile_info.php', // PHP script to update user data
      method: 'POST',
      data: formData,
      dataType: 'json',
      success: function (response) {
         if (response.success) {
            // Show the update message
            $('#updateMessage').text('User data updated successfully!').show();

            // You can also hide the message after a certain time
            setTimeout(function () {
               $('#updateMessage').fadeOut('slow');
            }, 3000); // Hide after 3 seconds (adjust as needed)
         } else {
            // Show an error message
            $('#updateMessage').text('Error updating user data: ' + response.message).show();
         }
      },
      error: function () {
         // Show an error message
         $('#updateMessage').text('Failed to update user data').show();
      }
   });
});

// Function to handle the file input change event
function handleFileInputChange() {
   var fileInput = document.getElementById('newProfileImage');
   previewImage(fileInput);
}

// Function to handle the update button click
document.getElementById('updateImage').addEventListener('click', function () {
   var fileInput = document.getElementById('newProfileImage');
   if (fileInput.files.length === 0) {
       alert('Please select an image to upload.');
       return;
   }
   var formData = new FormData(document.getElementById('imageUploadForm'));
   
   fetch('update_profile_image.php', {
       method: 'POST',
       body: formData
   })
   .then(response => response.json())
   .then(data => {
       if (data.success) {
           // Update the UI or display a success message
           alert('Profile image updated successfully.');
           // Optionally, update the user interface with the new image
           var profileImage = document.getElementById('profileImage');
           profileImage.style.backgroundImage = 'url(' + data.newImage + ')';
           profileImage.style.backgroundSize = 'cover';
       } else {
           // Handle the error and display an error message
           alert('Error updating profile image: ' + data.error);
       }
   })
   .catch(error => {
       console.error('Error:', error);
   });
});
