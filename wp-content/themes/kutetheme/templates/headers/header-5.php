<div class="option5">
<!-- HEADER -->
<div id="header" class="header">
    <div class="top-header">
        <div class="container">
            <!--Currency-->
            <?php echo kt_get_wpml(); ?>
            <div class="top-bar-social">
                <?php kt_get_social_header();?>
            </div>
            <div class="support-link">
                <a href="<?php kt_about_us_link(); ?>"><?php esc_html_e( 'Abount Us', 'kutetheme' ) ?></a>
                <a href="<?php kt_support_link(); ?>"><?php esc_html_e( 'Support', 'kutetheme' ) ?></a>
            </div>

            <?php echo kt_menu_my_account(); ?>
        </div>
    </div>
    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div class="container main-header">
        <div class="row">
            <div class="col-xs-4 col-sm-12 col-md-5 col-lg-4 header-search-box">
                <?php kt_search_form();  ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 logo">
                <?php echo kt_get_logo(); ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 group-button-header">
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
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
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
                                <a class="navbar-brand" href="#"><?php esc_html_e( 'Menu', 'kutetheme' ) ?></a>
                            </div>
                            <div id="navbar" class="navbar-collapse collapse">
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
                            </div><!--/.nav-collapse -->
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
                <div class="shopping-cart-box-ontop-content"></div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
<!-- end header -->
</div>