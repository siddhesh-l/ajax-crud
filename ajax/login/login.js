document.addEventListener("DOMContentLoaded", function () {
   const loginForm = document.getElementById("loginForm");

   loginForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      // Send a POST request to the server using fetch API
      fetch("login.php", {
         method: "POST",
         headers: {
             "Content-Type": "application/x-www-form-urlencoded",
         },
         body: `email=${email}&password=${password}`,
     })
     .then(response => {
         if (!response.ok) {
             throw new Error(`HTTP error! Status: ${response.status}`);
         }
         return response.json();
     })
     .then(data => {
         if (data.success) {
             alert("Registration Successful");
             window.location.href = "http://localhost/siddhesh/ajax/dashboard/dashboard.html";
         } else {
             // Display error messages to the user
             document.getElementById("emailError").textContent = data.email_error;
             document.getElementById("passwordError").textContent = data.password_error;
         }
     })
     .catch(error => {
         console.error("Error:", error);
         alert("An error occurred: " + error.message); // Show the error in an alert
     });
     
   });

});