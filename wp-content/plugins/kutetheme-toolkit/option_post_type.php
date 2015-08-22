<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'kt_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category KuteTheme
 * @package  ThemeOption
 */


add_action( 'cmb2_init', 'kt_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function kt_register_demo_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kt_page_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$page_option = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Page Option', THEME_LANG ),
		'object_types'  => array( 'page', )
	) );

    $page_option->add_field( array(
		'name' => __( 'Page Title', THEME_LANG ),
		'desc' => __( 'Show page title', THEME_LANG ),
		'id'   => $prefix . 'page_title',
		'type' => 'checkbox',
	) );
    
    $page_option->add_field( array(
		'name' => __( 'Page breadcrumb', THEME_LANG ),
		'desc' => __( 'Show page breadcrumb.', THEME_LANG ),
		'id'   => $prefix . 'page_breadcrumb',
		'type' => 'checkbox',
	) );
	/**
	 * Service option
	 */
	$service_option = new_cmb2_box( array(
		'id'            => $prefix . 'service_metabox',
		'title'         => __( 'Service Option', THEME_LANG ),
		'object_types'  => array( 'service' )
	) );

	$service_option->add_field( array(
		'name' => __( 'Sub Title', THEME_LANG ),
		'desc' => __( 'Sub title', THEME_LANG ),
		'id'   => $prefix . 'service_sub_title',
		'type' => 'text',
	) );
    
}

add_action( 'cmb2_init', 'kt_register_about_page_metabox' );
/**
 * Hook in and add a metabox that only appears on the 'About' page
 */
function kt_register_about_page_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kt_about_';

	/**
	 * Metabox to be displayed on a single page ID
	 */
	$cmb_about_page = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'About Page Metabox', THEME_LANG ),
		'object_types' => array( 'page', ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
		'show_on'      => array( 'id' => array( 2, ) ), // Specific post IDs to display this metabox
	) );

	$cmb_about_page->add_field( array(
		'name' => __( 'Test Text', THEME_LANG ),
		'desc' => __( 'field description (optional)', THEME_LANG ),
		'id'   => $prefix . 'text',
		'type' => 'text',
	) );


}

add_action( 'cmb2_init', 'kt_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function kt_register_repeatable_group_field_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kt_group_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Repeating Field Group', THEME_LANG ),
		'object_types' => array( 'page', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'demo',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', THEME_LANG ),
		'options'     => array(
			'group_title'   => __( 'Entry {#}', THEME_LANG ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Entry', THEME_LANG ),
			'remove_button' => __( 'Remove Entry', THEME_LANG ),
			'sortable'      => true, // beta
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => __( 'Entry Title', THEME_LANG ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => __( 'Description', THEME_LANG ),
		'description' => __( 'Write a short description for this entry', THEME_LANG ),
		'id'          => 'description',
		'type'        => 'textarea_small',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Entry Image', THEME_LANG ),
		'id'   => 'image',
		'type' => 'file',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Image Caption', THEME_LANG ),
		'id'   => 'image_caption',
		'type' => 'text',
	) );

}

add_action( 'cmb2_init', 'kt_register_user_profile_metabox' );
/**
 * Hook in and add a metabox to add fields to the user profile pages
 */
function kt_register_user_profile_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kt_user_';

	/**
	 * Metabox for the user profile screen
	 */
	$cmb_user = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => __( 'User Profile Metabox', THEME_LANG ),
		'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
		'show_names'       => true,
		'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
	) );

	$cmb_user->add_field( array(
		'name'     => __( 'Extra Info', THEME_LANG ),
		'desc'     => __( 'field description (optional)', THEME_LANG ),
		'id'       => $prefix . 'extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );

	$cmb_user->add_field( array(
		'name'    => __( 'Avatar', THEME_LANG ),
		'desc'    => __( 'field description (optional)', THEME_LANG ),
		'id'      => $prefix . 'avatar',
		'type'    => 'file',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Facebook URL', THEME_LANG ),
		'desc' => __( 'field description (optional)', THEME_LANG ),
		'id'   => $prefix . 'facebookurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Twitter URL', THEME_LANG ),
		'desc' => __( 'field description (optional)', THEME_LANG ),
		'id'   => $prefix . 'twitterurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Google+ URL', THEME_LANG ),
		'desc' => __( 'field description (optional)', THEME_LANG ),
		'id'   => $prefix . 'googleplusurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'Linkedin URL', THEME_LANG ),
		'desc' => __( 'field description (optional)', THEME_LANG ),
		'id'   => $prefix . 'linkedinurl',
		'type' => 'text_url',
	) );

	$cmb_user->add_field( array(
		'name' => __( 'User Field', THEME_LANG ),
		'desc' => __( 'field description (optional)', THEME_LANG ),
		'id'   => $prefix . 'user_text_field',
		'type' => 'text',
	) );

}

add_action( 'cmb2_init', 'kt_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page
 */
function kt_register_theme_options_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$option_key = '_kt_theme_options';

	/**
	 * Metabox for an options page. Will not be added automatically, but needs to be called with
	 * the `cmb2_metabox_form` helper function. See wiki for more info.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'      => $option_key . 'page',
		'title'   => __( 'Theme Options Metabox', THEME_LANG ),
		'hookup'  => false, // Do not need the normal user/post hookup
		'show_on' => array(
			// These are important, don't remove
			'key'   => 'options-page',
			'value' => array( $option_key )
		),
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this option group.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'    => __( 'Site Background Color', THEME_LANG ),
		'desc'    => __( 'field description (optional)', THEME_LANG ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}
