<?php

function dochive_field($type, $args = []) {

    $value = $args['value'] ?? '';
    $name  = $args['name'] ?? '';

    switch ($type) {

        case 'text':
            return "<input type='text' name='{$name}' value='".esc_attr($value)."' class='regular-text'>";

        case 'color':
            return "<input type='text' class='regular-text dochive-color' name='{$name}' value='".esc_attr($value)."'>";

        case 'media':
            $id = str_replace(['[', ']'], '_', $name);
            return "
                <div class='dochive-media-field' data-field='{$id}'>

                    <input type='hidden' id='{$id}' name='{$name}' value='" . esc_attr($value) . "'>

                    <button type='button' class='button upload-media' data-target='{$id}'>
                        Upload Image
                    </button>

                    <div class='media-preview'>
                        " . ($value ? "<img style='max-height:40px' src='" . esc_url($value) . "' />" : "") . "
                    </div>

                </div>
            ";

        case 'textarea':
            return "<textarea name='{$name}' class='regular-text'>{$value}</textarea>";

        default:
            return "";
    }
}