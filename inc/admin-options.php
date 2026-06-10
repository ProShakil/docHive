<?php

require get_template_directory() . '/inc/fields.php';
require get_template_directory() . '/inc/sanitize.php';

add_action('admin_menu', function () {

    add_menu_page(
        'Dochive Options',
        'DocHive',
        'manage_options',
        'dochive-options',
        'dochive_render_options_page',
        'dashicons-admin-customizer',
        5
    );
});

add_action('admin_init', function () {
    register_setting(
        'dochive_options_group', 
        'dochive_options',
        [
            'sanitize_callback' => 'dochive_sanitize_options'
        ]
    );
});

function dochive_render_options_page() {
    include get_template_directory() . '/admin/theme-options-page.php';
}

function dochive_opt($key, $default = '') {
    $opt = get_option('dochive_options');
    return $opt[$key] ?? $default;
}