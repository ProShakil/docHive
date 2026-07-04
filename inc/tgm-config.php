<?php

add_action('tgmpa_register', 'mytheme_register_required_plugins');

function mytheme_register_required_plugins() {

    $plugins = array(

        // array(
        //     'name' => 'Elementor',
        //     'slug' => 'elementor',
        //     'required' => true,
        // ),

        array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'required' => true,
        ),
    );

    tgmpa($plugins);
}