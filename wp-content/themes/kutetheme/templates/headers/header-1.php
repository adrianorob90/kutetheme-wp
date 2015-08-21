<!-- HEADER -->
<div id="header" class="header">
    <div class="top-header">
        <div class="container">
            <?php echo kt_get_hotline(); ?>
            <?php echo kt_get_wpml(); ?>
            
            <div class="support-link">
                <a href="<?php kt_service_link(); ?>"><?php _e( 'Services', THEME_LANG ) ?></a>
                <a href="<?php kt_support_link(); ?>"><?php _e( 'Support', THEME_LANG ) ?></a>
            </div>
            <?php echo kt_menu_my_account(); ?>
        </div>
    </div>
    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div class="container main-header">
        <div class="row">
            <div class="col-xs-12 col-sm-3 logo">
                <?php echo kt_get_logo(); ?>
            </div>
            <div class="header-search-box <?php echo kt_is_wc() ? 'col-xs-7 col-sm-7' : 'col-xs-12'; ?>">
                <?php kt_search_form();  ?>
            </div>
            <?php 
                echo kt_cart_button();
            ?>
        </div>
        
    </div>
    <!-- END MANIN HEADER -->
    <div id="nav-top-menu" class="nav-top-menu">
        <div class="container">
            <div class="row">
                <div class="col-sm-3" id="box-vertical-megamenus">
                    <div class="box-vertical-megamenus">
                        <h4 class="title">
                            <span class="title-menu">Categories</span>
                            <span class="btn-open-mobile pull-right home-page"><i class="fa fa-bars"></i></span>
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
            <!-- CART ICON ON MMENU -->
            <div id="shopping-cart-box-ontop">
                <i class="fa fa-shopping-cart"></i>
                <div class="shopping-cart-box-ontop-content"></div>
            </div>
        </div>
    </div>
</div>
<!-- end header -->