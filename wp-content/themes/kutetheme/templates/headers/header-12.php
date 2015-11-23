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
<!-- HEADER -->
<div id="header" class="header option12 style12">
    <div class="header-top">
        <div class="container">
            <div class="top-right">
                <div class="header-setting user-info">
                    <ul class="top-links">
                        <li class="login"> <a href="#" title="Log In">Log In </a></li>
                        <li class="first"> <a id="quick_sigup_link" href="#" title="Register">Register </a></li>
                        <li><a title="My wishlist" href="#" target="_blank" class="btn-heart">wishlist</a></li>
                    </ul>
                </div>
                <!--Currency-->
                <!--./ End Currency-->
                <!--Language-->
                <!--./ End Language-->
            </div>
            <div class="top-left">
                <div class="contact-info">
                    <span><i class="fa fa-phone"></i> HotLine: + 006 258 658</span>
                    <a href="#" title="Facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" title="Twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" title="Skype"><i class="fa fa-skype"></i></a>
                    <a href="#" title="Google Plus"><i class="fa fa-google-plus"></i></a>
    
                </div>
            </div>
        </div>
    </div><!--./ End top menu-->
    <div class="container main-header">
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 logo">
                <?php echo kt_get_logo(); ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-9">
                <div id="main-menu" class="main-menu menu-option11">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <a class="navbar-brand" href="#"><?php _e( 'MENU', 'kutetheme' ); ?></a>
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
    <!--./End Main Header-->
    
    <div class="container">
        <div class="header-control">
            <div class="vertical-menu-wapper">
                <div class="box-vertical-megamenus">
                    <h4 class="title">
                        <span class="title-menu">Categories</span>
                        <span class="btn-open-mobile pull-right home-page"><i class="fa fa-angle-down"></i></span>
                    </h4>
                    <div class="vertical-menu-content is-home">
                        <?php kt_setting_vertical_menu(); ?>
                        <div class="all-category"><span class="open-cate"><?php _e( 'All Categories', 'kutetheme' ); ?></span></div>
                    </div>
                </div>
            </div>
            <div class="form-search-wapper">
                <?php kt_search_form();  ?>
            </div>
            <?php 
                if( kt_is_wc() ): 
                    do_action('kt_mini_cart');
                 endif; 
             ?>
        </div>
    </div>
</div>
<!--./ END HEADER -->