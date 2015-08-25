<?php
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Pages widget class
 *
 * @since 1.0
 */
class Widget_KT_On_Sale extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
                        'classname' => 'widget_kt_on_sale', 
                        'description' => __( 'Box On Sale.', 'kutetheme' ) );
		parent::__construct( 'widget_kt_on_sale', __('KT On Sale', 'kutetheme' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        $title   = isset( $instance[ 'title' ] )   ? esc_attr($instance[ 'title' ])   : '';
        $number = ( isset( $instance[ 'number' ] ) && intval( $instance[ 'number' ] ) ) ? $instance[ 'number' ] : 6;
        $orderby = isset( $instance[ 'orderby' ] ) ? $instance[ 'orderby' ] : 'date';
        $order   = isset( $instance[ 'order' ] )   ? $instance[ 'order' ]   : 'desc';
        
        $meta_query = WC()->query->get_meta_query();
        $product_ids_on_sale = wc_get_product_ids_on_sale();
        $params = array(
			'post_type'				=> 'product',
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $number,
			'meta_query' 			=> $meta_query,
            'suppress_filter'       => true,
            'orderby'               => $orderby,
            'order'	                => $order,
            'post__in'              => array_merge( array( 0 ), $product_ids_on_sale )
		);
        $product = new WP_Query( $params );
        if( $product->have_posts() ):
        ?>
        <!-- block best sellers -->
        <div class="block left-module">
            <?php 
                if( $title ){
                    echo $args['before_title'];
                    echo $title;
                    echo $args['after_title'];
                }
            ?>
            <div class="block_content product-onsale">
                <ul class="product-list owl-carousel" data-loop="true" data-nav = "false" data-margin = "0" data-autoplayTimeout="1000" data-autoplayHoverPause = "true" data-items="1" data-autoplay="true">
                    <?php while($product->have_posts()): $product->the_post(); ?>
                        <li>
                            <?php wc_get_template_part( 'content', 'on-sale-sidebar' ); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        <!-- ./block best sellers  -->
        <?php
        endif;
        echo $args[ 'after_widget' ];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $new_instance;
        $instance[ 'title' ] = isset( $new_instance[ 'title' ] ) ? $new_instance[ 'title' ] : '';
        $instance[ 'number' ] = ( isset( $new_instance[ 'number' ] ) && intval( $new_instance[ 'perpage' ] ) ) ? $new_instance[ 'number' ] :6;
        $instance[ 'orderby' ]  = $new_instance[ 'orderby' ] ? $new_instance[ 'orderby' ] : 'date';
        $instance[ 'order' ]    = $new_instance[ 'order' ]   ? $new_instance[ 'order' ] : 'desc';
        
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
        $title      = isset( $instance[ 'title' ] )      ? $instance[ 'title' ] : '';
        $number = ( isset( $instance[ 'number' ] ) && intval( $instance[ 'number' ] ) ) ? $instance[ 'number' ] : 6;
        $orderby    = isset( $instance[ 'orderby' ] )    ? $instance[ 'orderby' ] : 'date';
        $order      = isset( $instance[ 'order' ] )      ? $instance[ 'order' ] : 'desc';
	?>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'kutetheme'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number:', 'kutetheme'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', 'kutetheme'); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option value="id" <?php selected( 'id', $orderby ) ?>><?php _e( 'ID', 'kutetheme' ) ?></option>
            	<option class="author" value="author" <?php selected( 'author', $orderby ) ?>><?php _e( 'Author', 'kutetheme' ) ?></option>
            	<option class="name" value="name" <?php selected( 'name', $orderby ) ?>><?php _e( 'Name', 'kutetheme' ) ?></option>
            	<option class="date" value="date" <?php selected( 'date', $orderby ) ?>><?php _e( 'Date', 'kutetheme' ) ?></option>
            	<option class="modified" value="modified" <?php selected( 'modified', $orderby ) ?>><?php _e( 'Modified', 'kutetheme' ) ?></option>
            	<option class="rand" value="rand" <?php selected( 'rand', $orderby ) ?>><?php _e( 'Rand', 'kutetheme' ) ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order Way:', 'kutetheme'); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                <option value="desc" <?php selected( 'desc', $order ) ?>><?php _e( 'DESC', 'kutetheme' ) ?></option>
            	<option value="asc" <?php selected( 'asc', $order ) ?>><?php _e( 'ASC', 'kutetheme' ) ?></option>
            </select>
        </p>
        
    <?php
	}

}
add_action( 'widgets_init', function(){
    register_widget( 'Widget_KT_On_Sale' );
} );