jQuery(document).ready(function($){
    var customLogoInput = $('#custom-logo-input');
    var customLogoPreview = $('#custom-logo-preview');

    $('#custom-logo-upload-button').on('click', function(e) {
        e.preventDefault();

        var customLogoUploader = wp.media({
            title: 'Select Custom Logo',
            button: {
                text: 'Upload Logo'
            },
            multiple: false
        });

        customLogoUploader.on('select', function() {
            var attachment = customLogoUploader.state().get('selection').first().toJSON();

            // Update the input field and preview
            customLogoInput.val(attachment.url);
            customLogoPreview.attr('src', attachment.url);

            // Send AJAX request to handle the logo upload
            var formData = new FormData();
            formData.append('custom_logo', attachment);
            formData.append('action', 'custom_logo_upload');

            $.ajax({
                type: 'POST',
                url: custom_logo_upload_vars.ajax_url,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error(error.responseText);
                }
            });
        });

        customLogoUploader.open();
    });
});


jQuery(document).ready(function($){
    var backgroundImageInput = $('#background-image-input');
    var backgroundImagePreview = $('#background-image-preview');

    $('#background-image-upload-button').on('click', function(e) {
        e.preventDefault();

        var backgroundImageUploader = wp.media({
            title: 'Select Background Image',
            button: {
                text: 'Upload Image'
            },
            multiple: false
        });

        backgroundImageUploader.on('select', function() {
            var attachment = backgroundImageUploader.state().get('selection').first().toJSON();

            // Update the input field and preview
            backgroundImageInput.val(attachment.url);
            backgroundImagePreview.attr('src', attachment.url);

            // Send AJAX request to handle the logo upload
            var formData = new FormData();
            formData.append('background_image', attachment);
            formData.append('action', 'background_image_upload');

            $.ajax({
                type: 'POST',
                url: custom_logo_upload_vars.ajax_url,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error(error.responseText);
                }
            });
        });

        backgroundImageUploader.open();
    });
});
