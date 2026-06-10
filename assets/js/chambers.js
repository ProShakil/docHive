jQuery(document).ready(function($){

    let wrapper = $('#dochive-chambers-wrapper');

    // ADD CHAMBER
    $('#add-chamber').on('click', function(){

        let index = $('.dochive-chamber').length;

        wrapper.append(`
            <div class="dochive-chamber">
                
                <div class="chamber-header">
                    <h3>Chamber #${index + 1}</h3>
                    <div class="chamber-actions">
                        <button type="button" class="button remove-chamber text-danger border-danger" title="Delete">
                            <span class="dashicons dashicons-trash"></span>
                        </button>
                        <button type="button" class="button toggle-chamber" title="Collapse">
                            <span class="dashicons dashicons-arrow-up-alt2"></span>
                        </button>
                    </div>
                </div>

                <div class="chamber-body">

                    <input type="text" name="doctor_chambers[${index}][hospital]" placeholder="Hospital Name" class="widefat mb-2">
                    <input type="text" name="doctor_chambers[${index}][district]" placeholder="District" class="widefat mb-2">
                    <input type="text" name="doctor_chambers[${index}][area]" placeholder="Area" class="widefat mb-2">
                    <textarea name="doctor_chambers[${index}][address]" placeholder="Address" class="widefat"></textarea>

                    <div class="schedule-wrapper">

                    <h4>Schedules</h4>

                    <div class="schedule-item">

                        <select name="doctor_chambers[${index}][schedules][0][day]">
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>

                        <input type="time"
                            name="doctor_chambers[${index}][schedules][0][start_time]">

                        <input type="time"
                            name="doctor_chambers[${index}][schedules][0][end_time]">

                        <button type="button" class="button remove-schedule text-danger border-danger">
                            <span class="dashicons dashicons-trash"></span>
                        </button>

                    </div>
                    <button type="button" class="button add-schedule">
                        Add Schedule
                    </button>

                </div>

                    <input type="text" name="doctor_chambers[${index}][contact1]" placeholder="Contact 1" class="widefat mb-2">
                    <input type="text" name="doctor_chambers[${index}][contact2]" placeholder="Contact 2" class="widefat mb-2">
                    <input type="text" name="doctor_chambers[${index}][whatsapp]" placeholder="WhatsApp" class="widefat mb-2">
                    <input type="url" name="doctor_chambers[${index}][map]" placeholder="Google Map URL" class="widefat mb-2">

                </div>
            </div>
        `);
    });

    // REMOVE
    $(document).on('click', '.remove-chamber', function(){
        $(this).closest('.dochive-chamber').remove();
    });

    // COLLAPSE
    // $(document).on('click', '.toggle-chamber', function(){
    //     $(this).closest('.dochive-chamber').find('.chamber-body').slideToggle();
    // });
    $(document).on('click', '.toggle-chamber', function(){

        let body = $(this)
            .closest('.dochive-chamber')
            .find('.chamber-body');

        body.slideToggle();

        let icon = $(this).find('.dashicons');

        if(icon.hasClass('dashicons-arrow-up-alt2')){
            icon.removeClass('dashicons-arrow-up-alt2')
                .addClass('dashicons-arrow-down-alt2');
        }else{
            icon.removeClass('dashicons-arrow-down-alt2')
                .addClass('dashicons-arrow-up-alt2');
        }

    });
    $(document).on('click', '.add-schedule', function(){

        let wrapper = $(this).closest('.schedule-wrapper');

        let chamber = $(this).closest('.dochive-chamber');

        let cIndex = $('.dochive-chamber').index(chamber);

        let sIndex = wrapper.find('.schedule-item').length;

        wrapper.find('.add-schedule').before(`
            <div class="schedule-item">

                <select name="doctor_chambers[${cIndex}][schedules][${sIndex}][day]">
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>

                <input type="time"
                    name="doctor_chambers[${cIndex}][schedules][${sIndex}][start_time]">

                <input type="time"
                    name="doctor_chambers[${cIndex}][schedules][${sIndex}][end_time]">
                <button type="button" class="button remove-schedule text-danger border-danger">
                    <span class="dashicons dashicons-trash"></span>
                </button>

            </div>
        `);

    });

    $(document).on('click', '.remove-schedule', function(){
        $(this).closest('.schedule-item').remove();
    });

    // SORTABLE
    wrapper.sortable({
        items: '.dochive-chamber',
        handle: '.chamber-header',
        axis: 'y'
    });

});