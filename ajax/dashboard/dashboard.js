$(document).ready(function () {
   $.ajax({
      url: "getUser.php",
      method: 'GET',
      dataType: 'json',
      success: function (response) {
         var userType = response.userType;
         console.log(userType);
   
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
               { "data": "name" },
               { "data": "email" },
               { "data": "mobile" },
               { "data": "gender" },
               { "data": "userType" },
               {
                  "data": null,
                  "render": function (data, type, row) {
                     // alert(userType);
                     if(userType === 'admin'){
                        
                        // Check if the user is an admin, show the action icons for admin users
                        return '<td><i class="bi bi-pencil-square" style="color: blue"></i></td>' + "<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>" + 
                        '<td> <i class="bi bi-trash" style="color: red"></i></td>';

                     }else{
                        return '<td></td><td></td><td></td>';
                     }
                  }
               }
            ]
         });

         if(userType !== 'admin'){
            table.columns(6).visible(false);
         }

      },
      error: function () {
         console.log("Failed to fetch user name");
      }
   });
});
