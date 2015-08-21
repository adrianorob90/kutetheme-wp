<?php 
global $product, $post;
?>
<li class="deal-product-content">
    <div class="col-sm-5 deal-product-image">
        <a href="<?php the_permalink(); ?>">
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
    <div class="col-sm-7 deal-product-info">
        <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
        
        <div class="content_price">
            <?php
    			/**
    			 * woocommerce_after_shop_loop_item_title hook
			     *
    			 * @hooked woocommerce_template_loop_price - 10
    			 */
    			do_action( 'kt_after_loop_item_title' );
    		?>
        </div>
        <div class="show-count-down">
            <span class="countdown-lastest count-down-time" <?php do_action('woocommerce_datatime_sale_product', $product, $post) ?>></span>
        </div>
        <?php 
            /**
			 * kt_loop_product_after_countdown hook
		     *
			 * @hooked woocommerce_template_loop_rating - 10
			 */
            do_action( 'kt_loop_product_after_countdown' ); 
        
        ?>
    </div>
</li>