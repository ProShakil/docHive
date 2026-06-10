jQuery(document).ready(function($){

    $('.dochive-tab').on('click', function () {

        var target = $(this).data('tab');

        $('.dochive-tab').removeClass('active');
        $('.tab-content').removeClass('active');

        $(this).addClass('active');
        $('#' + target).addClass('active');

    });



    // TopBar


    function toggleTopbarFields() {
        if ($('#topbar_toggle').is(':checked')) {
            $('.topbar-fields').removeClass('hidden');
        } else {
            $('.topbar-fields').addClass('hidden');
        }
    }

    // run on load
    toggleTopbarFields();

    // run on change
    $('#topbar_toggle').on('change', function () {
        toggleTopbarFields();
    });
    let totalNetworks = 6;
    let currentCount = $('.social-row').length;
    $('#add-social').on('click', function(){
        if (currentCount >= totalNetworks) {
            return;
        }
        var index = $('#social-repeater .social-row').length; 
        var row = ` 
        <div class="social-row"> 
            <select name="dochive_options[socials][${index}][icon]" class="social-icon">
                <option value="">Select</option>  
                <option value="bi-facebook">Facebook</option> 
                <option value="bi-instagram">Instagram</option> 
                <option value="bi-linkedin">LinkedIn</option> 
                <option value="bi-twitter-x">X (Twitter)</option>
                <option value="bi-youtube">YouTube</option> 
                <option value="bi-tiktok">TikTok</option> 
            </select> 
            <input type="url" name="dochive_options[socials][${index}][link]" placeholder="https://example.com" class="regular-text"> 
            <button type="button" class="button remove-social"><span class="dashicons dashicons-trash"></span></button> 
        </div> `; 
        $('#social-repeater').append(row);
        currentCount++;
        refreshSocialOptions(); 
    }); 

    // Remove row 
    $(document).on('click', '.remove-social', function(){ 
        $(this).closest('.social-row').remove();
        currentCount--;
        refreshSocialOptions(); 
    });

    function refreshSocialOptions() {

        let selected = [];

        $('select.social-icon').each(function() {

            let value = $(this).val();

            if (value) {
                selected.push(value);
            }

        });

        $('select.social-icon').each(function() {

            let current = $(this).val();

            $(this).find('option').prop('disabled', false);

            selected.forEach(function(item){

                if (item !== current) {
                    $(this)
                        .find('option[value="'+ item +'"]')
                        .prop('disabled', true);
                }

            }.bind(this));

        });

        if (currentCount >= totalNetworks) {
            $("#add-social").hide();
        }
        else{
            $("#add-social").show();
        }

    }

    refreshSocialOptions();

    $(document).on('change', '.social-icon', function(){
        refreshSocialOptions();
    });

    $('.dochive-color').wpColorPicker();

    // Save

    $('#dochive-form').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData + '&action=dochive_save_options',
            beforeSend: function () {
                $('.button-primary').text('Saving...');
            },
            success: function (res) {

                $('.button-primary').text('Saved ✔');

                setTimeout(() => {
                    $('.button-primary').text('Save Changes');
                }, 1000);
            }
        });
    });
    $('.dochive-tab').on('click', function () {

        let tab = $(this).data('tab');

        $('.dochive-tab').removeClass('active');
        $(this).addClass('active');

        $('.tab-content').removeClass('active');
        $('#' + tab).addClass('active');

        // no reload, just UI state
    });

    // Branding

    $(document).on('click', '.upload-media', function (e) {
        e.preventDefault();

        let button = $(this);
        let targetId = button.data('target');
        let input = $('#' + targetId);

        let frame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Use Image'
            },
            multiple: false
        });

        frame.on('select', function () {

            let attachment = frame.state().get('selection').first().toJSON();

            // save value
            input.val(attachment.url);

            // ONLY THIS FIELD preview update (FIXED)
            button.closest('.dochive-media-field')
                .find('.media-preview')
                .html('<img src="' + attachment.url + '" style="max-width:120px;height:auto;border:1px solid #ddd;padding:3px;border-radius:4px;" />');
        });

        frame.open();
    });


    // Admin Config

});