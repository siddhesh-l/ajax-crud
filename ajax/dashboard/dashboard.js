$(document).ready(function () {
   $.ajax({
      url: "getUser.php",
      method: 'GET',
      dataType: 'json',
      success: function (resopnse) {
         //Update the navbar with the user's name
         $('#userName').text('Welcome ' + resopnse.name);

      },
      error: function () {
         console.log("Failed to fetch user name");
      }
   })
   $('#userTable').DataTable({
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
               //check if the user is an admin
               if (data.userType === 'user') {
                  return '<td> <i class="bi bi-pencil-square" style="color:blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>' +
                  '<td> <i class="bi bi-trash" style="color:red"></i> </td>';
               } else {
                  return '<td></td><td></td>';
               }
            }
         }
      ]
   });

});