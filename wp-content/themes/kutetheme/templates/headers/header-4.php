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
                            <?php kt_setting_mega_menu(); ?><!--/.nav-collapse -->
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
            <?php do_action( 'kt_show_vertical_menu_option_4' ); ?>
        </div>
    </div>
</div>
<!-- end header -->