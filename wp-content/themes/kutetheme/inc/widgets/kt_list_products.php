<?php
if ( ! defined( 'ABSPATH' ) ) {
    die;
}
if( ! kt_is_wc() ) return;
/**
 * Pages widget class
 *
 * @since 1.0
 */
class Widget_KT_ListProduct extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
                        'classname' => 'widget_kt_list_products', 
                        'description' => __( 'Showing list product.', 'kutetheme' ) );
		parent::__construct('widget_kt_list_products', __('KT List Product', 'kutetheme' ), $widget_ops);
	}

	public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        $title = ( isset($instance['title']) && $instance['title'] ) ? $instance['title'] : 'Best Seller';
        $cat = ( isset($instance['cate']) && intval($instance['cate']) > 0 ) ? intval($instance['cate']) : 0;
        $number = ( isset($instance['number']) && intval($instance['number']) > 1 && intval($instance['number']) < 21) ? intval($instance['number']) : 2;
        $types = ( isset($instance['types']) && $instance['types'] && in_array($instance['types'], array('sale', 'arrival', 'review'))) ? $instance['types'] : 'sale';
        $meta_query = WC()->query->get_meta_query();
        $query = array(
			'post_type'				=> 'product',
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $number,
			'meta_query' 			=> $meta_query,
		);
        global $woocommerce_loop;
        $woocommerce_loop['columns'] = $number;
        
        if($cat > 0){
            $query['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'id',
                    'terms'    => $cat,
                ),
            );
        }
        
        if( $types == 'arrival' ){
            $query['orderby'] = 'date';
            $query['order']   = 'DESC';
        }
        
        if( $types == 'sale' ){
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $query['meta_key'] = 'total_sales';
            $query['orderby']  = 'meta_value_num';
            $query['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
        }
        
        if( $types  == 'review' ) {
            add_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
        }
        
        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query, $instance ));
        
        if($types == 'review'){
            remove_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
        }
        
        if ( $products->have_posts() ) :
            echo '<div class="widget-list-products">';
            echo '<ul class="clearfix widget-list-products products row">';
            
                    while ( $products->have_posts() ) : $products->the_post();
                        wc_get_template_part( 'content', 'product-widget' );
                    endwhile; // end of the loop.
            
            echo '</ul>';
        echo '</div>';
        endif;
        wp_reset_postdata();
        echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        
        $title = ( isset($new_instance['title']) && $new_instance['title'] ) ? esc_html($new_instance['title']) : 'Best Seller';
        $cat = ( isset($new_instance['cate']) && intval($new_instance['cate']) > 0 ) ? intval($new_instance['cate']) : 0;
        $number = ( isset($new_instance['number']) && intval($new_instance['number']) > 1 && intval($new_instance['number']) < 21) ? intval($new_instance['number']) : 2;
        
        if( isset($new_instance['types']) && $new_instance['types'] && in_array($new_instance['types'], array('sale', 'arrival', 'review')) ){
            $instance['types'] = $new_instance['types'];
        }else{
            $instance['types'] = 'sale';
        }
        
        $instance['title'] = $title;
        $instance['cate'] = $cat;
        $instance['number'] = $number;
        
        return $instance;
	}

	public function form( $instance ) {
	   $terms = get_terms( 'product_cat' , array('hide_empty' => false)); 
       $title = ( isset($instance['title']) && $instance['title'] ) ? $instance['title'] : __('New Products', 'kutetheme');
       $cat = ( isset($instance['cate']) && intval($instance['cate']) > 0 ) ? intval($instance['cate']) : 0;
       $number = ( isset($instance['number']) && intval($instance['number']) > 1 && intval($instance['number']) < 21) ? intval($instance['number']) : 2;
	   $types = ( isset($instance['types']) && $instance['types'] && in_array($instance['types'], array('sale', 'arrival', 'review'))) ? $instance['types'] : 'sale';
       $args = array(
              'show_option_none' => __( 'All Categries', 'kutetheme' ),
              'taxonomy'    => 'product_cat',
              'id'          => $this->get_field_id('cat'),
              'class'      => 'widefat',
              'name'        => $this->get_field_name('cat'),
              'hide_empty'  => 0,
              'orderby'     => 'name',
              'order'       => "desc",
              'tab_index'   => true,
              'hierarchical' => true
        );
		?>
        <p>
            <label><?php _e('Title:', 'kutetheme'); ?></label> 
            <input value="<?php echo $title ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" />
        </p>
        <p>
			<label><?php _e( 'Type:', 'kutetheme'); ?></label>
			<select name="<?php echo $this->get_field_name('types'); ?>" id="<?php echo $this->get_field_id('types'); ?>" class="widefat">
                <option <?php selected('sale', $types) ?> value='sale'>Best saler</option>
                <option <?php selected('arrival', $types) ?> value='arrival'>New arrivals</option>
                <option <?php selected('review', $types) ?> value='review'>Most Reviews</option>
			</select>
		</p>
        <p>
			<label><?php _e( 'Category:', 'kutetheme'); ?></label>
			<?php wp_dropdown_categories( $args ); ?>
		</p>
        <p>
            <label><?php _e( 'Number:', 'kutetheme'); ?></label>
            
            <select name="<?php echo $this->get_field_name('number'); ?>" id="<?php echo $this->get_field_id('number'); ?>" class="widefat">
                <option <?php selected(2, $number) ?> value='2'>2</option>
                <option <?php selected(3, $number) ?> value='3'>3</option>
                <option <?php selected(4, $number) ?> value='4'>4</option>
                <option <?php selected(6, $number) ?> value='6'>6</option>
			</select>
        </p>
        <?php
	}
    /**
     * woocommerce_order_by_rating_post_clauses function.
     *
     * @param array $args
     * @return array
     */
    public static function order_by_rating_post_clauses( $args ) {
        global $wpdb;

        $args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

        $args['join'] .= "
			LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

        $args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

        $args['groupby'] = "$wpdb->posts.ID";

        return $args;
    }

}
add_action( 'widgets_init', function(){
    register_widget( 'Widget_KT_ListProduct' );
} );