<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		KuteTheme
 * @package 	THEME/WooCommerce
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop,$post;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
    
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns_tablet'] ) )
	$woocommerce_loop['columns_tablet'] = apply_filters( 'loop_shop_columns_tablet', 2 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array('product');
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';


if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns_tablet'] || 1 == $woocommerce_loop['columns_tablet'] )
	$classes[] = 'first-tablet';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns_tablet'] )
	$classes[] = 'last-tablet';

// Bootstrap Column
$bootstrapColumn = round( 12 / $woocommerce_loop['columns'] );
//$bootstrapTabletColumn = round( 12 / $woocommerce_loop['columns_tablet'] );
$classes[] = ' col-md-' . $bootstrapColumn;

?>
<div class="mega-product <?php echo implode( ' ', $classes ) ?>">
    <div class="product-avatar">
        <a href="<?php echo get_permalink(); ?>">
            <?php
    			/**
    			 * kt_loop_product_thumbnail hook
    			 *
    			 * @hooked woocommerce_template_loop_product_thumbnail - 10
    			 */
    			do_action( 'kt_loop_product_thumbnail' );
    		?>
        </a>
    </div>
    <div class="product-name">
        <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
    </div>
    <?php
		/**
		 * woocommerce_after_shop_loop_item_title hook
		 * @hooked woocommerce_template_loop_price - 5
		 * @hooked woocommerce_template_loop_rating - 10
		 */
		do_action( 'kt_after_shop_loop_item_title' );
	?>
</div>