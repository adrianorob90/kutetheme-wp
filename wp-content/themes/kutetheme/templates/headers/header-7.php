<?php
/**
 * The template Header
 *
 *
 * @author 		KuteTheme
 * @package 	THEME/WooCommerce
 * @version     KuteTheme 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="option7">
<!-- HEADER -->
<div id="header" class="header">
    <div class="top-header">
        <div class="container">
            <?php echo kt_get_hotline(); ?>
            <?php kt_get_social_header();?>
            <?php 
                if( kt_is_wc() ): 
                    do_action('kt_mini_cart');
                 endif; 
             ?>
            <div class="support-link">
                <a href="<?php kt_service_link(); ?>"><?php esc_html_e( 'Services', 'kutetheme' ) ?></a>
                <a href="<?php kt_support_link(); ?>"><?php esc_html_e( 'Support', 'kutetheme' ) ?></a>
            </div>
            <?php echo kt_menu_my_account(); ?>
        </div>
    </div>
    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div id="main-header">
        <div class="container main-header">
            <div class="row">
                <div class="col-xs-12 col-sm-3 logo">
                    <?php echo kt_get_logo(); ?>
                </div>
                <div id="main-menu" class="col-sm-12 col-md-9 main-menu">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <a class="navbar-brand" href="#"><?php _e( 'MENU', 'kutetheme' ) ?></a>
                            </div>
                            <div id="navbar" class="navbar-collapse collapse">
                                <?php kt_setting_mega_menu(); ?>
                            </div><!--/.nav-collapse -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- END MANIN HEADER -->
    <?php 
    $args = array(
          'post_type'      => 'service',
          'orderby'        => 'date',
          'order'          => 'desc',
          'post_status'    => 'publish',
          'posts_per_page' => 4,
    );
    $taxonomy = kt_get_setting_service_category();
    if( $taxonomy ){
        $args['tax_query'] = 
            array(
        		array(
                    'taxonomy' => 'service_cat',
                    'field'    => 'id',
                    'terms'    => explode( ",", $taxonomy )
        	)
        );
    }
    $service_query = new WP_Query( $args );
    if( $service_query->have_posts() ) :
    ?>
    <div class="service-header">
        <div class="container">
            <div class="row">
                <?php while( $service_query->have_posts() ): $service_query->the_post(); ?>
                <div class="col-sm-6 col-md-3">
                    <div class="item">
                        <a href="<?php the_permalink() ?>">
                            <?php if(has_post_thumbnail()):?>
                                <?php the_post_thumbnail(array(54, 54));?>
                            <?php endif; ?>
                            <span><?php the_title() ?></span>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php do_action( 'kt_show_menu_option_7' ) ?>
</div>
<!-- end header -->
</div>