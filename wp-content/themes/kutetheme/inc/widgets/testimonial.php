<?php
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Pages widget class
 *
 * @since 1.0
 */
class Widget_KT_Testimonial extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
                        'classname' => 'widget_kt_testimonial', 
                        'description' => __( 'Testimonial Carousel on sidebar.', THEME_LANG ) );
		parent::__construct( 'widget_kt_testimonial', __('KT Testimonial', THEME_LANG ), $widget_ops );
	}

	public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        $title   = isset( $instance[ 'title' ] )   ? $instance[ 'title' ]   : '';
        $number  = isset( $instance[ 'number' ] )  ? $instance[ 'number' ]  : 3;
        $orderby = isset( $instance[ 'orderby' ] ) ? $instance[ 'orderby' ] : 'date';
        $order   = isset( $instance[ 'order' ] )   ? $instance[ 'order' ]   : 'desc';
        
        $data_carousel    = array(
            "autoplay"   => $instance[ 'autoplay' ],
            "slidespeed" => $instance[ 'slidespeed' ],
            "theme"      => 'style-navigation-bottom',
            'nav'        => false,
            'loop'       => $instance[ 'loop' ],
            'items'      => 1
        );
        if($title!=""){
            echo $args['before_title'];
            echo $title;
            echo $args['after_title'];
        }
        $pages = new WP_Query( array( 'post_type' => 'testimonial', 'numbe' => $number ));
        if($pages->have_posts()):
           ?>
           <!-- Testimonials -->
            <div class="block left-module container-testimonials">
                <div class="block_content">
                    <ul class="testimonials owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                        <?php while($pages->have_posts()): $pages->the_post(); ?>
                        <li>
                            <div class="client-mane"><?php the_title(); ?></div>
                            <div class="client-avarta">
                                <?php the_post_thumbnail('110x110'); ?>
                            </div>
                            <div class="testimonial">
                                <?php the_content();  ?>
                            </div>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
            <!-- ./Testimonials -->
       <?php
       endif;
       wp_reset_query();
       wp_reset_postdata();
       echo $args[ 'after_widget' ];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $new_instance;
        $instance[ 'title' ] = isset( $new_instance[ 'title' ] ) ? $new_instance[ 'title' ] : '';
        
		$instance[ 'autoplay' ]   = $new_instance[ 'autoplay' ]   ? true : false;
        $instance[ 'loop' ]       = $new_instance[ 'loop' ]       ? true : false;
        $instance[ 'slidespeed' ] = $new_instance[ 'slidespeed' ] ? $new_instance[ 'slidespeed' ] : 200;
        
        $instance[ 'number' ]   = $new_instance[ 'number' ]  ? $new_instance[ 'number' ] : 3;
        $instance[ 'orderby' ]  = $new_instance[ 'orderby' ] ? $new_instance[ 'orderby' ] : 'date';
        $instance[ 'order' ]    = $new_instance[ 'order' ]   ? $new_instance[ 'order' ] : 'desc';
        
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
        $title      = isset( $instance[ 'title' ] )      ? $instance[ 'title' ] : '';
        $autoplay   = isset( $instance[ 'autoplay' ] )   ? true : false;
        $loop       = isset( $instance[ 'loop' ] )       ? true : false;
		$slidespeed = isset( $instance[ 'slidespeed' ] ) ? $instance[ 'slidespeed' ] : '200';
        
        $number     = isset( $instance[ 'number' ] )     ? $instance[ 'number' ] : 3;
        $orderby    = isset( $instance[ 'orderby' ] )    ? $instance[ 'orderby' ] : 'date';
        $order      = isset( $instance[ 'order' ] )      ? $instance[ 'order' ] : 'desc';
	?>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
			<input class="checkbox" <?php checked( $autoplay, true ); ?> type="checkbox" id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" /> 
            <label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e('Auto next slide', THEME_LANG) ?></label>
		</p>
        <p>
			<input class="checkbox" <?php checked( $loop, true ); ?> type="checkbox" id="<?php echo $this->get_field_id('loop'); ?>" name="<?php echo $this->get_field_name('loop'); ?>" /> 
            <label for="<?php echo $this->get_field_id( 'loop' ); ?>"><?php _e('Inifnity loop. Duplicate last and first items to get loop illusion.', THEME_LANG) ?></label>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'slidespeed' ); ?>"><?php _e( 'Slide Speed:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'slidespeed' ); ?>" name="<?php echo $this->get_field_name('slidespeed'); ?>" type="text" value="<?php echo esc_attr($slidespeed); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', THEME_LANG); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option value="id" <?php selected( 'id', $orderby ) ?>><?php _e( 'ID', THEME_LANG ) ?></option>
            	<option class="author" value="author" <?php selected( 'author', $orderby ) ?>><?php _e( 'Author', THEME_LANG ) ?></option>
            	<option class="name" value="name" <?php selected( 'name', $orderby ) ?>><?php _e( 'Name', THEME_LANG ) ?></option>
            	<option class="date" value="date" <?php selected( 'date', $orderby ) ?>><?php _e( 'Date', THEME_LANG ) ?></option>
            	<option class="modified" value="modified" <?php selected( 'modified', $orderby ) ?>><?php _e( 'Modified', THEME_LANG ) ?></option>
            	<option class="rand" value="rand" <?php selected( 'rand', $orderby ) ?>><?php _e( 'Rand', THEME_LANG ) ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order Way:', THEME_LANG); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                <option value="desc" <?php selected( 'desc', $order ) ?>><?php _e( 'DESC', THEME_LANG ) ?></option>
            	<option value="asc" <?php selected( 'asc', $order ) ?>><?php _e( 'ASC', THEME_LANG ) ?></option>
            </select>
        </p>
        
    <?php
	}

}
add_action( 'widgets_init', function(){
    register_widget( 'Widget_KT_Testimonial' );
} );