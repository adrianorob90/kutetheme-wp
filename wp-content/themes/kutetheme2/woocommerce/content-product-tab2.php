<div class="right-block">
    <h5 class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
    <div class="content_price">
        <span class="price product-price">
            <?php woocommerce_template_loop_price(); ?>
        </span>
    </div>
</div>
<div class="left-block">
    <a href="<?php the_permalink() ?>">
        <?php
			/**
			 * kt_loop_product_thumbnail hook
			 *
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'kt_loop_product_thumbnail' );
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