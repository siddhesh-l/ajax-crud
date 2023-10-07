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