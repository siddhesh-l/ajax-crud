$(document).ready(function () {
    // Fetch user data and populate the form
    $.ajax({
        url: 'fetch_profile_info.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                var userData = response.user_data;

                // Populate the form fields with user data
                $('#name').val(userData.name);
                $('#mobile').val(userData.mobile);
                $("input[name='gender'][value='" + userData.gender + "']").prop('checked', true);

                if (userData.image) {
                    $('#previewImage').attr('src', userData.image);
                }
            } else {
                alert('Failed to fetch user data.');
            }
        }
    });

    // Handle form submission
    $('#updateProfileForm').on('submit', function (e) {
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
                    alert('Profile updated successfully.');
                } else {
                    alert('Failed to update profile: ' + response.message);
                }
            }
        });
    });
});
