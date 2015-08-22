<?php

if ( !defined('ABSPATH')) exit;

function register_post_type_init() {
    
    $labels = array(
        'name'          => __( 'Mega Menu', THEME_LANG ),
        'singular_name' => __( 'Mega Menu Item', THEME_LANG ),
        'add_new'       => __( 'Add New', THEME_LANG ),
        'add_new_item'  => __( 'Add New Menu Item', THEME_LANG ),
        'edit_item'     => __( 'Edit Menu Item', THEME_LANG ),
        'new_item'      => __( 'New Menu Item', THEME_LANG ),
        'view_item'     => __( 'View Menu Item', THEME_LANG ),
        'search_items'  => __( 'Search Menu Items', THEME_LANG ),
        'not_found'     => __( 'No Menu Items found', THEME_LANG ),
        'not_found_in_trash' => __( 'No Menu Items found in Trash', THEME_LANG ),
        'parent_item_colon'  => __( 'Parent Menu Item:', THEME_LANG ),
        'menu_name'     => __( 'Mega Menu', THEME_LANG ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical'        => false,
        'description'         => __('Mega Menus.', THEME_LANG),
        'supports'            => array( 'title', 'editor' ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 40,
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'has_archive'         => false,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => false,
        'capability_type'     => 'page',
        'menu_icon' => 'dashicons-welcome-widgets-menus',
    );

    register_post_type( 'megamenu', $args );
    
    /* Testimonials */
    $labels = array(
        'name'               => __( 'Testimonial', THEME_LANG ),
        'singular_name'      => __( 'Testimonial', THEME_LANG),
        'add_new'            => __( 'Add New', THEME_LANG ),
        'all_items'          => __( 'Testimonials', THEME_LANG ),
        'add_new_item'       => __( 'Add New Testimonial', THEME_LANG ),
        'edit_item'          => __( 'Edit Testimonial', THEME_LANG ),
        'new_item'           => __( 'New Testimonial', THEME_LANG ),
        'view_item'          => __( 'View Testimonial', THEME_LANG ),
        'search_items'       => __( 'Search Testimonial', THEME_LANG ),
        'not_found'          => __( 'No Testimonial found', THEME_LANG ),
        'not_found_in_trash' => __( 'No Testimonial found in Trash', THEME_LANG ),
        'parent_item_colon'  => __( 'Parent Testimonial', THEME_LANG ),
        'menu_name'          => __( 'Testimonials', THEME_LANG )
    );
    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'supports'           => array( 'title', 'thumbnail', 'editor' ),
        'rewrite'            => false,
        'query_var'          => false,
        'publicly_queryable' => false,
        'public'             => true,
        'menu_icon' => 'dashicons-editor-quote',
        

    );
    register_post_type( 'testimonial', $args );

    /* Services */
    $labels = array(
        'name'               => __( 'Services', THEME_LANG ),
        'singular_name'      => __( 'Services', THEME_LANG),
        'add_new'            => __( 'Add New', THEME_LANG ),
        'all_items'          => __( 'Services', THEME_LANG ),
        'add_new_item'       => __( 'Add New Service', THEME_LANG ),
        'edit_item'          => __( 'Edit Service', THEME_LANG ),
        'new_item'           => __( 'New Service', THEME_LANG ),
        'view_item'          => __( 'View Service', THEME_LANG ),
        'search_items'       => __( 'Search Service', THEME_LANG ),
        'not_found'          => __( 'No Service found', THEME_LANG ),
        'not_found_in_trash' => __( 'No Service found in Trash', THEME_LANG ),
        'parent_item_colon'  => __( 'Parent Service', THEME_LANG ),
        'menu_name'          => __( 'Services', THEME_LANG )
    );
    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'supports'           => array( 'title', 'thumbnail', 'editor' ),
        'rewrite'            => true,
        'query_var'          => true,
        'publicly_queryable' => true,
        'public'             => true,
        'menu_icon' => 'dashicons-update'
    );
    register_post_type( 'service', $args );
    flush_rewrite_rules();
}
add_action( 'init', 'register_post_type_init' );