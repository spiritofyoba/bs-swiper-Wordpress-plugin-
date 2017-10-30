<?php

// Needed to easy editing links, colors and order of slides

add_action('add_meta_boxes', 'my_extra_fields', 1);
add_action('add_meta_boxes', 'color_fields', 1);
add_action('add_meta_boxes', 'bs_slider_order', 1);

function my_extra_fields(){
    add_meta_box('extra_fields', 'Slide link', 'extra_fields_box_func', 'bs_slides', 'normal', 'high');
}

// Add link code block
function extra_fields_box_func($post){
    ?>
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td>
                <p style="font-size: 16px; margin: 0;line-height: 1;">Link</p>
            </td>
            <td>
                <p style="font-size: 16px; margin: 0;line-height: 1;">Link text</p>
            </td>
            <td colspan="2">
                <p style="font-size: 16px; margin: 0;line-height: 1;">Link color</p>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="extra[link]" placeholder="Link" value="<?php
                echo get_post_meta($post->ID, 'link', 1); ?>" style="width:100%" />
            </td>
            <td>
                <input type="text" name="extra[link_text]" placeholder="Link text" value="<?php
                echo get_post_meta($post->ID, 'link_text', 1); ?>" style="width:100%">
                <input type="hidden" name="extra_fields_nonce" value="<?php
                echo wp_create_nonce(__FILE__); ?>" />
            </td>
            <td style="width: 2%;border: 1px solid #000;background-color:<?php
            echo get_post_meta($post->ID, 'link_color', 1); ?>;">
                <?php
                if (empty(get_post_meta($post->ID, 'link_color', 1))) {
                    echo '<p style="text-align: center;margin:0">X</p>';
                }
                ?>
            </td>
            <td>
                <input type="text" name="extra[link_color]" placeholder="Link color" value="<?php
                echo get_post_meta($post->ID, 'link_color', 1); ?>" style="width:100%" />
            </td>
        </tr>
        </tbody>
    </table>
    <p style="font-size: 16px;">For use slider on your page, use this shortcode <span style="background-color: #fff9c0; padding: 5px;">[bs-swiper-slider]</span></p>

    <?php
}

add_action('save_post', 'my_extra_fields_update', 0);

function my_extra_fields_update($post_id){
    if (!isset($_POST['extra_fields_nonce']) || !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__)) return false; // verification
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false;
    if (!current_user_can('edit_post', $post_id)) return false;
    if (!isset($_POST['extra'])) return false;
    $_POST['extra'] = array_map('trim', $_POST['extra']);
    foreach($_POST['extra'] as $key => $value) {
        if (empty($value)) {
            delete_post_meta($post_id, $key);
            continue;
        }
        update_post_meta($post_id, $key, $value);
    }
    return $post_id;
}

// Add color code block

function color_fields(){
    add_meta_box('color_fields', 'Main color', 'color_fields_box_func', 'bs_slides', 'normal', 'high');
}

function color_fields_box_func($post){ ?>
    <table class="qwe" style="width: 100%;">
        <tbody>
        <tr>
            <td colspan="2">
                <p style="font-size: 16px; margin: 0;line-height: 1;">Small slider text</p>
            </td>
            <td colspan="2">
                <p style="font-size: 16px; margin: 0;line-height: 1;">Large slider text</p>
            </td>
        </tr>
        <tr>
            <td style="border:1px solid #000;width:2%;background-color: <?php
            echo get_post_meta($post->ID, 'header_color', 1); ?>;">
                <?php
                if (empty(get_post_meta($post->ID, 'header_color', 1))) {
                    echo '<p style="text-align: center;margin:0">X</p>';
                }

                ?>
            </td>
            <td>
                <input type="text" name="color[header_color]" placeholder="Header color" value="<?php
                echo get_post_meta($post->ID, 'header_color', 1); ?>" style="width:100%" />
            </td>
            <td style="border:1px solid #000;width:2%;background-color: <?php
            echo get_post_meta($post->ID, 'content_color', 1); ?>;">
                <?php
                if (empty(get_post_meta($post->ID, 'content_color', 1))) {
                    echo '<p style="text-align: center;margin:0">X</p>';
                }
                ?>
            </td>
            <td>
                <input type="text" name="color[content_color]" placeholder="Content color" value="<?php
                echo get_post_meta($post->ID, 'content_color', 1); ?>" style="width:100%">
                <input type="hidden" name="color_fields_nonce" value="<?php
                echo wp_create_nonce(__FILE__); ?>" />
            </td>
        </tr>
        </tbody>
    </table>
    <?php
}

add_action('save_post', 'color_fields_update', 0);

function color_fields_update($post_id){
    if (!isset($_POST['color_fields_nonce']) || !wp_verify_nonce($_POST['color_fields_nonce'], __FILE__)) return false; // verification
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false;
    if (!current_user_can('edit_post', $post_id)) return false;
    if (!isset($_POST['extra'])) return false;
    $_POST['color'] = array_map('trim', $_POST['color']);
    foreach($_POST['color'] as $key => $value) {
        if (empty($value)) {
            delete_post_meta($post_id, $key);
            continue;
        }
        update_post_meta($post_id, $key, $value);
    }
    return $post_id;
}

// for slides ordering
function bs_slider_order(){
    add_meta_box('bs_slider_order', 'Slide position (required)', 'bs_slider_order_function', 'bs_slides', 'normal', 'high');
}

// callback in metabox
function bs_slider_order_function($post){
    $slides_quantity = wp_count_posts('bs_slides');
    ?>
    <input required type="number" name="slide_position" placeholder="Slide position" value="<?php echo get_post_meta($post->ID, 'slide_position', 1); ?>" />
    <input type="hidden" name="slide_position_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

//for saving this value
add_action('save_post', 'bs_slide_position_update', 0);
function bs_slide_position_update($post_id){
    if (!isset($_POST['slide_position_nonce']) || !wp_verify_nonce($_POST['slide_position_nonce'], __FILE__)) return false; // verification
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false;
    if (!current_user_can('edit_post', $post_id)) return false;
    if (!isset($_POST['slide_position'])) return false;
    if (empty($_POST['slide_position'])){
        delete_post_meta($post_id, 'slide_position');
    }else{
        update_post_meta($post_id, 'slide_position', $_POST['slide_position']);
    }
    return $post_id;
}
