// Function to redirect to the update page with the id parameter
function redirectToUpdate(id) {
   // Construct the URL with the id parameter
   var updateUrl = 'http://localhost/siddhesh/ajax/User%20update/user_update.html?id=' + id;

   // Redirect to the update page with the id parameter
   window.location.href = updateUrl;
}

// Function for deleting an item (you may define this separately)
function deleteItem(id) {
   
   // Show a confirmation dialog before deleting
   var confirmation = confirm("Are you sure you want to delete this user?");
   
   if (confirmation) {
      // User confirmed, proceed with the deletion
      $.ajax({
         url: "deleteUser.php", // Replace with your actual delete script
         method: 'POST',
         data: { id: id }, // Send the user ID to delete
         success: function (response) {
            // Handle the response, maybe refresh the table
            console.log(response);
         },
         error: function () {
            console.log("Failed to delete user");
         }
      });
   } else {
      // User canceled, do nothing
   }
}

// Function to render images with default if not available
function renderImage(data, type, row) {
   if (type === 'display') {
      if (data) {
         return '<img src="' + data + '" alt="User Image" width="25">';
      } else {
         return '<img src="http://localhost/siddhesh/ajax/images/default_user.png" alt="Default User Image" width="50">';
      }
   }
   return data;
}


$.ajax({
   url: "getUser.php",
   method: 'GET',
   dataType: 'json',
   success: function (response) {
      var userType = response.userType;

      var userData = response;

      // Update the navbar with the user's name
      $('#userName').text('Welcome ' + response.name);

      // Initialize the DataTable with custom rendering based on isAdmin
      var table = $('#userTable').DataTable({
         "ajax": {
            "url": "dashboard.php",
            "dataSrc": "data"
         },
         "columns": [
            { "data": "id" },
            {
               "data": "image",
               render: renderImage
            },
            { "data": "name" },
            { "data": "email" },
            { "data": "mobile" },
            { "data": "gender" },
            { "data": "userType" },
            {
               "data": null,
               "render": function (data, type, row) {
                  // alert(userType);
                  if (userType === 'admin') {

                     // Check if the user is an admin, show the action icons for admin users
                     var updateButton = '<button class="btn btn-outline-primary" onclick="redirectToUpdate(' + row.id + ')">Update</button>';
                     var deleteButton = '<button class="btn btn-outline-danger" onclick="deleteItem(' + row.id + ')">Delete</button>';
                     return updateButton + " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " + deleteButton;


                  } else {
                     return '<td></td><td></td><td></td>';
                  }
               }
            }
         ]
      });

      if (userType !== 'admin') {
         table.columns(7).visible(false);
      }

   },
   error: function () {
      console.log("Failed to fetch user name");
   }
});

