<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package KuteTheme
 * @subpackage KuteTheme
 * @since Kute Shop  1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
		    jQuery('.cart-block').scrollbar();
		});
	</script>
</head>

<body <?php body_class(); ?>>
<div class="site">
    <div class="site-content">
        <?php kt_get_header(); ?>
        <div class="content container">
