<?php

// all needed assets
add_action('wp_enqueue_scripts', 'bs_swiper');
function bs_swiper(){
    wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js');
    wp_enqueue_style('bs-style', plugin_dir_url(__FILE__) . '/style.css');
    wp_enqueue_style('bs-screen', plugin_dir_url(__FILE__) . '/screen.css');
    wp_enqueue_style('swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/css/swiper.min.css');
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_script('bs-script', plugin_dir_url(__FILE__) . '/script.js');
    wp_enqueue_script('bs-bslider', plugin_dir_url(__FILE__) . '/bslider.min.js');
    wp_enqueue_script('bs-parser', plugin_dir_url(__FILE__) . '/ua-parser.min.js');
    wp_enqueue_script('swiper-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/js/swiper.min.js');
    }

// custom post type for our swiper
add_action('init', 'bs_swiper_register_post_type');
function bs_swiper_register_post_type(){
    register_post_type('bs_slides', array(
        'label' => null,
        'labels' => array(
            'name' => 'BS-Slides', // Main name for the post type
            'singular_name' => 'Slide', // Name for single post of this type
            'add_new' => 'Add slide', // Add a new post
            'add_new_item' => 'Add new slide', // Header at the newly created entry in the admin panel
            'edit_item' => 'Edit slide', // Edit the type of post
            'new_item' => 'New slide', // New entry text
            'view_item' => 'Watch slide', // View a post of this type
            'search_items' => 'Search slides', // Search for these types of posts
            'not_found' => 'Not found', // If nothing was found as a result of the search
            'not_found_in_trash' => 'Not found in trash', // If it was not found in the cart
            'parent_item_colon' => '', // For parents (for tree types)
            'menu_name' => 'BS-Slider', // Menu name
        ) ,
        'description' => '',
        'public' => true,
        'publicly_queryable' => null,
        'exclude_from_search' => null,
        'show_ui' => null,
        'show_in_menu' => null,
        'show_in_admin_bar' => null,
        'show_in_nav_menus' => null,
        'show_in_rest' => null,
        'rest_base' => null,
        'menu_position' => null,
        'menu_icon' => null,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ) , 
        'taxonomies' => array() ,
        'has_archive' => false,
        'rewrite' => true,
        'query_var' => true,
    ));
    }

// This is our slide template
add_shortcode('bs-swiper-slider', 'bs_swiper_shortcode');
function bs_swiper_shortcode(){
    require_once ('swiper-template.php');
    }

//slide settings
require_once('slide-settings.php');
