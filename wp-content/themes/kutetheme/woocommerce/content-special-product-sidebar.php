
<div class="block_content">
    <ul class="products-block">
        <li>
            <div class="products-block-left">
                <a href="<?php echo the_permalink(); ?>">
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
            <div class="products-block-right">
                <p class="product-name">
                    <a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a>
                </p>
                <div class="content_price">
                <?php
        			/**
        			 * woocommerce_after_shop_loop_item_title hook
        			 * @hooked woocommerce_template_loop_price - 5
        			 * @hooked woocommerce_template_loop_rating - 10
        			 */
        			do_action( 'kt_after_shop_loop_item_title' );
        		?>
                </div>
            </div>
        </li>
    </ul>
    <div class="products-block">
        <div class="products-block-bottom">
            <a class="link-all" href="<?php echo the_permalink(); ?>"><?php _e( 'All Products', 'kutetheme' ) ?></a>
        </div>
    </div>
</div>