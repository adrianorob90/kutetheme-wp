<?php


if ( ! defined( 'ABSPATH' ) ) {

}

/**
 * Pages widget class
 *
 * @since 2.8.0
 */
class WP_Widget_KT_Image extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_kt_image', 'description' => __( 'Image for widget.', THEME_LANG ) );
		parent::__construct( 'kt_image', __('KT image', THEME_LANG ), $widget_ops);
	}

	public function widget( $args, $instance ) {
        $attachment = wp_get_attachment_image_src( $instance[ 'attachment' ], 'full' );
        if($attachment && isset( $attachment[ 0 ] ) && $attachment[ 0 ] ){
    		echo $args[ 'before_widget' ];
            $capture = ( isset( $instance[ 'capture' ] ) ) ? esc_attr( $instance[ 'capture' ] ) : '';
            $link = ( isset( $instance [ 'link' ] ) ) ? esc_attr( $instance[ 'link' ] ) : '#';
            $target = ( isset( $instance[ 'target' ] ) ) ? esc_attr( $instance[ 'target' ] ) : '_blank';
            ?>
            <div class="block left-module">
                <div class="banner-opacity">
                    <a href="<?php echo $link ?>" target="<?php echo $target ?>"><img src="<?php echo esc_attr($attachment[ 0 ]) ?>" alt="<?php echo $capture; ?>" /></a>
                </div>
            </div>
            <?php
            
    		echo $args[ 'after_widget' ];
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'link' ] = strip_tags($new_instance[ 'link' ]);
        $instance[ 'target' ] = $new_instance[ 'target' ];
        $instance[ 'size' ] = $new_instance[ 'size' ];
        $instance[ 'attachment' ] = intval($new_instance[ 'attachment' ]);
        
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'target' => '_self') );
        
        if( isset( $instance[ 'link' ] ) ) $link = esc_attr( $instance[ 'link' ] ); else $link="";
        
        if( isset( $instance[ 'attachment' ] ) ) $attachment = esc_attr( $instance[ 'attachment' ] ); else $attachment="";
        $preview = false;
        $img_preview = "";
        if( isset( $instance[ 'attachment' ] ) ){
            $file = wp_get_attachment_image_src( $instance[ 'attachment' ], 'full' );
            $preview = true;
            $img_preview = $file[ 0 ];
        }
		$capture = ( isset( $instance[ 'capture' ] ) ) ? esc_attr( $instance[ 'capture' ] ) : '';
	?>
        
        <p style="text-align: center;">
            <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e( 'Select your image', THEME_LANG) ?>" />
            <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id( 'attachment' ); ?>" name="<?php echo $this->get_field_name( 'attachment' ); ?>" type="hidden" value="<?php echo esc_attr( $attachment ); ?>" />
        </p>
        <p class="kt_image_preview" style="<?php if( $preview ){ echo "display: block;";} ?>">
            <img src="<?php echo esc_url( $img_preview ); ?>" alt="" class="kt_image_preview_img" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'capture' ); ?>"><?php _e( 'Capture:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'capture' ); ?>" name="<?php echo $this->get_field_name( 'capture' ); ?>" type="text" value="<?php echo esc_attr( $capture ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'target' ); ?>"><?php _e( 'Target:', THEME_LANG); ?></label>
			<select name="<?php echo $this->get_field_name( 'target' ); ?>" id="<?php echo $this->get_field_id('target'); ?>" class="widefat">
				<option value="_self"<?php selected( $instance[ 'target' ], '_self' ); ?>><?php _e( 'Stay in Window', THEME_LANG ); ?></option>
				<option value="_blank"<?php selected( $instance[ 'target' ], '_blank' ); ?>><?php _e( 'Open New Window', THEME_LANG ); ?></option>
			</select>
		</p>
    <?php
	}

}

function kt_image_register_widgets() {
	register_widget( 'WP_Widget_KT_Image' );
}

add_action( 'widgets_init', 'kt_image_register_widgets' );