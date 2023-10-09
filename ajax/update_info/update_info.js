$('form').submit(function(event){
   //Prevent the default form submission
   event.preventDefault();

   //Serialize the form data
   var formData = $(this).serialize();

   //Send the AJAX request to update_info.php
   $.ajax({
      url: 'update_info.php',
      method: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response){
         if(response.success){
            //update Successfully, show a success message
            $('#updateMessage').removeClass('alert-danger').addClass('alert-success');
            $('#updateMessage').html(response.message).show();
         }else{
            //Update failed, Show an error message
            $('#updateMessage').removeClass('alert-success').addClass('alert-danger');
            $('#updateMessage').html(response.message).show();
         }
      },
      error: function(){
         //AJAX request faile, show an error message
         $('#updateMessage').removeClass('alert-success').addClass('alert-danger');
         $('#updateMessage').html("Failed to update. Please try again");
      }
   })
})