
// Fetch user data for editing
var userId = getUrlParameter("id");

$.ajax({
   url: "getUserById.php",
   method: 'GET',
   dataType: 'json',
   data: { id: userId },
   success: function (response) {
      $('#userId').val(response.id);
      $('#name').val(response.name);
      $('input[name="gender"][value="' + response.gender + '"]').prop('checked', true);
      $('#mobile').val(response.mobile);
   },
   error: function () {
      console.log("Failed to fetch user data");
   }
});

// Handle form submission
$('#editUserForm').submit(function (e) {
   e.preventDefault();

   var formData = $(this).serialize();

   $.ajax({
      url: "edit_user.php",
      method: 'POST',
      data: formData,
      success: function () {
         // Redirect back to the user list after successful update
         window.location.href = "http://localhost/siddhesh/ajax/dashboard/dashboard.html";
      },
      error: function () {
         console.log("Failed to update user data");
      }
   });
});


// Function to get URL parameter by name
function getUrlParameter(name) {
   name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
   var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
   var results = regex.exec(location.search);
   return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}
