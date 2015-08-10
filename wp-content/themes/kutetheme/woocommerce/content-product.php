<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}


// Bootstrap Column
$bootstrapColumn = round( 12 / $woocommerce_loop['columns'] );
$classes[] = 'col-xs-'.$bootstrapColumn.' col-sm-'. $bootstrapColumn .' col-md-' . $bootstrapColumn;


?>
<li <?php post_class( $classes ); ?>>
    <div class="product-container">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
    	<div class="left-block">
            <a href="<?php echo get_permalink(); ?>">
                <?php
        			/**
        			 * kt_loop_product_thumbnail hook
        			 *
        			 * @hooked woocommerce_template_loop_product_thumbnail - 10
        			 */
        			echo woocommerce_get_product_thumbnail('shop_catalog_image_size');
        		?>
            </a>
            <div class="quick-view">
                <?php
        			/**
        			 * kt_loop_product_function hook
        			 *
        			 * @hooked kt_get_tool_wishlish - 1
                     * @hooked kt_get_tool_compare - 5
                     * @hooked kt_get_tool_quickview - 10
        			 */
        			do_action( 'kt_loop_product_function' );
        		?>
            </div>
            <?php
                /**
                 * woocommerce_after_shop_loop_item hook
                 *
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item' );
            ?>
        </div>
        <div class="right-block">
            <h5 class="product-name"><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
            <div class="content_price">
                <?php
        			/**
        			 * woocommerce_after_shop_loop_item_title hook
    			     *
        			 * @hooked woocommerce_template_loop_price - 10
        			 */
        			do_action( 'kt_after_shop_loop_item_title' );
        		?>
            </div>
        </div>
    </div>
</li>
