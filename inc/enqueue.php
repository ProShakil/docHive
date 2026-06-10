<?php

function dochive_enqueue_assets()
{
    /*
    |--------------------------------------------------------------------------
    | Bootstrap CSS
    |--------------------------------------------------------------------------
    */
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',
        [],
        '5.3.8'
    );

    /*
    |--------------------------------------------------------------------------
    | Bootstrap Icons
    |--------------------------------------------------------------------------
    */
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css',
        [],
        '1.13.1'
    );
    /*
    |--------------------------------------------------------------------------
    | Theme CSS
    |--------------------------------------------------------------------------
    */
    wp_enqueue_style(
        'dochive-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        '1.0.0'
    );
    

    /*
    |--------------------------------------------------------------------------
    | Bootstrap JS Bundle
    |--------------------------------------------------------------------------
    */
    wp_enqueue_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js',
        [],
        '5.3.8',
        true
    );

    wp_enqueue_script(
        'jquery-cdn',
        'https://code.jquery.com/jquery-3.7.1.min.js',
        [],
        '3.7.1',
        true
    );

    /*
    |--------------------------------------------------------------------------
    | Theme JS
    |--------------------------------------------------------------------------
    */
    wp_enqueue_script(
        'dochive-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.0.0',
        true
    );
    
}

add_action('wp_enqueue_scripts', 'dochive_enqueue_assets');


add_action('admin_enqueue_scripts', function($hook){

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    if ($hook == 'index.php') {

        wp_enqueue_style(
            'dochive-dashboard',
            get_template_directory_uri() . '/assets/css/dashboard.css',
            [],
            '1.0.0'
        );
    }

    if ($hook != 'toplevel_page_dochive-options') return;

    wp_enqueue_media();

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    wp_enqueue_script(
        'dochive-admin',
        get_template_directory_uri() . '/assets/js/admin-options.js',
        ['jquery', 'wp-color-picker'],
        '1.0',
        true
    );

    wp_enqueue_style(
        'dochive-admin-css',
        get_template_directory_uri() . '/assets/css/admin.css'
    );

    
});