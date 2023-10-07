$.ajax({
   url: 'fetch_profile_info.php', // PHP script to fetch user data
   method: 'GET',
   dataType: 'json',
   success: function (response) {
      if (response.success) {
         var userData = response.user_data;
         $('#new_username').val(userData.name);
         $('#new_phone').val(userData.mobile);

         if (userData.gender === 'male') {
            $('#male').prop('checked', true);
         } else if (userData.gender === 'female') {
            $('#female').prop('checked', true);
         }
      } else {
         console.error('Error fetching user data: ' + response.message);
      }
   },
   error: function () {
      console.error('Failed to fetch user data');
   }
});

