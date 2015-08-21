<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		KuteTheme
 * @package 	THEME/WooCommerce
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<?php  
    $cart_count =  WC()->cart->cart_contents_count ;
    $check_out_url = WC()->cart->get_cart_url();
    //global $kt_used_header;
?>
<div id="cart-block" class="shopping-cart-box col-xs-5 col-sm-2">
    <a class="cart-link" href="<?php echo esc_url( $check_out_url ); ?>" target="_blank">
        <span class="title"><?php _e( 'Shopping cart', THEME_LANG ); ?></span>
        <span class="total"><?php echo sprintf ( _n( '%d item', '%d items', esc_attr( $cart_count ) ), esc_attr( $cart_count ) ) ?></span>
        <span><?php _e( '-', THEME_LANG ); ?></span> 
        <?php echo WC()->cart->get_cart_total() ?>
        <span class="notify notify-left"><?php echo esc_attr( $cart_count ); ?></span>
    </a>
    <?php do_action('kt_mini_cart_content', $check_out_url ); ?>
</div>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>
