<?php
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Pages widget class
 *
 * @since 1.0
 */
class Widget_KT_Trademark_Payment extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
                        'classname' => 'widget_kt_trademark_payment', 
                        'description' => __( 'Accepted trademark payment.', 'kutetheme' ) );
		parent::__construct( 'widget_kt_trademark_payment', __('KT Trademark Payment', 'kutetheme' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
	   echo $args['before_widget'];
       //Defaults
        $wtitle = (isset( $instance[ 'wtitle' ] ) && $instance[ 'wtitle' ] ) ? $instance[ 'wtitle' ] : '';
       ?>
       <ul id="trademark-list">
            <li id="payment-methods"><?php echo $wtitle; ?><?php echo ":"; ?></li>
            <?php 
             if(isset($instance[ 'title' ]) && $instance[ 'title' ] && count($instance[ 'title' ]) > 0 ):
                for( $i = 0; $i < count($instance['title']); $i++ ):
                    $title = isset($instance[ 'title' ][$i])   && $instance[ 'title' ][$i]   ? $instance[ 'title' ][$i] : '';
                    $image = isset($instance[ 'image' ][$i])   && $instance[ 'image' ][$i]   ? $instance[ 'image' ][$i] : '';
                    $link  = isset($instance[ 'link' ][$i])    && $instance[ 'link' ][$i]    ? $instance[ 'link' ][$i] : '#';
                    $target = isset($instance[ 'target' ][$i]) && $instance[ 'target' ][$i]  ? $instance[ 'target' ][$i] : '_blank';
                    
                    $img_preview = "";
                    if($image){
                        $img_preview = wp_get_attachment_url($image);
                        $preview = true;
                    }
                    if($title):
                        ?>
                        <li>
                            <a target="<?php echo esc_attr( $target ) ?>" href="<?php echo esc_attr($link) ?>">
                                <img src="<?php echo $img_preview; ?>" alt="<?php echo esc_attr($title) ?>" />
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endif; ?>
        </ul>
       <?php
       echo $args[ 'after_widget' ];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $new_instance;
		$instance[ 'wtitle' ] = $new_instance[ 'wtitle' ] ? $new_instance[ 'wtitle' ] : '';
        
        if( isset( $new_instance[ 'title' ] ) && $new_instance[ 'title' ] && count( $new_instance[ 'title' ] ) > 0 ){
            $tmp = array();
            for( $i = 0; $i < count($new_instance['title']); $i++ ){
                
                $title  = isset($new_instance[ 'title' ][$i]) ? $new_instance[ 'title' ][$i] : '';
                $image  = isset($new_instance[ 'image' ][$i]) ? $new_instance[ 'image' ][$i] : '';
                $link   = isset($new_instance[ 'link' ][$i]) ? $new_instance[ 'link' ][$i] : '#';
                $target = isset($new_instance[ 'target' ][$i]) ? $new_instance[ 'target' ][$i] : '_blank';
                
                if($title){
                    $tmp[ 'title' ][]   = esc_html(trim($title)) ?  esc_html(trim($title)) : '';
                    $tmp[ 'image' ][]   = esc_html(trim($image)) ? esc_html(trim($image)) : '';
                    $tmp[ 'link' ][]    = esc_html(trim($link)) ? esc_html(trim($link)) : '#';
                    $tmp[ 'target '][]  = esc_html(trim($target)) ? esc_html(trim($target)) : '_blank';
                }
            }
            $instance[ 'title' ] = $tmp[ 'title' ];
            $instance[ 'image' ] = $tmp[ 'image' ];
            $instance[ 'link' ] = $tmp[ 'link' ];
            $instance[ 'target' ] = $tmp[ 'target' ];
        }
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
        $wtitle = (isset( $instance[ 'wtitle' ] ) && $instance[ 'wtitle' ] ) ? $instance[ 'wtitle' ] : '';
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'wtitle' ); ?>"><?php _e( 'Title:', 'kutetheme'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'wtitle' ) ) ; ?>" name="<?php echo esc_attr( $this->get_field_name('wtitle') ) ; ?>" type="text" value="<?php echo esc_attr($wtitle); ?>" />
        </p>
        <div class="content multi-item">
            <?php
                if(isset($instance[ 'title' ]) && $instance[ 'title' ] && count($instance[ 'title' ]) > 0 ){
                    for( $i = 0; $i < count($instance['title']); $i++ ){
                        
                        $title = isset($instance[ 'title' ][$i])   && $instance[ 'title' ][$i]   ? $instance[ 'title' ][$i] : '';
                        $image = isset($instance[ 'image' ][$i])   && $instance[ 'image' ][$i]   ? $instance[ 'image' ][$i] : '';
                        $link  = isset($instance[ 'link' ][$i])    && $instance[ 'link' ][$i]    ? $instance[ 'link' ][$i] : '#';
                        $target = isset($instance[ 'target' ][$i]) && $instance[ 'target' ][$i]  ? $instance[ 'target' ][$i] : '_blank';
                        
                        $img_preview = "";
                        if($image){
                            $img_preview = wp_get_attachment_url($image);
                            $preview = true;
                        }
                        if($title){?>
                        <div class="item widget-content">
                            <span class="remove">X</span>
                            <p>
                                <label><?php _e( 'Title:', 'kutetheme'); ?></label> 
                                <input class="widefat" id="<?php echo $this->get_field_id( 'title'); ?>" name="<?php echo $this->get_field_name('title'); ?>[]" type="text" value="<?php echo esc_attr($title); ?>" />
                            </p>
                            <p style="text-align: center;">
                                <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e('Select your image', 'kutetheme') ?>" />
                                <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id( 'image'); ?>" name="<?php echo $this->get_field_name('image'); ?>[]" type="hidden" value="<?php echo esc_attr( $image ); ?>" />
                            </p>
                            <p class="kt_image_preview" style="<?php if( $preview ){ echo "display: block;";} ?>">
                                <img src="<?php echo esc_url( $img_preview ); ?>" alt="" class="kt_image_preview_img" />
                            </p>
                            <p>
                            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', 'kutetheme'); ?></label> 
                                <input class="widefat" id="<?php echo $this->get_field_id( 'link'); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>[]" type="text" value="<?php echo esc_attr( $link ); ?>" />
                            </p>
                            <p>
                    			<label><?php _e( 'Target:', 'kutetheme'); ?></label>
                    			<select name="<?php echo $this->get_field_name('target'); ?>[]" id="<?php echo $this->get_field_id('target'); ?>" class="widefat">
                    				<option value="_blank"<?php selected( $target, '_blank' ); ?>><?php _e('Open New Window', 'kutetheme'); ?></option>
                    				<option value="_self"<?php selected( $target, '_self' ); ?>><?php _e('Stay in Window', 'kutetheme'); ?></option>
                    			</select>
                    		</p>
                        </div>
                    <?php }}
                }else{?>
                    <div class="item widget-content">
                        <span class="remove">X</span>
                        <p>
                            <label><?php _e( 'Title:', 'kutetheme'); ?></label> 
                            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>[]" type="text" />
                        </p>
                        <p style="text-align: center;">
                            <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e( 'Select your image', 'kutetheme' ) ?>" />
                            <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>[]" type="hidden"  />
                        </p>
                        <p class="kt_image_preview">
                            <img src="" alt="" class="kt_image_preview_img" />
                        </p>
                        <p>
                        <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', 'kutetheme'); ?></label> 
                            <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>[]" type="text" />
                        </p>
                        <p>
                			<label><?php _e( 'Target:', 'kutetheme'); ?></label>
                			<select name="<?php echo $this->get_field_name( 'target' ); ?>[]" id="<?php echo $this->get_field_id( 'target' ); ?>" class="widefat">
                				<option value="_blank"><?php _e( 'Open New Window', 'kutetheme' ); ?></option>
                				<option value="_self"><?php _e( 'Stay in Window', 'kutetheme' ); ?></option>
                			</select>
                		</p>
                    </div>
            <?php } ?>
            
            <div style="text-align: right;" class="btn-template">
                <input type="button" class="button btn-plus" value="+" />
                <div class="template" style="display: none;">
                    <div class="item widget-content">
                        <span class="remove">X</span>
                        <p>
                            <label><?php _e('Title:', 'kutetheme'); ?></label> 
                            <input class="widefat widget-name" id="<?php echo $this->get_field_id('title'); ?>" tpl-name="<?php echo $this->get_field_name('title'); ?>[]" type="text" />
                        </p>
                        
                        <p style="text-align: center;">
                            <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e('Select your image', 'kutetheme') ?>" />
                            <input class="widefat widget-name kt_image_attachment" id="<?php echo $this->get_field_id('image'); ?>" tpl-name="<?php echo $this->get_field_name('image'); ?>[]" type="hidden" />
                        </p>
                        
                        <p class="kt_image_preview" style="display: none;">
                            <img src="" alt="" class="kt_image_preview_img" />
                        </p>
                        
                        <p>
                            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', 'kutetheme'); ?></label> 
                            <input class="widefat widget-name" id="<?php echo $this->get_field_id('link'); ?>" tpl-name="<?php echo $this->get_field_name('link'); ?>[]" type="text" />
                        </p>
                        
                        <p>
                			<label><?php _e( 'Target:', 'kutetheme'); ?></label>
                			<select tpl-name="<?php echo $this->get_field_name('target'); ?>[]" id="<?php echo $this->get_field_id('target'); ?>" class="widefat widget-name">
                				<option value="_blank"><?php _e('Open New Window', 'kutetheme'); ?></option>
                				<option value="_self"><?php _e('Stay in Window', 'kutetheme'); ?></option>
                			</select>
                		</p>
                    </div>
                </div>
            </div>
            <p></p>
        </div>
    <?php
	}

}
add_action( 'widgets_init', function(){
    register_widget( 'Widget_KT_Trademark_Payment' );
} );