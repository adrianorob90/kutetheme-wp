<?php
/**
 * Product loop sale flash
 *
 * @author 		AngelsIT
 * @package 	Kute Theme
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="product-sale">' . __( 'Sale', 'woocommerce' ) . '</span>', $post, $product ); ?>

<?php endif; ?>
