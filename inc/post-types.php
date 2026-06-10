<?php

if (!defined('ABSPATH')) {
    exit;
}

function dochive_register_post_types()
{
    $labels = [
        'name'               => __('Doctors', 'dochive'),
        'singular_name'      => __('Doctor', 'dochive'),
        'add_new'            => __('Add Doctor', 'dochive'),
        'add_new_item'       => __('Add New Doctor', 'dochive'),
        'edit_item'          => __('Edit Doctor', 'dochive'),
        'new_item'           => __('New Doctor', 'dochive'),
        'view_item'          => __('View Doctor', 'dochive'),
        'search_items'       => __('Search Doctors', 'dochive'),
        'not_found'          => __('No Doctors Found', 'dochive'),
        'menu_name'          => __('Doctors', 'dochive'),
        'featured_image'        => __('Doctor Profile Image', 'dochive'),
        'set_featured_image'    => __('Set Doctor Profile Image', 'dochive'),
        'remove_featured_image' => __('Remove Doctor Profile Image', 'dochive'),
        'use_featured_image'    => __('Use as Doctor Profile Image', 'dochive'),
    ];

    register_post_type('doctor', [
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-id',
        'has_archive'        => true,
        'rewrite'            => [
            'slug' => 'doctors'
        ],
        'supports' => [
            'title',
            'editor',
            'thumbnail'
        ],
        'show_in_rest'       => true,
        'menu_position'      => 5,
    ]);
}

add_action('init', 'dochive_register_post_types');

function dochive_change_title_placeholder($title, $post)
{
    if ($post->post_type === 'doctor') {
        return __('Add Doctor Name', 'dochive');
    }

    return $title;
}

add_filter('enter_title_here', 'dochive_change_title_placeholder', 10, 2);