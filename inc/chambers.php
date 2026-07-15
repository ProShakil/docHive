<?php

if (!defined('ABSPATH')) exit;

/*
|--------------------------------------------------------------------------
| Add Meta Box
|--------------------------------------------------------------------------
*/

function dochive_chambers_meta_box() {
    add_meta_box(
        'doctor_chambers',
        'Doctor Chambers',
        'dochive_chambers_callback',
        'doctor',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'dochive_chambers_meta_box');


/*
|--------------------------------------------------------------------------
| Render Meta Box
|--------------------------------------------------------------------------
*/

function dochive_chambers_callback($post) {

    $chambers = get_post_meta($post->ID, '_doctor_chambers', true);
    if (!is_array($chambers)) $chambers = [];

    wp_nonce_field('doctor_chambers_nonce', 'doctor_chambers_nonce');
?>

<div id="dochive-chambers-wrapper">

    <?php foreach ($chambers as $index => $chamber): ?>

        <div class="dochive-chamber">

            <div class="chamber-header">
                <h3>Chamber #<?php echo $index + 1; ?></h3>
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

                <div class="mb-3"><input type="text"
                    name="doctor_chambers[<?php echo $index; ?>][hospital]"
                    value="<?php echo esc_attr($chamber['hospital'] ?? ''); ?>"
                    placeholder="Hospital Name"
                    class="form-control"></div>

                <div class="mb-3"><input type="text"
                    name="doctor_chambers[<?php echo $index; ?>][district]"
                    value="<?php echo esc_attr($chamber['district'] ?? ''); ?>"
                    placeholder="District"
                    class="form-control"></div>

                <div class="mb-3"><input type="text"
                    name="doctor_chambers[<?php echo $index; ?>][area]"
                    value="<?php echo esc_attr($chamber['area'] ?? ''); ?>"
                    placeholder="Area"
                    class="form-control"></div>

                <div class="mb-3"><textarea
                    name="doctor_chambers[<?php echo $index; ?>][address]"
                    placeholder="Address"
                    class="form-control"><?php echo esc_textarea($chamber['address'] ?? ''); ?></textarea></div>

                <?php $schedules = $chamber['schedules'] ?? []; ?>

                <div class="schedule-wrapper">

                    <h4>Schedules</h4>

                    <?php foreach ($schedules as $sindex => $schedule) : ?>

                        <div class="schedule-item row g-2 align-items-center mb-3">

                            <div class="col-12 col-md">
                                <select class="form-select" name="doctor_chambers[<?php echo $index; ?>][schedules][<?php echo $sindex; ?>][day]">
        
                                    <?php
                                    $days = [
                                        'Saturday',
                                        'Sunday',
                                        'Monday',
                                        'Tuesday',
                                        'Wednesday',
                                        'Thursday',
                                        'Friday'
                                    ];
        
                                    foreach ($days as $day) :
                                    ?>
        
                                        <option value="<?php echo esc_attr($day); ?>"
                                            <?php selected($schedule['day'] ?? '', $day); ?>>
                                            <?php echo esc_html($day); ?>
                                        </option>
        
                                    <?php endforeach; ?>
        
                                </select>
                            </div>
                            <div class="col-12 col-md">
                                <input
                                    type="time"
                                    class="form-control"
                                    name="doctor_chambers[<?php echo $index; ?>][schedules][<?php echo $sindex; ?>][start_time]"
                                    value="<?php echo esc_attr($schedule['start_time'] ?? ''); ?>">
                            </div>
                            <div class="col-12 col-md">
                                <input
                                    type="time"
                                    class="form-control"
                                    name="doctor_chambers[<?php echo $index; ?>][schedules][<?php echo $sindex; ?>][end_time]"
                                    value="<?php echo esc_attr($schedule['end_time'] ?? ''); ?>">
                            </div>
                            <div class="col-12 col-md-auto">
                                <button type="button" class="button remove-schedule text-danger border-danger">
                                    <span class="dashicons dashicons-trash"></span>
                                </button>
                            </div>

                        </div>

                    <?php endforeach; ?>

                    <button type="button" class="button add-schedule">
                        Add Schedule
                    </button>

                </div>

                <!-- CONTACT -->
                <div class="mb-3">
                    <input type="text"
                    name="doctor_chambers[<?php echo $index; ?>][contact1]"
                    value="<?php echo esc_attr($chamber['contact1'] ?? ''); ?>"
                    placeholder="Contact 1"
                    class="form-control">
                </div>

                <div class="mb-3">
                    <input type="text"
                    name="doctor_chambers[<?php echo $index; ?>][contact2]"
                    value="<?php echo esc_attr($chamber['contact2'] ?? ''); ?>"
                    placeholder="Contact 2"
                    class="form-control">
                </div>

                <div class="mb-3">
                    <input type="text"
                    name="doctor_chambers[<?php echo $index; ?>][whatsapp]"
                    value="<?php echo esc_attr($chamber['whatsapp'] ?? ''); ?>"
                    placeholder="WhatsApp"
                    class="form-control">
                </div>

                <div class="mb-3">
                    <input type="url"
                    name="doctor_chambers[<?php echo $index; ?>][map]"
                    value="<?php echo esc_attr($chamber['map'] ?? ''); ?>"
                    placeholder="Google Map URL"
                    class="form-control">
                </div>

            </div>
        </div>

    <?php endforeach; ?>

</div>

<button type="button" class="button button-primary" id="add-chamber">
    Add Chamber
</button>

<?php
}

/*
|--------------------------------------------------------------------------
| Save Chambers
|--------------------------------------------------------------------------
*/

function dochive_save_chambers($post_id)
{
    // Nonce check
    if (
        !isset($_POST['doctor_chambers_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(wp_unslash($_POST['doctor_chambers_nonce'])),
            'doctor_chambers_nonce'
        )
    ) {
        return;
    }

    // Autosave
    if (
        defined('DOING_AUTOSAVE') &&
        DOING_AUTOSAVE
    ) {
        return;
    }

    // Permission check
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $chambers = $_POST['doctor_chambers'] ?? [];

    update_post_meta(
        $post_id,
        '_doctor_chambers',
        $chambers
    );
}

add_action(
    'save_post_doctor',
    'dochive_save_chambers'
);