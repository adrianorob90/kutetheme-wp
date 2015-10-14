<!-- HEADER -->
<div id="header" class="header option4">
    <div class="top-header">
        <div class="container">
            <?php echo kt_get_hotline(); ?>
            <div class="support-link">
                <a href="<?php kt_about_us_link(); ?>"><?php esc_html_e( 'Abount Us', 'kutetheme' ) ?></a>
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
                <div id="main-menu" class="col-sm-12 col-md-8 main-menu">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <a class="navbar-brand" href="#"><?php esc_html_e( 'Menu', 'kutetheme' ) ?></a>
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
                            ?>
                        </div>
                    </nav>
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
    <div class="nav-top-menu">
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
                            ?>
                            <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                        </div>
                    </div>
                </div>
                <?php if( kt_is_wpml() ): ?>
                    <div class="col-sm-5 col-md-7 formsearch-option4 kt-wpml">
                        <?php kt_search_form();  ?>
                    </div>
                    <div class="col-sm-4 col-md-2 group-link-main-menu">
                        <?php echo kt_get_wpml(); ?>
                    </div>
                <?php else: ?>
                    <div class="col-sm-9 formsearch-option4">
                        <?php kt_search_form();  ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- end header -->