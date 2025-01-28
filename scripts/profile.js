$(document).ready(function () {
    // Handle field update
    $('.edit-btn').on('click', function () {
        const field = $(this).data('field');
        const currentValue = $(`#${field}`).text();
        const newValue = prompt(`Enter new ${field.replace('_', ' ')}:`, currentValue);

        if (newValue !== null && newValue !== currentValue) {
            $.ajax({
                url: '../../modules/profile/profile_handler.php',
                method: 'POST',
                data: {
                    action: 'update_field',
                    field: field,
                    value: newValue
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        $(`#${field}`).text(newValue);
                        alert('Update successful!');
                    } else {
                        alert('Update failed: ' + res.message);
                    }
                }
            });
        }
    });

    // Add qualification
    $('#addQualificationBtn').on('click', function () {
        const qualification = $('#newQualification').val();
        if (qualification) {
            $.ajax({
                url: '../../modules/profile/profile_handler.php',
                method: 'POST',
                data: {
                    action: 'add_qualification',
                    qualification: qualification
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        $('#qualificationsList').append(`<li>${qualification} <button class="remove-btn" data-id="${res.id}">Remove</button></li>`);
                        $('#newQualification').val('');
                    } else {
                        alert('Failed to add qualification: ' + res.message);
                    }
                }
            });
        }
    });

    // Remove qualification
    $(document).on('click', '.remove-btn', function () {
        const id = $(this).data('id');
        const listItem = $(this).closest('li');

        $.ajax({
            url: '../../modules/profile/profile_handler.php',
            method: 'POST',
            data: {
                action: 'remove_qualification',
                id: id
            },
            success: function (response) {
                const res = JSON.parse(response);
                if (res.success) {
                    listItem.remove();
                } else {
                    alert('Failed to remove qualification: ' + res.message);
                }
            }
        });
    });

        // Update profile picture
        $('#updatePictureBtn').on('click', function () {
            const fileInput = $(this)[0];
            const file = fileInput.files[0];
    
            if (file) {
                const formData = new FormData();
                formData.append('action', 'update_field');
                formData.append('field', 'profile_picture');
                formData.append('value', file);
    
                $.ajax({
                    url: '../../modules/profile/profile_handler.php',
                    method: 'POST',
                    data: formData,
                    processData: false, // Required for FormData
                    contentType: false, // Required for FormData
                    success: function (response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            $('#profilePicturePreview').attr('src', `path_to_images/${res.file_name}`);
                            alert('Profile picture updated successfully!');
                        } else {
                            alert('Failed to update profile picture: ' + res.message);
                        }
                    }
                });
            }
        });
});
