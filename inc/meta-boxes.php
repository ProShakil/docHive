<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Add Doctor Meta Box
|--------------------------------------------------------------------------
*/

function dochive_doctor_meta_box()
{
    add_meta_box(
        'doctor_information',
        'Doctor Information',
        'dochive_doctor_meta_callback',
        'doctor',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'dochive_doctor_meta_box');


/*
|--------------------------------------------------------------------------
| Meta Box Fields
|--------------------------------------------------------------------------
*/

function dochive_doctor_meta_callback($post)
{
    wp_nonce_field('doctor_meta_nonce', 'doctor_meta_nonce');

    $qualification = get_post_meta($post->ID, '_qualification', true);
    $experience    = get_post_meta($post->ID, '_experience', true);
    $gender        = get_post_meta($post->ID, '_gender', true);
    $registration  = get_post_meta($post->ID, '_registration', true);
    $featured      = get_post_meta($post->ID, '_featured', true);
    ?>

    <table class="form-table">

        <tr>
            <th>
                <label for="qualification">Qualification</label>
            </th>
            <td>
                <input
                    type="text"
                    id="qualification"
                    name="qualification"
                    class="regular-text"
                    value="<?php echo esc_attr($qualification); ?>"
                >
            </td>
        </tr>

        <tr>
            <th>
                <label for="experience">Experience</label>
            </th>
            <td>
                <input
                    type="text"
                    id="experience"
                    name="experience"
                    class="regular-text"
                    value="<?php echo esc_attr($experience); ?>"
                    placeholder="e.g. 12 Years"
                >
            </td>
        </tr>

        <tr>
            <th>
                <label for="gender">Gender</label>
            </th>
            <td>
                <select id="gender" name="gender">
                    <option value="">Select Gender</option>

                    <option value="Male" <?php selected($gender, 'Male'); ?>>
                        Male
                    </option>

                    <option value="Female" <?php selected($gender, 'Female'); ?>>
                        Female
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <th>
                <label for="registration">BMDC Registration No.</label>
            </th>
            <td>
                <input
                    type="text"
                    id="registration"
                    name="registration"
                    class="regular-text"
                    value="<?php echo esc_attr($registration); ?>"
                >
            </td>
        </tr>

        <tr>
            <th>
                Featured Doctor
            </th>
            <td>
                <label>
                    <input
                        type="checkbox"
                        name="featured"
                        value="1"
                        <?php checked($featured, 1); ?>
                    >
                    Mark as Featured Doctor
                </label>
            </td>
        </tr>

    </table>

    <?php
}


/*
|--------------------------------------------------------------------------
| Save Doctor Meta
|--------------------------------------------------------------------------
*/

function dochive_save_doctor_meta($post_id)
{
    if (!isset($_POST['doctor_meta_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['doctor_meta_nonce'], 'doctor_meta_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta(
        $post_id,
        '_qualification',
        sanitize_text_field($_POST['qualification'] ?? '')
    );

    update_post_meta(
        $post_id,
        '_experience',
        sanitize_text_field($_POST['experience'] ?? '')
    );

    update_post_meta(
        $post_id,
        '_gender',
        sanitize_text_field($_POST['gender'] ?? '')
    );

    update_post_meta(
        $post_id,
        '_registration',
        sanitize_text_field($_POST['registration'] ?? '')
    );

    update_post_meta(
        $post_id,
        '_featured',
        isset($_POST['featured']) ? 1 : 0
    );
}

add_action('save_post_doctor', 'dochive_save_doctor_meta');