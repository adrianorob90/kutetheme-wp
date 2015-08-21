<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Kutetheme
 * @since kuteshop 1.0
 */
?>
<?php
$kt_used_sidebar = kt_option('kt_used_sidebar','sidebar-shop')
?>
<div id="secondary" class="secondary">
	<?php if ( is_active_sidebar( $kt_used_sidebar ) ) : ?>
		<div id="widget-area" class="widget-area" role="complementary">
			<?php dynamic_sidebar( $kt_used_sidebar ); ?>
		</div><!-- .widget-area -->
	<?php endif; ?>

</div><!-- .secondary -->
