<?php
/**
 * The template for displaying product content inside our popup
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

global $post, $product, $woocommerce;

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product-detail-wrapper'); ?>>
    
    <div class="product-quick-view product-detail-content">
        <?php woocommerce_template_single_title();?>
        <div class="row product-detail-inner">
            <div class="<?php echo apply_filters('woocommerce_single_product_thumb_area', 'col-xs-12 col-sm-6 col-md-6'); ?>">
                <div class="product-detail-thumbarea">
                	<?php
                		/**
                		 * woocommerce_before_single_product_summary hook
                		 *
                		 * @hooked woocommerce_show_product_sale_flash - 10
                		 * @hooked woocommerce_show_product_images - 20
                		 */
                		do_action( 'woocommerce_before_single_product_summary' );
                	?>
                </div>
            </div>
            <div class="<?php echo apply_filters('woocommerce_single_product_summary_area', 'col-xs-12 col-sm-6 col-md-6'); ?>">
            	<div class="summary entry-summary">
            		<?php
            			/**
            			 * kt_woocommerce_single_product hook
            			 *
            			 * @hooked woocommerce_template_single_rating - 10
                         * @hooked woocommerce_template_single_excerpt - 20
            			 * @hooked woocommerce_template_single_price - 10
            			 * @hooked woocommerce_template_single_add_to_cart - 30
            			 * @hooked woocommerce_template_single_meta - 40
            			 * @hooked woocommerce_template_single_sharing - 50
            			 */
            			//do_action( 'woocommerce_single_product_summary' );
                        do_action('kt_woocommerce_single_product');
            		?>
            
            	</div><!-- .summary -->
             </div>
        </div><!--.row-->
        
        
        
    </div><!-- .product-detail-content -->
	

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->