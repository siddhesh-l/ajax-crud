document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission behavior
    
    // Get user inputs
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
  
    // Create a data object to send to the server
    var data = {
      email: email,
      password: password
    };

    
  
    // Send an AJAX request to the PHP script
    $.ajax({
      type: "POST",
      url: "login.php", // Replace with the actual path to your PHP script
      data: data,
      dataType: "json", // Expect JSON response
      success: function (response) {
        // Check the response from the server
        if (response.success) {
          // Redirect to a success page or perform other actions
          window.location.href = "http://localhost/siddhesh/ajax/dashboard/dashboard.html"; // Replace with the URL of your success page
        } else {
          // Display error messages or handle login failure
          if (response.email_error) {
            // Display email error message
            $("#email-error").text(response.email_error);
          }
          if (response.password_error) {
            // Display password error message
            $("#password-error").text(response.password_error);
          }
          if (response.login_error) {
            // Display login error message
            $("#login-error").text(response.login_error);
          }
        }
      },
      error: function () {
        // Handle AJAX error
        alert("An error occurred while processing your request.");
      }
    });
  });