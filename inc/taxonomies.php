<?php

if (!defined('ABSPATH')) {
    exit;
}

function dochive_register_taxonomies()
{
    $labels = [
        'name'              => __('Specialties', 'dochive'),
        'singular_name'     => __('Specialty', 'dochive'),
        'search_items'      => __('Search Specialties', 'dochive'),
        'all_items'         => __('All Specialties', 'dochive'),
        'parent_item'       => __('Parent Specialty', 'dochive'),
        'parent_item_colon' => __('Parent Specialty:', 'dochive'),
        'edit_item'         => __('Edit Specialty', 'dochive'),
        'update_item'       => __('Update Specialty', 'dochive'),
        'add_new_item'      => __('Add New Specialty', 'dochive'),
        'new_item_name'     => __('New Specialty Name', 'dochive'),
        'menu_name'         => __('Specialties', 'dochive'),
    ];
    register_taxonomy(
        'specialty',
        ['doctor'],
        [
            'labels'            => $labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'show_in_nav_menus' => true,
            'rewrite' => [
                'slug' => 'specialty'
            ]
        ]
    );
}

add_action('init', 'dochive_register_taxonomies');


