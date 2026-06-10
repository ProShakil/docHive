<?php
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/taxonomies.php';
require get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/admin-options.php';
require get_template_directory() . '/inc/chambers.php';
require get_template_directory() . '/inc/admin/dashboard.php';

function dochive_admin_assets($hook){

    if ($hook != 'post.php' && $hook != 'post-new.php') return;

    wp_enqueue_script('jquery-ui-sortable');

    wp_enqueue_script(
        'dochive-chambers',
        get_template_directory_uri() . '/assets/js/chambers.js',
        ['jquery','jquery-ui-sortable'],
        '1.0',
        true
    );

    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',
        [],
        '5.3.8'
    );

    wp_enqueue_style(
        'dochive-chambers',
        get_template_directory_uri() . '/assets/css/admin-chambers.css'
    );
}
add_action('admin_enqueue_scripts', 'dochive_admin_assets');
register_nav_menus([
    'primary'       => __('Primary Menu', 'dochive'),
    'footer_menu_1' => __('Footer Menu 1', 'dochive'),
    'footer_menu_2' => __('Footer Menu 2', 'dochive'),
    'footer_legal'  => __('Footer Legal Menu', 'dochive'),
]);


add_action('wp_ajax_dochive_save_options', function () {

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized');
    }

    $options = $_POST['dochive_options'] ?? [];

    update_option('dochive_options', $options);

    // Rebuild rewrite rules after saving options
    flush_rewrite_rules();

    wp_send_json_success([
        'message' => 'Saved successfully',
        'options' => $options
    ]);
});

add_action('wp_head', function () {

    $opt = get_option('dochive_options');

    $favicon = $opt['favicon'] ?? '';

    if (!$favicon) {
        $favicon = get_template_directory_uri() . '/assets/img/favicon.ico';
    }

    echo '<link rel="icon" href="' . esc_url($favicon) . '">';

});


// Login
add_action('init', function () {

    $options = get_option('dochive_options');

    if (
        isset($options['theme_login']) &&
        (int) $options['theme_login'] === 1
    ) {

        add_action('login_head', function () {
            include get_template_directory() . '/admin/page-doctor-login.php';
            exit;
        });

    }

});

/**
 * Get slug
 */
// 
$custom_login_active = false;

function block_default_login_access() {
    global $custom_login_active;
    $settings = get_option('dochive_options');
    if ( empty($settings['admin_url']) ) {
        return;
    }
    
    $custom_login_active = true;
    $request_uri = $_SERVER['REQUEST_URI'];
    if ( strpos($request_uri, 'wp-login.php?action=logout') !== false && isset($_GET['_wpnonce']) ) {
        wp_logout();
        $custom_url = home_url('/' . $settings['admin_url']);
        wp_redirect($custom_url);
        exit;
    }
    $is_login_url = ( strpos($request_uri, 'wp-login.php') !== false || 
                      strpos($request_uri, '/wp-admin') !== false || 
                      strpos($request_uri, '/wp-login') !== false );
    
    if ( !$is_login_url ) {
        return;
    }
    if ( is_user_logged_in() ) {
        if ( strpos($request_uri, '/wp-admin') !== false ) {
            return;
        }
        if ( strpos($uri, 'wp-login.php?action=logout') !== false ) {
            $custom_url = home_url('/' . $settings['admin_url']);
            wp_redirect($custom_url . '?loggedout=true');
            exit;
        }
        wp_redirect(admin_url());
        exit;
    }
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part('404');
    exit;
}

add_action( 'init', 'block_default_login_access' );

function custom_login_page() {
    global $custom_login_active;
    if ( !$custom_login_active ) {
        return;
    }
    
    $saved_settings = get_option('dochive_options');
    $custom_slug = $saved_settings['admin_url'];
    $request_uri = $_SERVER['REQUEST_URI'];
    if ( strpos( $request_uri, '/' . $custom_slug ) !== false ) {
        require_once( ABSPATH . 'wp-login.php' );
        exit;
    }
}
add_action( 'init', 'custom_login_page' );