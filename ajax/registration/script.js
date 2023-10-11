$("#submit").click(function () {
    // Clear previous error messages
    $(".error").text("");

    // Get form values
    var name = $("#floatingName").val();
    var email = $("#floatingEmail").val();
    var password = $("#password").val();
    var mobile = $("#floatingPhone").val();
    var gender = $('input[name="gender"]:checked').val();
    var userType = $('input[name="userType"]:checked').val();

    // alert(name);
    // alert(email);
    // alert(password);
    // alert(mobile);
    // alert(gender);
    // alert(userType);
    


    // Validate form inputs
    var isValid = true;

    if (name === "") {
        $("#nameError").text("Name is required");
        isValid = false;
    }

    if (email === "") {
        $("#emailError").text("Email is required");
        isValid = false;
    } else if (!isValidEmail(email)) {
        $("#emailError").text("Invalid email format");
        isValid = false;
    }

    if (password === "") {
        $("#passwordError").text("Password is required");
        isValid = false;
    }

    if (mobile === "") {
        $("#mobileError").text("Mobile is required");
        isValid = false;
    } else if (!isValidMobile(mobile)) {
        $("#mobileError").text("Invalid mobile number");
        isValid = false;
    }

    if (!userType) {
        $("#userTypeError").text("User Type is required");
        isValid = false;
    }

    if (isValid) {
        // Send data to the server using AJAX
        $.ajax({
            type: "POST",
            url: "register.php", // PHP script for database insertion
            data: {
                name: name,
                email: email,
                password: password,
                mobile: mobile,
                gender: gender,
                userType: userType
            },
            success: function (response) {
                $("#message").html(response);
                alert(response);
                window.location.href = "http://localhost/siddhesh/ajax/login/login.html";
            }
        });
    }
});


function isValidEmail(email) {
    // Regular expression for a valid email format
    var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    return emailPattern.test(email);
}

function isValidMobile(mobile) {
    // Regular expression for a valid mobile number format (10 digits)
    var mobilePattern = /^\d{10}$/;
    return mobilePattern.test(mobile);
}
