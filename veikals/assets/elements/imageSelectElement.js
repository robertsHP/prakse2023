
function initAJAX (fileInputID, selectedImageID, deleteButtonID) {
    // Attach a click event handler to the button
    $(deleteButtonID).on("click", function() {
        // Send an AJAX POST request
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: { action: 'removePhotoPath' },
            success: function(response) {
                // Handle the successful response here
                // console.log(response);
                $(fileInputID).show().val('');
                $(selectedImageID).hide();
                $(deleteButtonID).hide();
            },
            error: function(xhr, status, error) {
                // Handle the error
                console.error('Error: ' + status);
            }
        });
    });
    $(fileInputID).change(function() {
        var fileInput = this;

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(selectedImageID).attr('src', e.target.result)

                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: { 
                        action: 'updatePhotoPath', 
                        imageData: fileInput.files[0].name 
                    },
                    success: function(response) {
                        // Handle the successful response here
                        // console.log(response);
                        $(fileInputID).hide();
                        $(selectedImageID).show();
                        $(deleteButtonID).show();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error
                        console.error('Error: ' + status);
                    }
                });
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    });
}

function initImageSelect (elementValue, fileInputID, selectedImageID, deleteButtonID) {
    $(selectedImageID).on('mouseover', function () {
        $(this).css('cursor', 'pointer');
    });
    $(selectedImageID).on('mouseout', function () {
        $(this).css('cursor', 'default');
    });

    if(elementValue != '') {
        $(fileInputID).hide();
        $(selectedImageID).show();
        $(deleteButtonID).show();
    } else {
        $(fileInputID).show();
        $(selectedImageID).hide();
        $(deleteButtonID).hide();
    }
}