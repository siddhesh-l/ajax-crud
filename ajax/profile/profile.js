
// Fetch user data and populate the form
$.ajax({
    url: 'fetch_profile_info.php',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
        if (response.success) {
            var personalInfo = response.personal_info;

            // Populate the form fields with personal information
            $('#name').val(personalInfo.name);
            $('#mobile').val(personalInfo.mobile);

            // Check the appropriate radio button based on the user's gender
            $("input[name='gender'][value='" + personalInfo.gender + "']").prop('checked', true);
        } else {
            alert('Failed to fetch personal information.');
        }
    }
});

// Handle personal information form submission
$('#infoForm').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'update_profile.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success) {
                $('#updateMessage').show().text('Failed to update personal information: ' + response.message).css('color', 'red');
            } else {
                $('#updateMessage').show().text('Personal information updated successfully.').css('color', 'green');
            }
        }
    });
});

// Handle image upload
$('#updateImage').on('click', function (e) {
    e.preventDefault();
    var formData = new FormData($('#imageUploadForm')[0]);

    $.ajax({
        url: 'update_profile.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success) {
                alert('Profile image updated successfully.');
            } else {
                alert('Failed to update profile image: ' + response.message);
            }
        }
    });
});
