<?php

if (!defined('ABSPATH')) {
    exit;
}

function dochive_sanitize_options($input)
{
    $output = [];

    /*
    |--------------------------------------------------------------------------
    | Top Bar
    |--------------------------------------------------------------------------
    */

    $output['topbar_enable'] = !empty($input['topbar_enable']) ? 1 : 0;

    $output['topbar_email'] = sanitize_email(
        $input['topbar_email'] ?? ''
    );
    
    $output['topbar_phone'] = sanitize_text_field(
        $input['topbar_phone'] ?? ''
    );
        
    $output['topbar_bg'] = sanitize_text_field(
        $input['topbar_bg'] ?? ''
    );
    $output['topbar_text'] = sanitize_text_field(
        $input['topbar_text'] ?? ''
    );
    /*
    |--------------------------------------------------------------------------
    | Social Media
    |--------------------------------------------------------------------------
    */

    $allowed_icons = [
        'bi-facebook',
        'bi-instagram',
        'bi-linkedin',
        'bi-twitter-x',
        'bi-youtube',
        'bi-tiktok',
    ];

    $output['socials'] = [];

    if (!empty($input['socials']) && is_array($input['socials'])) {

        foreach ($input['socials'] as $social) {

            $icon = sanitize_text_field(
                $social['icon'] ?? ''
            );

            $link = esc_url_raw(
                $social['link'] ?? ''
            );

            if (
                empty($icon) ||
                empty($link) ||
                !in_array($icon, $allowed_icons, true)
            ) {
                continue;
            }

            $output['socials'][] = [
                'icon' => $icon,
                'link' => $link,
            ];
        }
    }


    // Footer
    $output['footer_bg'] = sanitize_text_field(
        $input['footer_bg'] ?? ''
    );
    $output['footer_text'] = sanitize_text_field(
        $input['footer_text'] ?? ''
    );
    $output['footer_desc'] = sanitize_text_field(
        $input['footer_desc'] ?? ''
    );
    $output['footer_address'] = sanitize_text_field(
        $input['footer_address'] ?? ''
    );
    $output['copyright_text'] = sanitize_text_field(
        $input['copyright_text'] ?? ''
    );

    // Branding
    $output['logo'] = esc_url_raw(
        $input['logo'] ?? ''
    );

    $output['footer_logo'] = esc_url_raw(
        $input['footer_logo'] ?? ''
    );

    $output['favicon'] = esc_url_raw(
        $input['favicon'] ?? ''
    );

    $output['per_page'] = sanitize_text_field(
        $input['per_page'] ?? ''
    );
    $output['layout'] = sanitize_text_field(
        $input['layout'] ?? ''
    );

    // Admin Config
    $output['theme_login'] = !empty($input['theme_login']) ? 1 : 0;
    $output['login_logo'] = esc_url_raw(
        $input['login_logo'] ?? ''
    );
    $output['admin_url'] = sanitize_text_field(
        $input['admin_url'] ?? ''
    );
    return $output;
}