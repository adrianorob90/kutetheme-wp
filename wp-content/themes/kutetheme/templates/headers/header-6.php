<!-- HEADER -->
<div id="header" class="header option6">
    <div class="top-header">
        <div class="container">
            <?php echo kt_get_hotline(); ?>
            <?php echo kt_get_wpml(); ?>
            <?php kt_get_social_header();?>
            <div class="support-link">
                <a href="<?php kt_service_link(); ?>"><?php _e( 'Services', 'kutetheme' ) ?></a>
                <a href="<?php kt_support_link(); ?>"><?php _e( 'Support', 'kutetheme' ) ?></a>
            </div>
            <?php echo kt_menu_my_account(); ?>
        </div>
    </div>
    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo">
                   <?php echo kt_get_logo(); ?>
                </div>
                <div class="header-search-box <?php echo kt_is_wc() ? 'col-xs-7 col-sm-7' : 'col-xs-9'; ?>">
                    <?php kt_search_form();  ?>
                    <?php kt_get_hot_product_tags(3);?>
                </div>
                <?php 
                    if( kt_is_wc() ): 
                        do_action('kt_mini_cart');
                     endif; 
                 ?>
            </div>
        </div>
    </div>
    <!-- END MANIN HEADER -->
    <div id="nav-top-menu" class="nav-top-menu">
        <div class="container">
            <div class="row">
                <div class="col-sm-3" id="box-vertical-megamenus">
                    <div class="box-vertical-megamenus">
                    <h4 class="title">
                        <span class="btn-open-mobile"><i class="fa fa-bars"></i></span>
                        <span class="title-menu"><?php _e('Categories','kutetheme');?></span>
                    </h4>
                    <div class="vertical-menu-content is-home">
                        <?php
                            wp_nav_menu( array(
                                'menu'              => 'vertical',
                                'theme_location'    => 'vertical',
                                'depth'             => 2,
                                'container'         => '',
                                'container_class'   => '',
                                'container_id'      => '',
                                'menu_class'        => 'vertical-menu-list',
                                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                'walker'            => new wp_bootstrap_navwalker())
                            );
                        ?><!--/.nav-collapse -->
                        <div class="all-category"><span class="open-cate">All Categories</span></div>
                    </div>
                </div>
                </div>
                <div id="main-menu" class="col-sm-9 main-menu">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <a class="navbar-brand" href="#">MENU</a>
                            </div>
                            <?php
                                wp_nav_menu( array(
                                    'menu'              => 'primary',
                                    'theme_location'    => 'primary',
                                    'depth'             => 2,
                                    'container'         => 'div',
                                    'container_class'   => 'collapse navbar-collapse',
                                    'container_id'      => 'navbar',
                                    'menu_class'        => 'nav navbar-nav',
                                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                    'walker'            => new wp_bootstrap_navwalker())
                                );
                            ?><!--/.nav-collapse -->
                        </div>
                    </nav>
                </div>
            </div>
            <!-- userinfo on top-->
            <div id="form-search-opntop">
            </div>
            <!-- userinfo on top-->
            <div id="user-info-opntop">
            </div>
            <?php if( kt_is_wc() ):  ?>
            <!-- CART ICON ON MMENU -->
            <div id="shopping-cart-box-ontop">
                <i class="fa fa-shopping-cart"></i>
                <div class="shopping-cart-box-ontop-content">
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
<!-- end header -->