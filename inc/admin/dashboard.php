<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Remove Default Dashboard Widgets
|--------------------------------------------------------------------------
*/

function dochive_remove_dashboard_widgets()
{
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_browser_nag', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'dochive_remove_dashboard_widgets', 999);


/*
|--------------------------------------------------------------------------
| Dashboard Layout Fix
|--------------------------------------------------------------------------
*/

function dochive_dashboard_styles()
{
    ?>
    <style>

        #normal-sortables,
        #postbox-container-1{
            width:100% !important;
        }

        #dochive_dashboard .inside{
            margin:0 !important;
            padding:0 !important;
        }

        #dochive_dashboard .postbox-header{
            display:none !important;
        }

        #dochive_dashboard.postbox{
            border:none !important;
            background:transparent !important;
            box-shadow:none !important;
        }

    </style>
    <?php
}
add_action('admin_head-index.php', 'dochive_dashboard_styles');


/*
|--------------------------------------------------------------------------
| Register Dashboard Widget
|--------------------------------------------------------------------------
*/

function dochive_register_dashboard()
{
    wp_add_dashboard_widget(
        'dochive_dashboard',
        'DocHive Dashboard',
        'dochive_dashboard_callback'
    );
}
add_action('wp_dashboard_setup', 'dochive_register_dashboard');


/*
|--------------------------------------------------------------------------
| Dashboard Content
|--------------------------------------------------------------------------
*/

function dochive_dashboard_callback()
{
    $total_doctors = wp_count_posts('doctor')->publish;

    $total_specialties = wp_count_terms([
        'taxonomy'   => 'specialty',
        'hide_empty' => false
    ]);

    $doctor_ids = get_posts([
        'post_type'      => 'doctor',
        'posts_per_page' => -1,
        'fields'         => 'ids'
    ]);

    $total_chambers = 0;
    $total_contacts = 0;
    

    foreach ($doctor_ids as $doctor_id) {

        $chambers = get_post_meta(
            $doctor_id,
            '_doctor_chambers',
            true
        );

        if (!is_array($chambers)) {
            continue;
        }

        $total_chambers += count($chambers);

        foreach ($chambers as $chamber) {

            if (!empty($chamber['contact1'])) {
                $total_contacts++;
            }

            if (!empty($chamber['contact2'])) {
                $total_contacts++;
            }

            if (!empty($chamber['whatsapp'])) {
                $total_contacts++;
            }
        }
    }

    $recent_doctors = get_posts([
        'post_type'      => 'doctor',
        'posts_per_page' => 5,
        'post_status'    => 'publish'
    ]);

    $current_month_doctors = count(get_posts([
        'post_type'      => 'doctor',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'date_query' => [
            [
                'year'  => date('Y'),
                'month' => date('m')
            ]
        ]
    ]));   

    $current_month_chambers = 0;
    $current_month_contacts = 0;
    $month_doctors = get_posts([
        'post_type'      => 'doctor',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'date_query' => [
            [
                'year'  => date('Y'),
                'month' => date('m')
            ]
        ]
    ]);

    foreach ($month_doctors as $doctor) {

        $chambers = get_post_meta(
            $doctor->ID,
            '_doctor_chambers',
            true
        );

        if (is_array($chambers)) {
            $current_month_chambers += count($chambers);
        }

        foreach ($chambers as $chamber) {

            if (!empty($chamber['contact1'])) {
                $current_month_contacts++;
            }

            if (!empty($chamber['contact2'])) {
                $current_month_contacts++;
            }

            if (!empty($chamber['whatsapp'])) {
                $current_month_contacts++;
            }
        }
    }

    $current_month_specialties = wp_count_terms([
        'taxonomy'   => 'specialty',
        'hide_empty' => false,
        'date_query' => [
            [
                'year'  => date('Y'),
                'month' => date('m')
            ]
        ]
    ]);

?>

<div class="dochive-dashboard">

    <div class="dochive-stats">

        <div class="dochive-stat-card">
            <div class="stat-title">Total Doctors</div>
            <div class="stat-number"><?php echo esc_html($total_doctors); ?></div>
            <div class="stat-growth">+<?php echo $current_month_doctors; ?> this month</div>
        </div>

        <div class="dochive-stat-card">
            <div class="stat-title">Total Chambers</div>
            <div class="stat-number"><?php echo esc_html($total_chambers); ?></div>
            <div class="stat-growth">+<?php echo $current_month_chambers; ?> this month</div>
        </div>

        <div class="dochive-stat-card">
            <div class="stat-title">Total Specialties</div>
            <div class="stat-number"><?php echo esc_html($total_specialties); ?></div>
            <div class="stat-growth">+<?php echo $current_month_specialties; ?> this month</div>
        </div>

        <div class="dochive-stat-card">
            <div class="stat-title">Total Contacts</div>
            <div class="stat-number"><?php echo esc_html($total_contacts); ?></div>
            <div class="stat-growth">+<?php echo esc_html($current_month_contacts); ?> this month</div>
        </div>

    </div>

    <div class="dochive-panel">

        <div class="dochive-panel-header">
            Recent Doctors
        </div>

        <table class="dochive-table">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialty</th>
                    <th>Chambers</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($recent_doctors as $doctor) : ?>

                <?php

                $terms = get_the_terms(
                    $doctor->ID,
                    'specialty'
                );

                $specialty = !empty($terms)
                    ? $terms[0]->name
                    : '-';

                $chambers = get_post_meta(
                    $doctor->ID,
                    '_doctor_chambers',
                    true
                );

                $count = is_array($chambers)
                    ? count($chambers)
                    : 0;

                ?>

                <tr>

                    <td>
                        <a href="<?php echo esc_url(get_edit_post_link($doctor->ID)); ?>">
                            <?php echo esc_html($doctor->post_title); ?>
                        </a>
                    </td>

                    <td>
                        <?php echo esc_html($specialty); ?>
                    </td>

                    <td>
                        <?php echo esc_html($count); ?>
                    </td>

                    <td>
                        <span class="status-publish">
                            Publish
                        </span>
                    </td>

                    <td>
                        <?php echo esc_html(get_the_date('M d, Y', $doctor->ID)); ?>
                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div class="dochive-panel">

        <div class="dochive-panel-header">
            Quick Links
        </div>

        <div class="dochive-actions">

            <a href="<?php echo esc_url(admin_url('post-new.php?post_type=doctor')); ?>">
                Add New Doctor
            </a>

            <a href="<?php echo esc_url(admin_url('edit.php?post_type=doctor')); ?>">
                All Doctors
            </a>

            <a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=specialty&post_type=doctor')); ?>">
                Add New Specialty
            </a>

            <a href="<?php echo esc_url(admin_url('admin.php?page=dochive-options')); ?>">
                Theme Options
            </a>

        </div>

    </div>
</div>

<?php
}