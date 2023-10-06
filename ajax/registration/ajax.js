$(document).ready(function(){
   $('#registrationForm').submit(function(event){
      event.preventDefault();
      var formData = $(this).serialize();

      $.ajax({
         type: 'POST',
         url: 'registration.php',
         data: formData,
         success: function(response){
            if(response.startsWith("Error: ")){
               //Display error message below the corresponding field
               var fieldName = response.split(":")[1].trim();
               var errorMessage = response.split(":")[2].trim();
               $('#' + fieldName + '-error').html(errorMessage);
            }else{
               //Clear error message if registration is successful
               $('.error').html('');
               $('#result').html(response);
            }
         }
      });
   });
});